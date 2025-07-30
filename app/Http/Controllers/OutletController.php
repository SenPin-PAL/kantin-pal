<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class OutletController extends Controller
{
    /**
     * Menampilkan dashboard dengan pesanan yang perlu dikerjakan.
     */
    public function dashboard()
    {
        $outletId = Auth::user()->outlet_id;
        $activeOrders = Order::where('outlet_id', $outletId)
            ->whereIn('status', ['approved', 'preparing'])
            ->with('user', 'items.product')
            ->latest()
            ->get();
            
        return view('outlet.dashboard', compact('activeOrders'));
    }

    /**
     * Menerima pesanan dan mengubah status menjadi 'preparing'.
     */
    public function startPreparation(Order $order)
    {
        if ($order->outlet_id !== Auth::user()->outlet_id || $order->status !== 'approved') {
            abort(403);
        }
        $order->update(['status' => 'preparing']);
        return back()->with('success', 'Pesanan #' . $order->id . ' telah diterima dan sedang disiapkan.');
    }

    /**
     * Menyelesaikan pesanan dan mengubah status menjadi 'completed'.
     */
    public function completeOrder(Order $order)
    {
        if ($order->outlet_id !== Auth::user()->outlet_id || $order->status !== 'preparing') {
            abort(403);
        }
        $order->update(['status' => 'completed']);
        return back()->with('success', 'Pesanan #' . $order->id . ' telah diselesaikan.');
    }
    
    // --- LAPORAN & RIWAYAT ---

    /**
     * Menampilkan halaman hub untuk memilih jenis laporan.
     */
    public function transactions()
    {
        return view('outlet.transactions');
    }

    /**
     * Menampilkan halaman rekapitulasi pembelian per divisi.
     */
    public function purchaseRecap(Request $request)
    {
        $request->validate(['filter' => 'nullable|string|in:today,week,month']);
        $filter = $request->input('filter', 'today');

        $query = Order::where('outlet_id', Auth::user()->outlet_id)
            ->where('status', 'completed')
            ->with('user');

        $this->applyDateFilter($query, $filter);
        $orders = $query->get();

        $recap = $orders->groupBy('user.name')->map(function ($userOrders) {
            return [
                'total_transactions' => $userOrders->count(),
                'total_purchase' => $userOrders->sum('total_bill'),
            ];
        })->sortByDesc('total_purchase');

        return view('outlet.recaps.purchases', compact('recap', 'filter'));
    }

    /**
     * Menampilkan halaman rekapitulasi penjualan per produk.
     */
    public function productRecap(Request $request)
    {
        $request->validate(['filter' => 'nullable|string|in:today,week,month']);
        $filter = $request->input('filter', 'today');

        $query = OrderItem::whereHas('order', function ($q) {
            $q->where('outlet_id', Auth::user()->outlet_id)->where('status', 'completed');
        });
        
        $query->whereHas('order', function($q) use ($filter) {
            $this->applyDateFilter($q, $filter, 'updated_at');
        });

        $items = $query->with('product')->get();

        $recap = $items->groupBy('product.name')->map(function ($productItems) {
            return [
                'total_quantity' => $productItems->sum('quantity'),
                'total_sales' => $productItems->sum(fn($item) => $item->quantity * $item->price_per_item),
            ];
        })->sortByDesc('total_sales');

        return view('outlet.recaps.products', compact('recap', 'filter'));
    }

    // --- METODE EKSPOR ---
    
    public function exportPurchaseRecap(Request $request)
    {
        $request->validate(['filter' => 'nullable|string|in:today,week,month']);
        $filter = $request->input('filter', 'today');

        $query = Order::where('outlet_id', Auth::user()->outlet_id)
            ->where('status', 'completed')
            ->with('user');

        $this->applyDateFilter($query, $filter);
        $orders = $query->get();

        $recap = $orders->groupBy('user.name')->map(function ($userOrders) {
            return [
                'total_transactions' => $userOrders->count(),
                'total_purchase' => $userOrders->sum('total_bill'),
            ];
        })->sortByDesc('total_purchase');

        $fileName = 'rekap_pembelian_' . $this->getDateRangeText($filter) . '.csv';
        $headers = $this->getCsvHeaders($fileName);

        $callback = function() use ($recap) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Nama Divisi', 'Jumlah Transaksi', 'Total Pembelian']);
            foreach ($recap as $name => $data) {
                fputcsv($file, [$name, $data['total_transactions'], $data['total_purchase']]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportProductRecap(Request $request)
    {
        $request->validate(['filter' => 'nullable|string|in:today,week,month']);
        $filter = $request->input('filter', 'today');
        
        $query = OrderItem::whereHas('order', function ($q) {
            $q->where('outlet_id', Auth::user()->outlet_id)->where('status', 'completed');
        });
        
        $query->whereHas('order', function($q) use ($filter) {
            $this->applyDateFilter($q, $filter, 'updated_at');
        });

        $items = $query->with('product')->get();

        $recap = $items->groupBy('product.name')->map(function ($productItems) {
            return [
                'total_quantity' => $productItems->sum('quantity'),
                'total_sales' => $productItems->sum(fn($item) => $item->quantity * $item->price_per_item),
            ];
        })->sortByDesc('total_sales');

        $fileName = 'rekap_produk_' . $this->getDateRangeText($filter) . '.csv';
        $headers = $this->getCsvHeaders($fileName);

        $callback = function() use ($recap) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Nama Produk', 'Total Terjual (Qty)', 'Total Penjualan']);
            foreach ($recap as $name => $data) {
                fputcsv($file, [$name, $data['total_quantity'], $data['total_sales']]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // --- HELPER METHODS ---
    private function applyDateFilter($query, $filter, $column = 'updated_at')
    {
        switch ($filter) {
            case 'week':
                $query->whereBetween($column, [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                break;
            case 'month':
                $query->whereBetween($column, [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
                break;
            case 'today':
            default:
                $query->whereDate($column, Carbon::today());
                break;
        }
    }

    private function getDateRangeText($filter)
    {
        switch ($filter) {
            case 'week': return 'minggu_ini';
            case 'month': return 'bulan_ini';
            default: return Carbon::today()->format('Y-m-d');
        }
    }

    private function getCsvHeaders($fileName)
    {
        return [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];
    }
}
