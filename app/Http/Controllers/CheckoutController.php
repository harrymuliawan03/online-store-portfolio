<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Exception;

use Midtrans\Snap;
use Midtrans\Config;
use App\Models\User;

class CheckoutController extends Controller
{
    public function index(Request $request, $id)
    {
        $data['carts'] = Cart::with(['product.galleries', 'user'])->where('store_id', $id)->where('users_id', auth()->user()->id)->get();
        $data['user'] = User::with(['provinces', 'regency'])->findOrFail(auth()->user()->id);
        
        return view('pages.checkout', $data);
    }
    public function process(Request $request)
    {
        // Save users data
        $user = auth()->user();
        $user->update($request->except('total_price'));

        // Proses checkout
        $code = 'STORE-' . mt_rand(000000, 999999); 
        $carts = Cart::with(['product', 'user'])
                    ->where('users_id', auth()->user()->id)
                    ->get();
       
        // Transaction create
        $transaction = Transaction::create([
            'users_id' => auth()->user()->id,
            'insurance_price' => 0,
            'shipping_price' => 0,
            'total_price' => $request->total_price,
            'payment_status' => 'PENDING',
            'transaction_status' => 'PENDING',
            'code' => $code,
        ]);

        foreach ($carts as $cart) {
            $trx = 'TRX-' . mt_rand(000000, 999999); 
            $product = Product::findOrFail($cart->products_id);
            
            $product->update(['stock' => $product->stock - $cart->qty]);
            TransactionDetail::create([
                'transactions_id' => $transaction->id,
                'products_id' => $cart->product->id,
                'qty' => $cart->qty,
                'price' => $cart->product->price,
                'code' => $trx,
            ]);
        }
        
        
        // Delete cart data
        Cart::where('users_id', auth()->user()->id)->delete();

        // Konfigurasi Midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        // Buat Array untuk dikirim ke Midtrans
        $midtrans = [
            'transaction_details' => [
                'order_id' => $code,
                'gross_amount' => (int) $request->total_price
            ],
            'customer_details' => [
                'first_name' => auth()->user()->name,
                'email' => auth()->user()->email,
            ],
            'enabled_payments' => [
                'gopay', 'permata_va', 'bank_transfer'
            ],
            'vtweb' => []
        ];

        try {
            // Get Snap Payment Page URL
            $paymentUrl = Snap::createTransaction($midtrans)->redirect_url;
            
            // // Redirect to Snap Payment Page
            // header('Location: ' . $paymentUrl);
            return redirect($paymentUrl);
        }
            catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function callback(Request $request)
    {
        
    }
}