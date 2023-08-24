@extends('layouts.app')

@section('title')
Cart Page
@endsection

@section('content')
<div class="page-content page-cart">
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
                        <thead>
                            <tr>
                                <td>Image</td>
                                <td>Name &amp; Seller</td>
                                <td>Price</td>
                                <td>Menu</td>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $totalPrice = 0
                            @endphp
                            @if(isset($carts))
                            @forelse ($carts as $cart)
                            <tr>
                                <td style="width: 20%;">
                                    @if($cart->product->galleries->count())
                                    <img src="{{ Storage::url($cart->product->galleries->first()->photos) }}" alt=""
                                        class="cart-image">
                                    @else
                                    {{-- <img alt="" class="cart-image" style="background: #ddd"> --}}
                                    <p>No Picture</p>
                                    @endif
                                </td>
                                <td style="width: 35%;">
                                    <div class="product-title">{{ $cart->product->name }}</div>
                                    <div class="product-subtitle">by. {{ $cart->product->user->store_name }}</div>
                                </td>
                                <td style="width: 35%;">
                                    <div class="product-title">{{ number_format($cart->product->price) }}</div>
                                    <div class="product-subtitle">Rp.</div>
                                </td>
                                <td style="width: 20%;">
                                    <form action="{{ route('cart-delete', $cart->id) }}" method="POST" id="deleteCart">
                                        @method('DELETE')
                                        @csrf
                                        <button type="button" class="btn btn-remove-cart modalDelete">
                                            Remove
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @php
                            $totalPrice += $cart->product->price
                            @endphp
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
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row" data-aos="fade-up" data-aos-delay="150">
                <div class="col-12">
                    <hr />
                </div>
                <div class="col-12">
                    <h2 class="mb-4">Shipping Details</h2>
                </div>
            </div>
            {{-- Form locations --}}
            <form action="{{ route('checkout') }}" method="POST" enctype="multipart/form-data" id="locations">
                @csrf
                <input type="hidden" name="total_price" value="{{ $totalPrice }}">
                <div class="row mb-2" data-aos="fade-up" data-aos-delay="200">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="address_one">Address 1</label>
                            <input type="text" name="address_one" id="address_one" class="form-control"
                                value="{{ $user->address_one }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="address_two">Address 2</label>
                            <input type="text" name="address_two" id="address_two" class="form-control"
                                value="{{ $user->address_two }}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="provinces_id">province</label>
                            <select name="provinces_id" id="provinces_id" class="form-control" v-if="provinces"
                                v-model="provinces_id">
                                <option v-for="province in provinces" :value="province.id">@{{ province.name }}</option>
                            </select>

                            <select v-else class="form-control"></select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="regencies_id">City</label>
                            <select name="regencies_id" id="regencies_id" class="form-control" v-if="regencies"
                                v-model="regencies_id">
                                <option v-for="regency in regencies" :value="regency.id">@{{ regency.name }}</option>
                            </select>

                            <select v-else class="form-control"></select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="zip_code">Postal Code</label>
                            <input type="number" name="zip_code" id="zip_code" class="form-control" value="4152">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="country">Country</label>
                            <input type="text" name="country" id="country" class="form-control" value="Indonesia">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone_number">Mobile Phone</label>
                            <input type="text" name="phone_number" id="phone_number" class="form-control"
                                value="085959468196">
                        </div>
                    </div>
                </div>
                <div class="row" data-aos="fade-up" data-aos-delay="150">
                    <div class="col-12">
                        <hr />
                    </div>
                    <div class="col-12">
                        <h2 class="mb-1">Payment Informations</h2>
                    </div>
                </div>
                <div class="row" data-aos="fade-up" data-aos-delay="200">
                    <div class="col-4 col-md-2">
                        <div class="product-title">0</div>
                        <div class="product-subtitle">Country Tax</div>
                    </div>
                    <div class="col-4 col-md-3">
                        <div class="product-title">0</div>
                        <div class="product-subtitle">Product Insurance</div>
                    </div>
                    <div class="col-4 col-md-2">
                        <div class="product-title">0</div>
                        <div class="product-subtitle">Ship To Jakarta</div>
                    </div>
                    <div class="col-4 col-md-2">
                        <div class="product-title text-success">Rp. {{ number_format($totalPrice) ?? 0 }}</div>
                        <div class="product-subtitle">Total</div>
                    </div>
                    <div class="col-8 col-md-3">
                        <button type="submit" class="btn btn-success mt-4 px-4 btn-block">
                            Checkout Now
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>

</div>
@endsection

@section('modal-box')
{{-- Modal Box Confirm --}}
<div id="modal-dialog" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content bg-danger">
            <div class="px-3 py-3 text-white">
                <a href="#" data-dismiss="modal" aria-hidden="true" class="close text-white">×</a>
                <h3>Are you sure</h3>
            </div>
            <div class="modal-body text-white">
                <p>Do you want to delete this product form cart?</p>
            </div>
            <div class="modal-footer">
                <a href="#" id="btnYes" class="btn confirm text-white">Yes</a>
                <a href="#" data-dismiss="modal" aria-hidden="true" class="btn text-white">No</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('prepend-script')
<script src="/vendor/vue/vue.js"></script>
<script src="https://unpkg.com/vue-toasted"></script>
<script src="https://unpkg.com/axios@1.1.2/dist/axios.min.js"></script>
@endpush

@push('addon-script')
<!-- Script Action -->
<script>
$(document).ready(function() {

    $('#cartTable').on('click', '.modalDelete', function() {
        $('#modal-dialog').modal('show');
        $('#btnYes').click(function() {
            // handle form processing here
            $('#deleteCart').submit();
        });
    });

    var locations = new Vue({
        el: "#locations",
        mounted() {
            AOS.init();
            this.getProvincesData();
            this.getRegenciesData();
        },
        data: {
            provinces: null,
            regencies: null,
            provinces_id: {
                {
                    $user - > provinces_id
                }
            },
            regencies_id: {
                {
                    $user - > regencies_id
                }
            },
        },
        methods: {
            getProvincesData() {
                var self = this;
                axios.get('{{ route('
                        api - provinces ') }}')
                    .then(function(response) {
                        self.provinces = response.data;
                    })
            },
            getRegenciesData() {
                var self = this;
                axios.get('{{ url('
                        api / regencies ') }}/' + self.provinces_id)
                    .then(function(response) {
                        self.regencies = response.data;
                    })
            },
        },
        watch: {
            provinces_id: function(val, oldVal) {
                this.regencies_id = null;
                this.getRegenciesData();
            }
        }
    });

});
</script>
@endpush