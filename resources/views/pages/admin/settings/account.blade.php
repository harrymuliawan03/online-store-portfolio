@extends('layouts.admin')

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
                            <form action="{{ route('admin-update-account') }}" id="locations" method="POST">
                                @csrf
                            <div class="card">
                                <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Your Name</label>
                                            <input type="text" name="name" id="name" class="form-control"
                                            value="{{ $user->name }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Your Email</label>
                                            <input type="email" name="email" id="email" class="form-control"
                                            value="{{ $user->email }}">
                                        </div>
                                    </div>

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
                                            <input type="number" name="zip_code" id="zip_code" class="form-control"
                                            value="{{ $user->zip_code }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="country">Country</label>
                                            <input type="text" name="country" id="country" class="form-control" value="{{ $user->country }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone_number">Mobile Phone</label>
                                            <input type="text" name="phone_number" id="phone_number" class="form-control"
                                            value="{{ $user->phone_number }}">
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

@push('prepend-script')
    <script src="/vendor/vue/vue.js"></script>
    <script src="https://unpkg.com/vue-toasted"></script>
    <script src="https://unpkg.com/axios@1.1.2/dist/axios.min.js"></script>
@endpush

@push('addon-script')
    <!-- Script Action -->
    <script>
    $(document).ready(function(){
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
                provinces_id: {{ $user->provinces_id ?? 'null' }} ,
                regencies_id: {{ $user->regencies_id ?? 'null' }} ,
            },
            methods: {
                getProvincesData() {
                    var self = this;
                    axios.get('{{ route('api-provinces') }}')
                    .then(function(response) {
                        self.provinces = response.data;
                    })
                },
                getRegenciesData() {
                    var self = this;
                    axios.get('{{ url('api/regencies') }}/'+ self.provinces_id)
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
            },
        });
        
    });
    </script>
@endpush