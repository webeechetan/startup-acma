@extends('app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin') }}/assets/vendor/css/core.css" />
    <link rel="stylesheet" href="{{ asset('admin') }}/assets/vendor/css/theme-default.css" />
    <link rel="stylesheet" href="{{ asset('admin') }}/assets/css/demo.css" />
    <link rel="stylesheet" href="{{ asset('admin') }}/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="{{ asset('admin') }}/assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="{{ asset('admin') }}/assets/vendor/css/pages/page-auth.css">

    <script src="{{ asset('admin') }}/assets/vendor/js/helpers.js"></script>
    <script src="{{ asset('admin') }}/assets/js/config.js"></script>
@endpush

@section('app.content')
    @yield('auth.content')
@endsection

@push('scripts')
    <script src="{{ asset('admin') }}/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="{{ asset('admin') }}/assets/vendor/libs/popper/popper.js"></script>
    <script src="{{ asset('admin') }}/assets/vendor/js/bootstrap.js"></script>
    <script src="{{ asset('admin') }}/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="{{ asset('admin') }}/assets/vendor/js/menu.js"></script>
    <script src="{{ asset('admin') }}/assets/js/main.js"></script>
    <script src="{{ asset('admin') }}/assets/js/dashboards-analytics.js"></script>
@endpush
