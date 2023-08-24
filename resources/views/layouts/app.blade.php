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
    @include('includes.style')
    @stack('addon-style')
    {{-- End Style --}}
</head>

<body>
    {{-- Navbar --}}
    @include('includes.navbar')
    {{-- End Navbar --}}

    {{-- Page Content --}}
    @yield('content')
    {{-- End Page Content --}}


    {{-- Modal Box --}}
    @yield('modal-box')
    {{-- End Page Content --}}

    {{-- Footer --}}
    @include('includes.footer')
    {{-- End Footer --}}


    {{-- Scripts --}}
    @stack('prepend-script')
    @include('includes.script')
    @stack('addon-script')
    {{-- End Scripts --}}
</body>
</html>