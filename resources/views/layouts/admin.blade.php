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
                <img src="/images/admin.png" alt="" class="my-4" style="width: 150px;">
            </a>
        </div>
        <div class="list-group list-group-flush">
            <a href="{{ route('admin-dashboard') }}" class="list-group-item list-group-item-action {{ (request()->is('admin')) ? 'active' : '' }}">
            Dashboard
            </a>
            <a href="{{ route('product.index') }}" class="list-group-item list-group-item-action {{ (request()->is('admin/product')) ? 'active' : '' }}">
            Products
            </a>
            <a href="{{ route('product-gallery.index') }}" class="list-group-item list-group-item-action {{ (request()->is('admin/product-gallery*')) ? 'active' : '' }}">
            Galleries
            </a>
            <a href="{{ route('category.index') }}" class="list-group-item list-group-item-action {{ (request()->is('admin/category*')) ? 'active' : '' }}">
            Categories
            </a>
            <a href="{{ route('admin-transactions-sell') }}" class="list-group-item list-group-item-action {{ (request()->is('admin/transactions/sell*')) ? 'active' : '' }}">
            Transactions - Sells
            </a>
            <a href="{{ route('admin-transactions-buy') }}" class="list-group-item list-group-item-action {{ (request()->is('admin/transactions/buy*')) ? 'active' : '' }}">
            Transactions - Buy
            </a>
            <a href="{{ route('user.index') }}" class="list-group-item list-group-item-action {{ (request()->is('admin/user*')) ? 'active' : '' }}">
            Users
            </a>
            <a href="{{ route('admin-settings') }}" class="list-group-item list-group-item-action {{ (request()->is('admin/settings*')) ? 'active' : '' }}">
            Store Settings
            </a>
            <a href="{{ route('admin-account') }}" class="list-group-item list-group-item-action {{ (request()->is('admin/account*')) ? 'active' : '' }}">
            My Account
            </a>
            <a href="{{ route('logout') }}" 
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();" class="list-group-item list-group-item-action">
                    Sign Out
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
        </div>
        <!-- End sidebar -->

        <!-- Page Content -->
        <div id="page-content-wrapper" class="bg-admin" style="background: lavender">
        <nav class="navbar navbar-expand-lg navbar-light navbar-store fixed-top" data-aos="fade-down">
            <div class="container-fluid">
            <button class="btn btn-secondary d-md-none mr-auto mr-2" id="menu-toggle">
                &laquo; Menu
            </button>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <!-- Dekstop Menu -->
                <ul class="navbar-nav d-none d-lg-flex ml-auto">
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link" id="navbarDropdown" role="button" data-toggle="dropdown">
                    <img src="/images//icon-user.png" alt="" class="rounded-circle mr-2 profile-picture">
                        {{ auth()->user()->name }}
                    </a>
                    <div class="dropdown-menu">
                        <a href="{{ route('logout') }}" 
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();" class="list-group-item list-group-item-action {{ (request()->is('admin/user*')) ? 'active' : '' }}">
                                Sign Out
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
                </ul>
                <!-- End Dekstop Menu -->

                <ul class="navbar-nav d-block d-lg-none">
                    <li class="nav-item">
                        <a href="{{ route('dashboard-settings') }}" class="nav-link">
                            {{ auth()->user()->name }}
                        </a>
                        </li>
                        <li class="nav-item">
                        <a href="{{ route('cart') }}" class="nav-link d-inline-block">
                            Cart
                        </a>
                        </li>
                        <li class="nav-item">
                        <a href="{{ route('logout') }}" 
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();" class="btn btn-danger">
                            Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                    </li>
                </ul>

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
        {{-- Modal Box Confirm --}}
        @yield('modal-box')
        {{-- End Modal Box Confirm --}}


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