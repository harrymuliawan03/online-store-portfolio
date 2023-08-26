@extends('layouts.admin')

@section('title')
    Transactions Details
@endsection

@section('content')
    <div class="section-content section-dashboard-home" data-aos="fade-up">
            <div class="container-fluid">
                <div class="dashboard-heading">
                    <h2 class="dashboard-title">#{{ $sell->transaction->code }}</h2>
                    <p class="dashboard-subtitle">
                    Transactions ( Sell ) / Details
                    </p>
                </div>
                <div class="dashboard-content" id="transactionDetails">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                    <div class="col-12 col-md-1">
                                        @if ($sell->product->galleries->count())
                                            <img src="{{ Storage::url($sell->product->galleries->first()->photos ) }}" alt="" class="w-100 mb-3" style="max-height: 250px; max-width: 250px;">
                                        @endif
                                    </div>
                                        <div class="col-12 col-md-4">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="product-title">Customer Name</div>
                                                    <div class="product-subtitle">{{ $sell->transaction->user->name }}</div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="product-title">Mobile</div>
                                                    <div class="product-subtitle">{{ $sell->transaction->user->phone_number }}</div>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <div class="product-title">Date of Transaction</div>
                                                    <div class="product-subtitle">{{ $sell->created_at->format('d-M-Y') }}</div>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <div class="product-title">Payment Status</div>
                                                    <div class="product-subtitle">
                                                        @if ($sell->transaction->payment_status == "PENDING")
                                                            @php $color = 'primary'; @endphp
                                                        @elseif ($sell->transaction->payment_status == "FAILED")
                                                            @php $color = 'danger'; @endphp
                                                        @elseif ($sell->transaction->payment_status == "SUCCESS")
                                                            @php $color = 'success'; @endphp
                                                        @endif
                                                        <span class="btn btn-{{ $color }}">{{ $sell->transaction->payment_status }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <div class="product-title">Total Amount</div>
                                                    <div class="product-subtitle">{{ number_format($sell->transaction->total_price) }}</div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="product-title">Service Fee</div>
                                                    <div class="product-subtitle">{{ number_format($sell->transaction->service_fee) }}</div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="product-title">Income</div>
                                                    <div class="product-subtitle">{{ number_format($sell->transaction->total_price - $sell->transaction->service_fee) }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-7">
                                                <form action="{{ route('admin-transactions-sell-update', $sell->transaction->id) }}" method="POST">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="row">
                                                                <div class="col-12 col-md-6">
                                                                    <div class="product-title">Address I</div>
                                                                    <div class="product-subtitle">{{ $sell->transaction->user->address_one }}</div>
                                                                </div>
                                                                <div class="col-12 col-md-6">
                                                                    <div class="product-title">Address II</div>
                                                                    <div class="product-subtitle">{{ $sell->transaction->user->address_two }}</div>
                                                                </div>
                                                                <div class="col-12 col-md-6">
                                                                    <div class="product-title">Province</div>
                                                                    <div class="product-subtitle">{{ $sell->transaction->user->provinces->name }}</div>
                                                                </div>
                                                                <div class="col-12 col-md-6">
                                                                    <div class="product-title">City</div>
                                                                    <div class="product-subtitle">{{ $sell->transaction->user->regency->name}}</div>
                                                                </div>
                                                                <div class="col-12 col-md-6">
                                                                    <div class="product-title">Postal Code</div>
                                                                    <div class="product-subtitle">{{ $sell->transaction->user->zip_code }}</div>
                                                                </div>
                                                                <div class="col-12 col-md-6">
                                                                    <div class="product-title">Country</div>
                                                                    <div class="product-subtitle">Indonesia</div>
                                                                </div>
                                                                    @csrf
                                                                    <div class="col-12 col-md-3">
                                                                        <div class="product-title">Shipping Status</div>
                                                                        <select name="transaction_status" id="status" class="form-control" v-model="status">
                                                                            <option value="PENDING">Pending</option>
                                                                            <option value="SHIPPING">Shipping</option>
                                                                            <option value="SUCCESS">Success</option>
                                                                        </select>
                                                                    </div>
                                                                    <template v-if="status == 'SHIPPING'">
                                                                        <div class="col-md-3">
                                                                        <div class="product-title">Input Resi</div>
                                                                        <input type="text" name="awb" class="form-control" v-model="resi">
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                        <button type="submit" class="btn btn-success btn-block mt-4">
                                                                            Update Resi
                                                                        </button>
                                                                        </div>
                                                                    </template>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-12 text-right">
                                                                <button type="submit" class="btn btn-lg btn-success mt-4">
                                                                    Save Now
                                                                </button>
                                                            </div>
                                                        </div>
                                                </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 mt-2">
                        <h5 class="mb-3">Detail Transactions</h5>
                        <div class="card-body">
                                <div class="row">
                                    <div class="col-md-1">
                                        Image
                                    </div>
                                    <div class="col-md-2">
                                        Nama Produk
                                    </div>
                                    <div class="col-md-2">
                                        Pembeli
                                    </div>
                                    <div class="col-md-1">
                                        Qty
                                    </div>
                                    <div class="col-md-2">
                                        Sub Total
                                    </div>
                                    <div class="col-md-3">
                                        Tanggal Transaksi
                                    </div>
                                </div>
                        </div>
                        @foreach ($details as $detail)    
                        <a href="#" class="card card-list d-block">
                            <div class="card-body">
                                <div class="row">
                                <div class="col-md-1">
                                    @if ($detail->product->galleries->count())
                                            <img src="{{ Storage::url($detail->product->galleries->first()->photos ) }}" alt="" class="w-100 mb-3" style="max-height: 250px; max-width: 250px;">
                                    @endif
                                </div>
                                <div class="col-md-2">
                                    {{ $detail->product->name }}
                                </div>
                                <div class="col-md-2">
                                    {{ $detail->transaction->user->name }}
                                </div>
                                <div class="col-md-1">
                                    {{ $detail->qty }}
                                </div>
                                <div class="col-md-2">
                                    {{ $detail->qty * $detail->price }}
                                </div>
                                <div class="col-md-3">
                                    {{ $detail->created_at->format('d-M-Y') }}
                                </div>
                                <div class="col-md-1 d-none d-md-block">
                                    <img src="/images/dashboard-icon-arrow-right.svg" alt="">
                                </div>
                                </div>
                            </div>
                        </a>
                        @endforeach
                        </div>
                    </div>
                    <!-- End tabs with pills -->
            </div>
    </div>
@endsection

@push('addon-script')
    <script src="/vendor/vue/vue.js"></script>
    <script>
        var transactionDetails = new Vue({
            el: '#transactionDetails',
            data: {
            status: "{{ $sell->transaction->transaction_status }}",
            resi: "{{ $sell->transaction->awb }}"
            }
        });
    </script>
@endpush