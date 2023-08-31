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
                        @if($stores->count() > 0)
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
                                                            {{-- <a href="{{ route('cart-decrease-qty', $cart->id) }}" class="mr-2">-</a> --}}
                                                            <input
                                                                    id="cart{{ $cart->id }}"
                                                                    type="number"
                                                                    name="qty" 
                                                                    class="form-control w-50 text-center"
                                                                    min="0"
                                                                    value="{{ $cart->qty }}"
                                                                    @change="checkStockApi({{ $cart->id }}, $event)"/>
                                                            {{-- <a href="{{ route('cart-add-qty', $cart->id) }}" class="ml-2">+</a> --}}
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
                                                    <button class="btn btn-primary px-4 py-2">Checkout</button>
                                                </form>
                                            </td>
                                    </tr>
                                </tbody>
                                @endforeach
                            </table>
                            @if($stores->count() > 1)
                            <div class="row mt-5">
                                <div class="col-12 text-center">
                                    <a href="{{ route('checkout-all', auth()->user()->id) }}" class="btn btn-secondary py-2">&#9989; Checkout All</a>
                                </div>
                            </div>
                            @endif
                            
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

@push('prepend-script')
    <script src="/vendor/vue/vue.js"></script>
    <script src="https://unpkg.com/vue-toasted"></script>
    <script src="https://unpkg.com/axios@1.1.2/dist/axios.min.js"></script>
@endpush

@push('addon-script')
    <script>
        Vue.use(Toasted);

        var register = new Vue({
            el: '#cartTable',
            mounted() {
                AOS.init();
            },
            methods: {
                checkStockApi: function(id, e) {
                    const result = document.querySelector('#cart' + id);
                    var self = this;
                    axios.get('/api/stock/check?id=' + id + '&qty=' + e.target.value)
                    .then(function (response){
                        if(response.data.check == 'Unavailable') {
                            self.$toasted.error(
                            "Qty melebihi batas stock yang tersedia !",
                            {
                                position: "top-center",
                                className: "rounded",
                                duration: 5000
                            }
                            );
                            result.value = response.data.qty
                        }
                        else if(response.data.check == 'Redirect') {
                            window.location.reload();
                        }
                    });
                }
            },
        });

        // function checkStockApi(id, value) {
        //     const result = document.querySelector('#cart' + id);
        //     fetch('/api/stock/check?id=' + id + '&qty=' + value)
        //     .then(response => response.json())
        //     .then(data => result.value = data.qty)
        // }
    </script>
@endpush