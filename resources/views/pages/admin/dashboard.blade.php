@extends('layouts.admin')

@section('title')
    Admin Store Dashboard
@endsection

@section('content')
    <div class="section-content section-dashboard-home" data-aos="fade-up">
            <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">Dashboard</h2>
                <p class="dashboard-subtitle">
                Look what you have made today
                </p>
            </div>
            <div class="dashboard-content">
                <div class="row">
                <div class="col-md-3">
                    <div class="card mb-2">
                    <div class="card-body">
                        <div class="dashboard-card-title">
                        Sell Products
                        </div>
                        <div class="dashboard-card-subtitle">
                        {{ $sell_products }}
                        </div>
                    </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card mb-2">
                    <div class="card-body">
                        <div class="dashboard-card-title">
                        Revenue
                        </div>
                        <div class="dashboard-card-subtitle">
                        Rp. {{ number_format($revenue) }}
                        </div>
                    </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card mb-2">
                    <div class="card-body">
                        <div class="dashboard-card-title">
                        Transaction
                        </div>
                        <div class="dashboard-card-subtitle">
                        Rp. {{ number_format($transaction) }}
                        </div>
                    </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card mb-2">
                    <div class="card-body">
                        <div class="dashboard-card-title">
                            Commision Profit
                        </div>
                        <div class="dashboard-card-subtitle">
                            Rp. {{ number_format($commition_profit) }}
                        </div>
                    </div>
                    </div>
                </div>
                </div>
                <div class="row mt-5">
                    <div class="col-12 mt-2">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="mb-3">Daftar Penjualan Toko Anda</h5>
                                <div class="table table-responsive">
                                    <table class="table-hover scroll-horizontal-vertical w-100" id="crudTable">
                                        <thead>
                                            <tr>
                                                <th><h2>{{ $user->store_name }}</h2></th>
                                                <th colspan="8" class="text-right">
                                                    <span class="btn btn-danger position-relative">Belum diproses <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary">{{ $belum_proses }}</span></span>

                                                    <span class="btn btn-secondary position-relative ml-3">Shipping <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary">{{ $shipping }}</span></span>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th>Image</th>
                                                <th>Nama Produk</th>
                                                <th>Pembeli</th>
                                                <th>Jumlah Produk</th>
                                                <th>Total</th>
                                                <th>Tanggal Transaksi</th>
                                                <th>Resi</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
@endsection

@push('addon-script')
    <script>
        $(document).ready(function(){
            var dataTable = $('#crudTable').DataTable({
                processing: true,
                serverSide: true,
                ordering: true,
                ajax: {
                    url: '{!! url()->current() !!}',
                },
                columns: [
                    {data: 'image', name: 'image'},
                    {data: 'product_name', name: 'product_name'},
                    {data: 'buyer', name: 'buyer'},
                    {data: 'total_products', name: 'total_products'},
                    {data: 'total_amount', name: 'total_amount'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'awb', name: 'awb'},
                    {data: 'status', name: 'status'},
                    {
                        data: 'action', 
                        name: 'action',
                        orderable: false,
                        searcable: false,
                        width: '15%'
                    },
                ],
            });
        });
    </script>
@endpush