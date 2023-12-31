<!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light navbar-store fixed-top navbar-fixed-top" data-aos="fade-down">
    <div class="container">
      <a href="{{ route('home') }}" class="navbar-brand">
        <div class="row align-items-center">
          <img src="/images/logo.jpg" style="width: 100px; height: 80px;">
          <h3 class="pt-3">Mart</h3>
        </div>
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a href="{{ route('home') }}" class="nav-link">Home</a>
          </li>
          <li class="nav-item">
            <a href="{{ route('categories') }}" class="nav-link">Categories</a>
          </li>
          <li class="nav-item">
            <a href="{{ route('rewards') }}" class="nav-link">Rewards</a>
          </li>
          @guest  
          <li class="nav-item">
            <a href="{{ route('register') }}" class="nav-link">Sign Up</a>
          </li>
          <li class="nav-item">
            <a href="{{ route('login') }}" class="btn btn-success nav-link px-4 text-white">Login</a>
          </li>
          @endguest
        </ul>

        @auth
            <!-- Desktop Menu -->
          <ul class="navbar-nav d-none d-lg-flex">
            <li class="nav-item dropdown">
              <a
                href="#"
                class="nav-link"
                id="navbarDropdown"
                role="button"
                data-toggle="dropdown"
              >
                <img
                  src="/images/icon-user.png"
                  alt=""
                  class="rounded-circle mr-2 profile-picture"
                />
                Hi, {{ auth()->user()->name }}
              </a>
              <div class="dropdown-menu">
                @if (auth()->user()->roles == 'ADMIN')
                <a href="{{ route('admin-dashboard') }}" class="dropdown-item">Dashboard</a>
                @else
                <a href="{{ route('dashboard') }}" class="dropdown-item">Dashboard</a>
                @endif

                @if (auth()->user()->roles == 'ADMIN')
                <a href="{{ route('admin-settings') }}" class="dropdown-item">Settings</a>
                @else
                <a href="{{ route('dashboard-settings') }}" class="dropdown-item">Settings</a>
                @endif
                
                <div class="dropdown-divider"></div>
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

          <ul class="navbar-nav d-block d-lg-none">
            <li class="nav-item">
              @if (auth()->user()->roles == 'ADMIN')
                <a href="{{ route('admin-dashboard') }}" class="nav-link">
              @else
                <a href="{{ route('dashboard') }}" class="nav-link">
              @endif
                Dashboard
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
        @endauth
      </div>
    </div>
  </nav>
  <!-- End Navbar -->