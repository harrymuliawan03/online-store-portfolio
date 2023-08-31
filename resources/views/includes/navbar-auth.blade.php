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
        </ul>
      </div>
    </div>
  </nav>