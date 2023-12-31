@extends('layouts.admin')

@section('title')
    Settings
@endsection

@section('content')
    <div class="section-content section-dashboard-home" data-aos="fade-up">
            <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">Store Settings</h2>
                <p class="dashboard-subtitle">
                Make store that profitable
                </p>
            </div>
            <div class="dashboard-content">
                <div class="row">
                <div class="col-12">
                    <form action="{{ route('admin-update-settings') }}" method="POST">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama Toko</label>
                                <input type="text" name="store_name" class="form-control" value="{{ $user->store_name }}"/>
                            </div>
                            </div>
                            <div class="col-md-6">
                            <div class="form-group">
                                <label>Kategory</label>
                                <select name="categories_id" class="form-control">
                                    <option value="{{ $user->categories_id }}" selected disabled>{{ $user->category->name ?? 'None' }}</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                @php
                                    if ($user->store_status == 1) {
                                        $status = 'Buka';
                                    }else{
                                        $status = 'Tutup';
                                    }
                                @endphp
                                <label>Store Status (Status toko saat ini : {{ $status }})</label>
                                <p class="text-muted">
                                Apakah saat ini toko Anda buka?
                                </p>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="store_status" value="1">
                                        <label class="form-check-label" for="store_status">
                                            Buka
                                        </label>
                                </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="store_status" value="0">
                                        <label class="form-check-label" for="store_status">
                                            Sementara Tutup
                                        </label>
                                    </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col text-right">
                            <button type="submit" class="btn btn-success px-5">
                                Save Now
                            </button>
                            </div>
                        </div>
                        </div>
                    </div>
                    </form>
                </div>
                </div>
            </div>
            </div>
    </div>
@endsection