@extends('layouts.dashboard')

@section('title')
    My Products Dashboard
@endsection

@section('content')
    <div class="section-content section-dashboard-home" data-aos="fade-up">
            <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">My Products</h2>
                <p class="dashboard-subtitle">
                Manage it well and get money
                </p>
            </div>
            <div class="dashboard-content">
                <div class="row">
                    <div class="col-12">
                        <a href="{{ route('products-create') }}" class="btn btn-success">Add New Products</a>
                    </div>
                </div>
                <div class="row mt-4">
                    @if ($products->count() > 0)
                        @foreach ($products as $product)   
                        <div class="col-12 col-sm-6 col-md-4 col-lg-2">
                            <a href="{{ route('product-details', $product->id) }}" class="card card-dashboard-product d-block">
                            <div class="card-body">
                                <img src="{{ Storage::url($product->galleries->first()->photos) }}" alt="" class="w-100 mb-2" style="max-height: 155px; max-width: 205px;">
                                <div class="product-title">{{ $product->name }}</div>
                                <div class="product-category">{{ $product->category->name }}</div>
                                <div class="product-stock">Stock: {{ $product->stock }}</div>
                            </div>
                            </a>
                        </div>
                        @endforeach
                    @else
                        <div class="col-md-6 alert alert-warning">
                            <p>there is no products, lets make products !</p>
                        </div>
                    @endif
                </div>
            </div>
            </div>
    </div>
@endsection