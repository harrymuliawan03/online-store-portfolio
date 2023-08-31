<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $data['carts'] = Cart::with(['product.galleries', 'user'])->where('users_id', auth()->user()->id)->get();
        $data['stores'] =  Cart::where('users_id', auth()->user()->id)->get()->unique('store_id');
        // $data['stores'] =  Cart::whereHas('user', fn($query) => $query->where('id', auth()->user()->id));
        $data['user'] = User::with(['provinces', 'regency'])->findOrFail(auth()->user()->id);
        // dd($data['user']->name);
        
        return view('pages.cart', $data);
    }
    
    public function delete(Request $request, $id)
    {
        $cart = Cart::findOrFail($id);
        
        $cart->delete();
        
        return redirect()->route('cart');
    }

    public function success()
    {
        return view('pages.checkout');
    }
    public function getFormCart($id) {
        $item = Cart::findOrfail($id);
        $form = 'form'. $item->id .'';
        
        $response['form'] = $form;
        return response()->json($response);
    }
    public function addQty($id)
    {
        $cart = Cart::findOrFail($id);
        $qty = $cart->qty + 1;
        if($cart->product->stock < $qty){
            $cart->update(['qty' => $cart->product->stock]);
        }else {
            $cart->update(['qty' => $qty]);
        }
        return redirect()->route('cart');
    }
    public function decreaseQty($id)
    {
        $cart = Cart::findOrFail($id);
        if($cart->qty == 1){
            $cart->delete();
            return redirect()->route('cart');
        }else {
            $qty = $cart->qty - 1;
            $cart->update(['qty' => $qty]);
        }
        return redirect()->route('cart');
    }
}