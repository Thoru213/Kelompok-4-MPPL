<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; // Tambahkan ini untuk Log::error

class CartController extends Controller
{
    /**
     * Menampilkan daftar item di keranjang.
     */
    public function index()
    {
        $cartItems = $this->getCartItems();
        return view('cart.index', compact('cartItems'));
    }

    /**
     * Menambahkan produk ke keranjang.
     */
    public function add(Request $request, Product $product)
    {
        $quantity = $request->input('quantity', 1);

        // Validasi sederhana, Anda bisa tambahkan lebih lanjut
        if ($quantity < 1 || $quantity > $product->stock) {
            return redirect()->back()->with('error', 'Jumlah produk tidak valid atau melebihi stok yang tersedia.');
        }

        $cart = $this->getOrCreateCartItem($product);

        $cart->quantity += $quantity;
        $cart->save();

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    /**
     * Memperbarui jumlah produk di keranjang.
     */
    public function update(Request $request, Cart $cart)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Tambahkan validasi stok jika perlu
        if ($request->input('quantity') > $cart->product->stock) {
            return redirect()->back()->with('error', 'Jumlah yang diminta melebihi stok yang tersedia.');
        }

        $cart->quantity = $request->input('quantity');
        $cart->save();

        return redirect()->back()->with('success', 'Jumlah produk di keranjang berhasil diperbarui!');
    }

    /**
     * Menghapus produk dari keranjang.
     */
    public function remove(Cart $cart)
    {
        $cart->delete();
        return redirect()->back()->with('success', 'Produk berhasil dihapus dari keranjang!');
    }

    /**
     * Helper function untuk mendapatkan item keranjang berdasarkan user atau session.
     */
    private function getCartItems()
    {
        if (Auth::check()) {
            return Cart::where('user_id', Auth::id())->with('product')->get();
        } else {
            $sessionId = Session::getId();
            return Cart::where('session_id', $sessionId)->with('product')->get();
        }
    }

    /**
     * Helper function untuk mendapatkan atau membuat item keranjang baru.
     */
    private function getOrCreateCartItem(Product $product)
    {
        if (Auth::check()) {
            return Cart::firstOrCreate(
                ['user_id' => Auth::id(), 'product_id' => $product->id],
                ['quantity' => 0] // Inisialisasi quantity ke 0 karena kita akan menambahkannya
            );
        } else {
            $sessionId = Session::getId();
            return Cart::firstOrCreate(
                ['session_id' => $sessionId, 'product_id' => $product->id],
                ['quantity' => 0]
            );
        }
    }

    /**
     * Menggabungkan keranjang tamu dengan keranjang user saat login.
     */
    public static function mergeCarts()
    {
        if (Auth::check()) {
            $sessionId = Session::getId();
            $guestCartItems = Cart::where('session_id', $sessionId)->get();

            foreach ($guestCartItems as $guestItem) {
                $userCartItem = Cart::firstOrNew(
                    ['user_id' => Auth::id(), 'product_id' => $guestItem->product_id]
                );

                $userCartItem->quantity += $guestItem->quantity;
                $userCartItem->session_id = null; // Hapus session_id setelah digabung
                $userCartItem->save();

                $guestItem->delete(); // Hapus item keranjang tamu
            }
        }
    }

    // --- METODE CHECKOUT BARU ---

    /**
     * Menampilkan formulir checkout dengan item di keranjang.
     */
    public function checkout()
    {
        $cartItems = $this->getCartItems();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong. Tidak dapat melanjutkan ke checkout.');
        }

        // Hitung total belanja
        $grandTotal = 0;
        foreach ($cartItems as $item) {
            $grandTotal += ($item->product->price * $item->quantity);
        }

        // Jika user login, bisa isi form awal dengan data user
        $user = Auth::user();

        return view('checkout.index', compact('cartItems', 'grandTotal', 'user'));
    }

    /**
     * Memproses data formulir checkout dan membuat order.
     */
    public function processCheckout(Request $request)
    {
        // 1. Validasi Input Formulir
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'shipping_address' => 'required|string',
            // Anda bisa menambahkan validasi lain seperti payment_method jika ada
        ]);

        $cartItems = $this->getCartItems();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong. Tidak dapat membuat pesanan.');
        }

        // 2. Hitung Total Jumlah dari Keranjang
        $totalAmount = 0;
        foreach ($cartItems as $item) {
            $totalAmount += ($item->product->price * $item->quantity);
        }

        // Menggunakan transaksi database untuk memastikan integritas data
        DB::beginTransaction();
        try {
            // 3. Buat Order Baru
            $order = Order::create([
                'user_id' => Auth::id(), // Akan null jika guest
                'session_id' => Auth::check() ? null : Session::getId(), // Hanya isi jika guest
                'total_amount' => $totalAmount,
                'status' => 'pending', // Atau 'processing'
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone,
                'shipping_address' => $request->shipping_address,
            ]);

            // 4. Pindahkan Item dari Keranjang ke Order_Items
            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'product_name' => $cartItem->product->name, // Ambil nama dari produk saat ini
                    'price' => $cartItem->product->price,       // Ambil harga dari produk saat ini
                    'quantity' => $cartItem->quantity,
                ]);

                // Opsional: Kurangi stok produk
                $product = Product::find($cartItem->product_id);
                if ($product) {
                    // Pastikan tidak mengurangi stok di bawah nol
                    $newStock = $product->stock - $cartItem->quantity;
                    if ($newStock < 0) {
                        // Jika stok tidak cukup, batalkan transaksi dan lemparkan error
                        DB::rollBack();
                        return redirect()->back()->with('error', 'Stok untuk ' . $product->name . ' tidak cukup.');
                    }
                    $product->stock = $newStock;
                    $product->save();
                }
            }

            // 5. Kosongkan Keranjang Setelah Berhasil Membuat Order
            if (Auth::check()) {
                Cart::where('user_id', Auth::id())->delete();
            } else {
                Cart::where('session_id', Session::getId())->delete();
            }

            DB::commit(); // Komit transaksi jika semua berhasil

            // Redirect ke halaman sukses atau detail order
            return redirect()->route('checkout.success', $order->id)->with('success', 'Pesanan Anda berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack(); // Rollback transaksi jika terjadi error
            Log::error('Checkout Error: ' . $e->getMessage()); // Catat error ke log Laravel
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses pesanan Anda. Mohon coba lagi. ' . $e->getMessage());
        }
    }

    /**
     * Metode untuk menampilkan halaman sukses (opsional).
     */
    public function success(Order $order)
    {
        return view('checkout.success', compact('order'));
    }
}