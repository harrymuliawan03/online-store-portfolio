<?php

namespace App\Http\Controllers\Admin;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\ProductGallery;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Admin\ProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(request()->ajax())
        {
            $query = Product::with(['user', 'category']);

            return DataTables::of($query)
                ->addColumn('action', function($item) {
                    return '
                        <div class="btn-group">
                            <a href="'. route('product.edit', $item->id) .'" class="btn btn-primary border-0 mr-1">Edit</a>
                            <form action="'. route('product.destroy', $item->id) .'" method="POST" id="form'. $item->id .'">
                                        '. method_field('delete') . csrf_field() .'
                                        <button type="button" class="btn btn-danger border-0 modalDelete" data-id="'. $item->id .'">Delete</button>
                            </form>
                        </div>
                    ';
                })
                ->rawColumns(['action'])
                ->make();
        }
        
        return view('pages.admin.product.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['categories'] = Category::all();
        return view('pages.admin.product.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $data = $request->all();
        $data['users_id'] = auth()->user()->id;
        $data['slug'] = Str::slug($request->name);

        Product::create($data);
        // $product = Product::create($data);
        // Looping for add Photo galleries
        // $photoGalleries = [];
        // for($i = 0; $i < count($request->file_image); $i++)
        //     {
        //         $photoGalleries []= [
        //             'photo'         => $request->file('file_image')[$i]->store('assets/product', 'public'),
        //             'products_id'   => $product->id,
        //         ];
        //     }
        //     ProductGallery::insert($photoGalleries);


        return redirect()->route('product.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $query = Product::findOrFail($id);
        $data['item'] = $query;
        $data['categories'] = Category::all();
        
        return view('pages.admin.product.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, string $id)
    {
        $data = $request->all();
        $item = Product::findOrFail($id);
        $data['slug'] = Str::slug($request->name);
        
        $item->update($data);

        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Delete product
        $product = Product::findOrFail($id);
        $product->delete();

        // Also delete product in cart
        $productCart = Cart::where('products_id', $id)->get();
        foreach ($productCart as $cart) {
            $cart->delete();
        }

        // Also delete product galleries
        $productGallery = ProductGallery::where('products_id', $id)->get();
        
        // Also delete image in storage
        foreach ($productGallery as $item) {
            $item->delete();
            Storage::disk('public')->delete($item->photos);
        }

        return redirect()->route('product.index');
    }

}