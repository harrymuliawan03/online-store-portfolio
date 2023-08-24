<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\ProductGallery;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Admin\ProductGalleryRequest;

class ProductGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(request()->ajax())
        {
            $query = ProductGallery::with('product');

            return DataTables::of($query)
                ->addColumn('action', function($item) {
                    return '
                        <div class="btn-group">
                            <form action="'. route('product-gallery.destroy', $item->id) .'" method="POST">
                                        '. method_field('delete') . csrf_field() .'
                                        <button type="button" class="btn btn-danger border-0 modalDelete" data-id="'. $item->id .'">Delete</button>
                            </form>
                        </div>
                    ';
                })
                ->editColumn('photos', function($item) {
                    return $item->photos ? '<img src="'. Storage::url($item->photos) .'" style="max-height: 80px;" />' : '';
                })
                ->rawColumns(['action', 'photos'])
                ->make();
        }
        
        return view('pages.admin.product-gallery.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['products'] = Product::all();
        return view('pages.admin.product-gallery.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductGalleryRequest $request)
    {
        // $data = $request->all();

        // $product = Product::create($data);
        // Looping for add Photo galleries
        
        // Looping for add Photo galleries
        $photoGalleries = [];
        for($i = 0; $i < count($request->file_image); $i++)
            {
                $photoGalleries []= [
                    'photos'        => $request->file('file_image')[$i]->store('assets/product', 'public'),
                    'products_id'   => $request->products_id,
                    'created_at'    => Carbon::now()->toDateTimeString(),
                ];
            }
            
        ProductGallery::insert($photoGalleries);


        return redirect()->route('product-gallery.index');
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
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductGalleryRequest $request, string $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = ProductGallery::findOrFail($id);
        Storage::disk('public')->delete($item->photos);
        $item->delete();

        return redirect()->route('product-gallery.index');
    }
}