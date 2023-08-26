<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartStockController extends Controller
{
    public function check(Request $request)
    {
        $data = Cart::with('product')->findOrFail($request->id);
        if($request->qty > $data->product->stock) {
            $data->update(['qty' => $data->product->stock]);
            return response()->json([
                'qty' => $data->product->stock,
                'check' => 'Unavailable'
        ]);
        }elseif($request->qty == 0){
            $data->delete();
            return response()->json(['check' => 'Redirect']);
        }else{
            $data->update(['qty' => $request->qty]);
            return response()->json(['check' => 'Available']);
        }
    }
}