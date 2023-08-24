<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductGallery;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\ProductRequest;

class DashboardProductsController extends Controller
{
    public function index()
    {
        $data['products'] = Product::with(['galleries', 'user', 'category'])
                                    ->where('users_id', auth()->user()->id)->get();
        return view('pages.dashboard-products', $data);
    }
    
    public function create()
    {
        $data['categories'] = Category::all();
        return view('pages.dashboard-products-create', $data);
    }
    public function store(ProductRequest $request)
    {
        $data = $request->all();
        $data['users_id'] = auth()->user()->id;
        $data['slug'] = Str::slug($request->name);

        $product = Product::create($data);
        // Looping for add Photo galleries
        $photoGalleries = [];
        for($i = 0; $i < count($request->file_image); $i++)
        {
            $photoGalleries []= [
                'photos'         => $request->file('file_image')[$i]->store('assets/product', 'public'),
                'products_id'   => $product->id,
                'created_at'    => Carbon::now()->toDateTimeString(),
            ];
        }
        ProductGallery::insert($photoGalleries);


        return redirect()->route('products');
    }
    
    public function update(ProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);

        $data = $request->all();
        $data['users_id'] = auth()->user()->id;
        $data['slug'] = Str::slug($request->name);
        
        $product->update($data);

        
        return redirect()->route('products');
    }

    

    public function detail($id)
    {
        $data['product'] = Product::with(['galleries', 'user', 'category'])
                                    ->findOrFail($id);
        $data['categories'] = Category::all();

        return view('pages.dashboard-products-details', $data);
    }

    public function uploadGallery(Request $request)
    {
        $data = $request->all();
        $data['photos'] = $request->file('photos')->store('assets/product', 'public');
        
        ProductGallery::create($data);

        return redirect()->route('product-details', $request->products_id);
    }

    public function deleteGallery($id)
    {
        $item = ProductGallery::findOrFail($id);
        Storage::disk('public')->delete($item->photos);
        $item->delete();

        return redirect()->route('product-details', $item->products_id);
    }
}