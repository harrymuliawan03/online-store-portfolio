<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    public function index(Request $request, $id)
    {
        $data['product'] = Product::with(['galleries', 'user'])->where('slug', $id)
            ->whereHas('user', fn($query) => $query->where('name', $request->user))->firstOrFail();

        return view('pages.detail', $data);
    }
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $checkCart = Cart::where('users_id', auth()->user()->id)->where('products_id', $id)->get();
        if($checkCart->count() == 0) {
            $data = [
                'products_id'   => $id,
                'users_id'      => auth()->user()->id,
                'store_id'      => $product->users_id,
                'qty'           => 1
            ];
            Cart::create($data);
        }

        return redirect()->route('cart');
    }
}