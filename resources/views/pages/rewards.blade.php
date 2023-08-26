@extends('layouts.app')

@section('title')
    Store Rewards
@endsection

@section('content')
<div class="page-content page-home">
    <section class="store-rewards">
        <div class="container">
            <div class="row">
                <div class="col-12" data-aos="zoom-in">
                    <h1 class="text-center my-5">Achievments</h1>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="card" style="height: 385px;">
                                <img src="/images/muri.jpg" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">MURI 2019</h5>
                                    <p class="card-text">Pertumbuhan Kedai Kopi Tercepat Dalam Satu Tahun</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card" style="height: 385px;">
                                <img src="/images/top_brand.jpg" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">TOP BRAND AWARD 2021</h5>
                                    <p class="card-text">Top of Mind Share, Top of Market Share, & Top of Commitment Share Coffee Shop</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card" style="height: 385px;">
                                <img src="/images/wow_brand.png" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">WOW BRAND 2021</h5>
                                    <p class="card-text">Gold Champion Category `Coffee Shop`</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3" style="height: 385px;">
                            <div class="card">
                                <img src="/images/mui.jpg" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">HALAL MUI</h5>
                                    <p class="card-text">MUI dan BPJPH Berikan Sertifikat Halal Grade A kepada Seluruh Outlet Kopi88</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection