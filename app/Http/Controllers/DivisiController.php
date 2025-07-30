<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class DivisiController extends Controller
{
    /**
     * Menampilkan halaman untuk membuat pesanan dengan fungsionalitas pencarian dan paginasi.
     */
    public function createOrder(Request $request)
    {
        $search = $request->input('search');

        $query = Product::where('stock', '>', 0)->with('outlet');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'ILIKE', "%{$search}%")
                  ->orWhere('description', 'ILIKE', "%{$search}%");
            });
        }

        // Mengganti get() dengan paginate()
        // Angka 8 berarti 8 produk per halaman. Anda bisa mengubahnya.
        $products = $query->orderBy('outlet_id')->orderBy('name')->paginate(8);
        
        return view('divisi.order.create', compact('products'));
    }

    /**
     * Menyimpan pesanan baru ke database.
     */
    public function storeOrder(Request $request)
    {
        $orderedProducts = array_filter($request->input('products', []), function ($product) {
            return isset($product['quantity']) && $product['quantity'] > 0;
        });

        if (empty($orderedProducts)) {
            return back()->withInput()->withErrors(['error' => 'Anda harus memesan setidaknya satu item.']);
        }

        $ordersByOutlet = [];
        foreach ($orderedProducts as $item) {
            $product = Product::find($item['id']);
            if ($product) {
                $ordersByOutlet[$product->outlet_id][] = [
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price_per_item' => $product->price,
                ];
            }
        }

        try {
            DB::beginTransaction();

            foreach ($ordersByOutlet as $outletId => $items) {
                $order = Order::create([
                    'user_id' => Auth::id(),
                    'outlet_id' => $outletId,
                    'status' => 'pending',
                    'total_bill' => 0,
                ]);

                $totalBill = 0;

                foreach ($items as $item) {
                    $product = Product::where('id', $item['product_id'])->lockForUpdate()->first();
                    if ($item['quantity'] > $product->stock) {
                        throw ValidationException::withMessages([
                            'products' => "Stok untuk produk terkait tidak mencukupi.",
                        ]);
                    }

                    $order->items()->create($item);
                    $totalBill += $item['price_per_item'] * $item['quantity'];
                    $product->decrement('stock', $item['quantity']);
                }

                $order->total_bill = $totalBill;
                $order->save();
            }

            DB::commit();

            return redirect()->route('divisi.dashboard')->with('success', 'Pesanan berhasil dibuat dan sedang menunggu persetujuan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Terjadi kesalahan saat memproses pesanan: ' . $e->getMessage()]);
        }
    }

    public function dashboard()
    {
        $myOrders = Order::where('user_id', Auth::id())->with('outlet')->latest()->paginate(15);
        return view('divisi.dashboard', compact('myOrders'));
    }
}
