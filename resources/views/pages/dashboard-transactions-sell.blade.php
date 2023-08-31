@extends('layouts.dashboard')

@section('title')
    Transactions
@endsection

@section('content')
    <div class="section-content section-dashboard-home" data-aos="fade-up">
            <div class="container-fluid">
                <div class="dashboard-heading">
                    <h2 class="dashboard-title">Transactions - ( Sells )</h2>
                    <p class="dashboard-subtitle">
                    Big result start from the small one
                    </p>
                </div>
                <div class="dashboard-content">

                    <div class="row">
                        <div class="col-12 mt-5">
                                    {{-- Datatables --}}
                                    <div class="table table-responsive">
                                        <table class="table-hover scroll-horizontal-vertical w-100" id="sellTable">
                                            <thead>
                                                <tr>
                                                    <th>Image</th>
                                                    <th>Nama Produk</th>
                                                    <th>Pembeli</th>
                                                    <th class="text-center">Jumlah Produk</th>
                                                    <th>Total</th>
                                                    <th>Tgl Transaksi</th>
                                                    <th>Kode Trx</th>
                                                    <th>Resi</th>
                                                    <th>Status</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                    {{-- End Datatables --}}
                            <!-- End tabs with pills -->

                        </div>
                    </div>
                </div>
            </div>
    </div>
@endsection

@push('prepend-script')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"
    integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa"
    crossorigin="anonymous"></script>
@endpush

@push('addon-script')
    <script>
        $(document).ready(function(){
            var dataTable = $('#sellTable').DataTable({
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
                    {data: 'code_trx', name: 'code_trx'},
                    {data: 'awb', name: 'awb'},
                    {data: 'status', name: 'status'},
                    {
                        data: 'action', 
                        name: 'action',
                        orderable: false,
                        searcable: false,
                        width: '5%'
                    },
                ]
            });
        });
    </script>
@endpush