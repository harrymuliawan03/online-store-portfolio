<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $data['categories'] = Category::all();
        $data['products']   = Product::with('galleries')->paginate(32);
        return view('pages.category', $data);
    }
    public function detail($slug)
    {
        $data['categories'] = Category::all();
        $category           = Category::where('slug', $slug)->firstOrFail();
        $data['products']   = Product::with('galleries')->where('categories_id', $category->id)->paginate(32);
        return view('pages.category', $data);
    }
}