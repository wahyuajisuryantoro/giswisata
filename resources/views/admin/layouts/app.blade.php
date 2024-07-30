<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - Mazer Admin Dashboard</title>



    <link rel="shortcut icon" href="{{ asset('img/logo.png') }}" type="image/x-icon">
    <link rel="shortcut icon"
        href="{{ asset('img/logo.png') }}"
        type="image/png">



    <link rel="stylesheet" href="{{ asset('admin/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/compiled/css/app-dark.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/compiled/css/iconly.css') }}">
    <link href="https://api.mapbox.com/mapbox-gl-js/v3.4.0/mapbox-gl.css" rel="stylesheet">

    @stack('styles')
</head>

<body>
    <script src="{{ 'admin/static/js/initTheme.js' }}"></script>
    {{-- App --}}
    <div id="app">
        {{-- Sidebar --}}
        @include('admin.components.sidebar')
        {{-- EndSidebar --}}

        {{-- Main --}}
        <div id="main">

            {{-- Header --}}
            @include('admin.components.header')
            {{-- EndHeader --}}

            {{-- Content --}}
            @yield('content')
            {{-- EndContent --}}


        </div>
        {{-- EndMain --}}
    </div>
    {{-- Footer --}}
    @include('admin.components.footer')
    {{-- EndFooter --}}
    {{-- EndApp --}}
    <script src="{{ asset('admin/static/js/components/dark.js') }}"></script>
    <script src="{{ asset('admin/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('admin/compiled/js/app.js') }}"></script>
    <!-- Need: Apexcharts -->
    <script src="{{ asset('admin/extensions/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('admin/static/js/pages/dashboard.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://api.mapbox.com/mapbox-gl-js/v3.4.0/mapbox-gl.js"></script>
    @include('sweetalert::alert')

    <script>
        function openCity(cityName) {
            var i;
            var x = document.getElementsByClassName("city");
            for (i = 0; i < x.length; i++) {
                x[i].style.display = "none";
            }
            document.getElementById(cityName).style.display = "block";
        }
    </script>

   @stack('scripts')

</body>

</html>
