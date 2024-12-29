<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | {{ config('app.name') }}</title>

    <link rel="stylesheet" href="{{ asset('assets/css/app.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datepicker.min.css') }}">
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.2/css/bootstrap.min.css">


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.2/js/bootstrap.min.js"></script>


    <style>
        .navbar-nav .nav-link:hover {
            color: #000000 !important;
            /* Changer la couleur du texte lors du survol */
            background-color: #ffffff !important;
            /* Changer la couleur de fond lors du survol */
        }

        .loading-container {
            min-height: 10rem;
            height: 100%;
            /* position: absolute;
            top: 0;
            left: 0; */
            display: grid;
            align-items: center;
            justify-content: center
        }

        .validation-errors p {
            margin: 0;
        }
    </style>

    @yield('style')
    @stack('custom-style')

</head>


<body>
<div id="layout-wrapper">
    <header id="page-topbar">
        <div class="navbar-header justify-content-end">
            <div class="d-flex float-start">
                {{-- @include("layouts.inc.notifications")--}}

                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="rounded-circle header-profile-user" src="{{ asset('storage/default-avatar.png') }}"
                             alt="Profile Avatar">
                        <span class="d-xl-inline-block ms-1 fw-medium font-size-15">Admin</span>
                        <i class="uil-angle-down d-none d-xl-inline-block font-size-15"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item d-block" href="#">
                            <i class="uil uil-cog font-size-18 align-middle me-1 text-muted"></i>
                            <span class="align-middle">Settings</span>
                        </a>
{{--                        <a class="dropdown-item" href="#">--}}
{{--                            <i class="uil uil-sign-out-alt font-size-18 align-middle me-1 text-muted"></i>--}}
{{--                            <span class="align-middle">Sign out</span>--}}
{{--                        </a>--}}
                    </div>
                </div>
            </div>
        </div>
    </header>


    <div class="vertical-menu">

        <!-- LOGO -->
        <div class="navbar-brand-box">
            <a href="/" class="logo logo-light">
                <span class="logo-sm">
                    HN
                </span>
                <span class="logo-lg">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="" height="60">
                </span>
            </a>
            <a href="/" class="logo logo-dark">
                <span class="logo-sm">
                    HN
                </span>
                <span class="logo-lg">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="" height="60">
                </span>
            </a>
        </div>

        <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect vertical-menu-btn">
            <i class="fa fa-fw fa-bars"></i>
        </button>

        @include("layouts.inc.sidebar")
    </div>

    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->

                <!-- end page title -->
                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <strong>Errors</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </div> <!-- container-fluid -->
        </div> <!-- page content-->

        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        {{ now()->year }} © All rights reserved.
                    </div>
                    <div class="col-sm-6">
                        <div class="text-sm-end d-none d-sm-block">
                            Created <i class="mdi text-danger"></i> by <a href="#" target="_blank" class="text-reset">HassanNid:
                                06.68.28.33.63</a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>

<script>
    const loadingHtml =
        '<div class="loading-container"><div class="spinner-border text-primary m-1" role="status"><span class="sr-only">Loading...</span></div></div>'
</script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz4fnFO9gybBgq8aXCbibzQG8poVRW6LhJ6MzzT6Qf6KpG7rBPsSx5K+N2" crossorigin="anonymous">
</script>
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

<script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>

<script src="{{ asset('assets/js/app.js') }}"></script>
<script src="{{ asset('assets/js/helpers.js') }}"></script>
<script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-datepicker.min.js') }}"></script>
<script src="node_modules/chart.js/dist/chart.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@yield('scripts')
@stack('custom-script')
</body>

</html>
