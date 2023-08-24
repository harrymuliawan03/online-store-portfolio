@extends('layouts.app')

@section('title')
    Cart Page
@endsection

@section('content')
    <div class="page-content page-cart" id="cart">
    <section class="store-breadcrumbs" data-aos="fade-down" data-aos-delay="100">
        <div class="container">
        <div class="row">
            <div class="col-12">
            <nav>
                <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Home</a>
                </li>
                <li class="breadcrumb-item active">
                    Cart
                </li>
                </ol>
            </nav>
            </div>
        </div>
        </div>
    </section>

    <section class="store-cart">
        <div class="container">
            <div class="row" data-aos="fade-up" data-aos-delay="100">
                <div class="col-12 table-responsive">
                    <table class="table table-borderless table-cart" id="cartTable">
                    @php
                        $totalPrice = 0
                    @endphp
                        @if(isset($stores))
                            @foreach ($stores as $store)
                                <thead>
                                <tr>
                                    <td colspan="4" class=" text-center"><h1>{{ $store->store->store_name }}</h1></td>
                                </tr>
                                <tr>
                                    <td>Image</td>
                                    <td>Name &amp; Seller</td>
                                    <td>Price</td>
                                    <td>Qty</td>
                                    <td>Menu</td>
                                </tr>
                                </thead>
                                <tbody>
                                    @if(isset($carts))
                                        @forelse ($carts as $cart)
                                            @if ($cart->product->users_id == $store->store_id)
                                                <tr>
                                                    <td style="width: 20%;">
                                                        @if($cart->product->galleries->count())
                                                        <img src="{{ Storage::url($cart->product->galleries->first()->photos) }}" alt="" class="cart-image">
                                                        @else
                                                        {{-- <img alt="" class="cart-image" style="background: #ddd"> --}}
                                                        <p>No Picture</p>
                                                        @endif
                                                    </td>
                                                    <td style="width: 30%;">
                                                        <div class="product-title">{{ $cart->product->name }}</div>
                                                        <div class="product-subtitle">by. {{ $cart->product->user->store_name }}</div>
                                                    </td>
                                                    <td style="width: 25%;">
                                                        <div class="product-title">Rp. {{ number_format($cart->product->price) }}</div>
                                                    </td>
                                                    <td style="width: 20%;">
                                                        <div class="product-title d-flex">
                                                            <a href="{{ route('cart-decrease-qty', $cart->id) }}" class="mr-2">-</a>
                                                            <input
                                                                    type="number"
                                                                    name="qty" 
                                                                    class="form-control w-50 text-center"
                                                                    value="{{ $cart->qty }}"
                                                                    disabled/>
                                                            <a href="{{ route('cart-add-qty', $cart->id) }}" class="ml-2">+</a>
                                                        </div>
                                                    </td>
                                                    <td style="width: 20%;">
                                                        <form action="{{ route('cart-delete', $cart->id) }}" method="POST" id="deleteCart">
                                                            @method('DELETE')
                                                            @csrf
                                                            <button type="submit" class="btn btn-remove-cart modalDelete">
                                                                Remove
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                                @php
                                                    $totalPrice += $cart->product->price
                                                @endphp
                                            @endif
                                        @empty
                                        <tr>
                                            <td colspan="4" class="text-center align-item-center">
                                                <h4 class="my-3">No Product Found in Cart</h4>
                                            </td>
                                        </tr>
                                        @endforelse
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center align-item-center">
                                                <h4 class="my-3">No Product Found in Cart</h4>
                                            </td>
                                        </tr>
                                    @endif
                                    <tr>
                                            <td colspan="5" align="right">
                                                <form action="{{ route('checkout', $store->store_id) }}">
                                                    <button class="btn btn-primary px-4 py-2" :disabled="this.stock_unavailable">Checkout</button>
                                                </form>
                                            </td>
                                    </tr>
                                </tbody>
                                @endforeach
                            </table>
                        @endif
                    @if($stores->count() == 0)
                    <div class="row">
                        <div class="col-12 text-center">
                            <h4>No Products In cart</h4>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    </div>
@endsection