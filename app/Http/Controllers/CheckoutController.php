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
    
    public function all($id)
    {
        $data['stores'] =  Cart::where('users_id', auth()->user()->id)->get()->unique('store_id');
        if($id == auth()->user()->id && $data['stores']->count() > 0) {
            $data['carts'] = Cart::with(['product.galleries', 'user'])->where('users_id', auth()->user()->id)->get();
            $data['user'] = User::with(['provinces', 'regency'])->findOrFail(auth()->user()->id);
            
            return view('pages.checkout-all', $data);
        }else {
            return redirect()->route('home');
        }
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
            'service_fee' => $request->total_price * 2 / 100,
            'payment_status' => 'SUCCESS',
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

    public function delete(Request $request, $id)
    {
        $cart = Cart::findOrFail($id);
        
        $cart->delete();
        
        $checkCart = Cart::where('users_id', auth()->user()->id)->get();

        if($checkCart->count() == 0) {
            return redirect()->route('home');
        }else{
            if($request->url == 'checkout-all')
            {            
                return redirect()->route('checkout-all', auth()->user()->id);
            }else {
                
                return redirect()->route('checkout', $cart->store_id);
            }
        }

    }
    
    public function processAll()
    {
        $stores =  Cart::where('users_id', auth()->user()->id)->get()->unique('store_id');
        $code_checkout_all = 'SCA-' . auth()->user()->id . '-' . mt_rand(000000, 999999);
        $grand_total = 0;
        // Save users data
        // $user = auth()->user();
        // $user->update($request->except('total_price'));
        foreach ($stores as $store) {
            // Proses checkout
            $code = 'STORE-' . mt_rand(000000, 999999); 
            $carts = Cart::with(['product', 'user'])
                        ->where('users_id', auth()->user()->id)
                        ->where('store_id', $store->store_id)
                        ->get();
            $total_price = 0;
            foreach ($carts as $cart) {
                $total_price += $cart->product->price * $cart->qty;
                $grand_total += $cart->product->price * $cart->qty;
            }
            // Transaction create
            $transaction = Transaction::create([
                'users_id' => auth()->user()->id,
                'insurance_price' => 0,
                'shipping_price' => 0,
                'total_price' => $total_price,
                'service_fee' => $total_price * 2 / 100,
                'payment_status' => 'SUCCESS',
                'transaction_status' => 'PENDING',
                'code' => $code,
                'code_checkout_all' => $code_checkout_all,
                
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
            Cart::where('users_id', auth()->user()->id)->where('store_id', $store->store_id)->delete();
        }
            // Konfigurasi Midtrans
                Config::$serverKey = config('services.midtrans.serverKey');
                Config::$isProduction = config('services.midtrans.isProduction');
                Config::$isSanitized = config('services.midtrans.isSanitized');
                Config::$is3ds = config('services.midtrans.is3ds');
        
                // Buat Array untuk dikirim ke Midtrans
                $midtrans = [
                    'transaction_details' => [
                        'order_id' => $code_checkout_all,
                        'gross_amount' => (int) $grand_total
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