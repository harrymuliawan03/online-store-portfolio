<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['categories'] = Category::take(6)->get();
        $data['products']   = Product::with(['galleries'])
                                        ->whereHas('user', fn($query) => $query->where('store_status', 1))
                                        ->where('stock', '!=', 0)->get();
        return view('pages.home', $data);
    }
}