@extends('layouts.dashboard')

@section('title')
    Store Dashboard
@endsection

@section('content')
    <div class="section-content section-dashboard-home" data-aos="fade-up">
            <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">My Account</h2>
                <p class="dashboard-subtitle">
                Update your current profile
                </p>
            </div>
            <div class="dashboard-content">
                <div class="row">
                <div class="col-12">
                    <form action="">
                    <div class="card">
                        <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Your Name</label>
                                <input type="text" name="name" id="name" class="form-control"
                                value="Harry Muiliawan Ihsan Ahmad">
                            </div>
                            </div>
                            <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Your Email</label>
                                <input type="email" name="email" id="email" class="form-control"
                                value="harrymuliawan03@gmail.com">
                            </div>
                            </div>

                            <div class="col-md-6">
                            <div class="form-group">
                                <label for="addressOne">Address 1</label>
                                <input type="text" name="addressOne" id="addressOne" class="form-control"
                                value="Setra Duta Cemara">
                            </div>
                            </div>
                            <div class="col-md-6">
                            <div class="form-group">
                                <label for="addressTwo">Address 2</label>
                                <input type="text" name="addressTwo" id="addressTwo" class="form-control"
                                value="Setra Duta Cemara">
                            </div>
                            </div>

                            <div class="col-md-4">
                            <div class="form-group">
                                <label for="provience">Provience</label>
                                <input type="text" name="provience" id="provience" class="form-control"
                                value="Jawa Barat">
                            </div>
                            </div>
                            <div class="col-md-4">
                            <div class="form-group">
                                <label for="city">City</label>
                                <input type="text" name="city" id="city" class="form-control" value="Ciamis">
                            </div>
                            </div>
                            <div class="col-md-4">
                            <div class="form-group">
                                <label for="postalCode">Postal Code</label>
                                <input type="text" name="postalCode" id="postalCode" class="form-control"
                                value="Setra Duta Cemara">
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
                                <label for="mobilePhone">Mobile Phone</label>
                                <input type="text" name="mobilePhone" id="mobilePhone" class="form-control"
                                value="085959468196">
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