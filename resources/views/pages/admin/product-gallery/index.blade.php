@extends('layouts.admin')

@section('title')
    Product Gallery
@endsection

@section('content')
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">Gallery</h2>
                <p class="dashboard-subtitle">
                List of Gallery
                </p>
            </div>
            <div class="dashboard-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <a href="{{ route('product-gallery.create') }}" class="btn btn-primary mb-3">
                                + Tambah Gallery Baru
                                </a>
                                <div class="table table-responsive">
                                    <table class="table-hover scroll-horizontal-vertical w-100" id="crudTable">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Produk</th>
                                                <th>Foto</th>
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
                    <p>Do you want to delete this photo</p>
                </div>
                <div class="modal-footer">
                <a href="#" id="btnYes" class="btn confirm text-white">Yes</a>
                <a href="#" data-dismiss="modal" aria-hidden="true" class="btn text-white">No</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('addon-script')

    {{-- Script Datatable --}}
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
                    {data: 'id', name: 'id'},
                    {data: 'product.name', name: 'product.name'},
                    {data: 'photos', name: 'photos'},
                    {
                        data: 'action', 
                        name: 'action',
                        orderable: false,
                        searcable: false,
                        width: '15%'
                    },
                ]
            });

            $('#crudTable').on('click','.modalDelete',function(){
                const id = $(this).attr('data-id');
                $('#modal-dialog').modal('show');
                
                $('#btnYes').click(function() {
                    // handle form processing here
                    $('#form' + id ).submit();
                });
            });
            
        });

    </script>

    <!-- Script Action -->
    <script>
    
    </script>
@endpush