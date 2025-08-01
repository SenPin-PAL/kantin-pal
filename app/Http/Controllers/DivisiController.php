<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Models\Product;
use App\Models\Order;

class DivisiController extends Controller
{
    /**
     * Menampilkan halaman untuk membuat pesanan dari SEMUA outlet.
     */
    // public function createOrder()
    // {
    //     // Ambil semua produk yang stoknya ada, dan eager load relasi outlet-nya
    //     // untuk ditampilkan di view. Urutkan berdasarkan nama outlet.
    //     $products = Product::where('stock', '>', 0)
    //         ->with('outlet')
    //         ->get()
    //         ->sortBy('outlet.name');
        
    //     return view('divisi.order.create', compact('products'));
    // }

    public function createOrder()
    {
        $products = Product::where('stock', '>', 0)
            ->with('outlet')
            ->orderBy('outlet_id')
            ->paginate(8);
    
        return view('divisi.order.create', compact('products'));
    }
    


    /**
     * Menyimpan pesanan baru ke database.
     * Logika ini akan secara otomatis membuat pesanan terpisah untuk setiap outlet.
     */
    public function storeOrder(Request $request)
    {
        // 1. Filter produk yang kuantitasnya lebih dari 0
        $orderedProducts = array_filter($request->input('products', []), function ($product) {
            return isset($product['quantity']) && $product['quantity'] > 0;
        });

        if (empty($orderedProducts)) {
            return back()->withInput()->withErrors(['error' => 'Anda harus memesan setidaknya satu item.']);
        }

        // 2. Kelompokkan produk berdasarkan outlet_id
        $ordersByOutlet = [];
        foreach ($orderedProducts as $item) {
            // Ambil data produk dari DB untuk mendapatkan outlet_id yang valid
            $product = Product::find($item['id']);
            if ($product) {
                // Simpan detail item ke dalam array yang dikelompokkan oleh ID outlet
                $ordersByOutlet[$product->outlet_id][] = [
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price_per_item' => $product->price,
                    'product_name' => $product->name, // Simpan nama untuk pesan error
                    'current_stock' => $product->stock, // Simpan stok untuk validasi
                    'description' => $product->description, // Simpan deskripsi untuk detail pesanan
                ];
            }
        }

        try {
            DB::beginTransaction();

            // 3. Loop untuk setiap outlet dan buat pesanan terpisah
            foreach ($ordersByOutlet as $outletId => $items) {
                
                // Buat record Order utama untuk outlet ini
                $order = Order::create([
                    'user_id' => Auth::id(),
                    'outlet_id' => $outletId,
                    'status' => 'pending',
                    'total_bill' => 0, // Akan di-update nanti
                ]);

                $totalBill = 0;

                // Loop untuk setiap item dalam pesanan untuk outlet ini
                foreach ($items as $item) {
                    // Validasi stok sekali lagi di dalam transaksi
                    $product = Product::where('id', $item['product_id'])->lockForUpdate()->first();
                    if ($item['quantity'] > $product->stock) {
                        throw ValidationException::withMessages([
                            'products' => "Stok untuk '{$item['product_name']}' di outlet terkait tidak mencukupi. Sisa: {$product->stock}.",
                        ]);
                    }

                    // Buat Order Item
                    $order->items()->create($item);

                    // Akumulasi total tagihan & kurangi stok
                    $totalBill += $item['price_per_item'] * $item['quantity'];
                    $product->decrement('stock', $item['quantity']);
                }

                // Update total tagihan pada pesanan utama
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
