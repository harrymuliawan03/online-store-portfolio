<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>@yield('title')</title>

    {{-- Style --}}
    @stack('prepend-style')
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
        <link href="/style/main.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/v/bs5/dt-1.13.6/datatables.min.css" rel="stylesheet">
    @stack('addon-style')
    {{-- End Style --}}
</head>

<body>

    <div class="page-dashboard">
    <div class="d-flex" id="wrapper" data-aos="fade-right">
        <!-- Sidebar -->
        <div class="border-right" id="sidebar-wrapper">
        <div class="sidebar-heading text-center">
            <a href="{{ route('home') }}">
                <img src="/images/dashboard-store-logo.svg" alt="" class="my-4">
            </a>
        </div>
        <div class="list-group list-group-flush">
            <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action {{ (request()->is('dashboard')) ? 'active' : '' }}">
            Dashboard
            </a>
            <a href="{{ route('products') }}" class="list-group-item list-group-item-action {{ (request()->is('dashboard/products')) ? 'active' : '' }}">
            My Products
            </a>
            <a href="{{ route('transactions-sell') }}" class="list-group-item list-group-item-action {{ (request()->is('dashboard/transactions/sell*')) ? 'active' : '' }}">
            Transactions - Sells
            </a>
            <a href="{{ route('transactions-buy') }}" class="list-group-item list-group-item-action {{ (request()->is('dashboard/transactions/buy*')) ? 'active' : '' }}">
            Transactions - Buy
            </a>
            <a href="{{ route('dashboard-settings') }}" class="list-group-item list-group-item-action {{ (request()->is('dashboard/settings')) ? 'active' : '' }}">
            Store Settings
            </a>
            <a href="{{ route('dashboard-account') }}" class="list-group-item list-group-item-action {{ (request()->is('dashboard/account')) ? 'active' : '' }}">
            My Account
            </a>
            <a href="{{ route('logout') }}" 
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();" 
                class="list-group-item list-group-item-action">
                Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
        </div>
        <!-- End sidebar -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
        <nav class="navbar navbar-expand-lg navbar-light navbar-store fixed-top" data-aos="fade-down">
            <div class="container-fluid">
            <button class="btn btn-secondary d-md-none mr-auto mr-2" id="menu-toggle">
                &laquo; Menu
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <!-- Dekstop Menu -->
                <ul class="navbar-nav d-none d-lg-flex ml-auto">
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link" id="navbarDropdown" role="button" data-toggle="dropdown">
                    <img src="/images//icon-user.png" alt="" class="rounded-circle mr-2 profile-picture">
                    Hi {{ auth()->user()->name }}
                    </a>
                    <div class="dropdown-menu">
                    <a href="{{ route('dashboard') }}" class="dropdown-item">Dashboard</a>
                    <a href="{{ route('dashboard-settings') }}" class="dropdown-item">Settings</a>
                    <a href="{{ route('logout') }}" 
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();" 
                        class="dropdown-item">
                        Logout
                    </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="{{ route('cart') }}" class="nav-link d-inline-block mt-2">
                        @php
                            $carts = \App\Models\Cart::where('users_id', auth()->user()->id)->count();
                        @endphp

                        @if ($carts > 0)
                        <img src="/images/icon-cart-filled.svg" alt="" />
                        <div class="card-badge">{{ $carts }}</div>
                        @else
                        <img src="/images/icon-cart-empty.svg" alt="" />
                        @endif
                    </a>
                </li>
                </ul>
                <!-- End Dekstop Menu -->
            </div>
            </div>
        </nav>

        {{-- Content --}}
        @yield('content')
        {{-- End Content --}}
        
        </div>
        <!-- End Page Content -->

    </div>
    </div>

    <!-- Bootstrap core JavaScript -->
    {{-- Scripts --}}
    @stack('prepend-script')
    <script src="/vendor/jquery/jquery.min.js"></script>
    <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-1.13.6/datatables.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
        </script>
    <script>
        $('#menu-toggle').click(function (e) {
            e.preventDefault();
            $('#wrapper').toggleClass('toggled');
        })
    </script>
    @stack('addon-script')
    {{-- End Scripts --}}
</body>

</html>