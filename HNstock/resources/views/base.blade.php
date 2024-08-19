<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | {{ config('app.name') }}</title>

    <link rel="stylesheet" href="{{ asset('assets/css/app.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.2/css/bootstrap.min.css">


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.2/js/bootstrap.min.js"></script>

<body>
    <header id="page-topbar">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box">
                    <a href="/" class="logo logo-light">
                        <span class="logo-sm">
                            HN
                        </span>
                        <span class="logo-lg">
                            <img src="{{ asset('assets/images/logo.png') }}" alt="" height="20">
                        </span>
                    </a>
                </div>

                <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect vertical-menu-btn">
                    <i class="fa fa-fw fa-bars"></i>
                </button>

                <!-- App Search <form class="app-search d-none d-lg-block">
                <div class="position-relative">
                    <input type="text" class="form-control" placeholder="Search...">
                    <span class="uil-search"></span>
                </div>
            </form> -->

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

        <div data-simplebar class="sidebar-menu-scroll">
            <!--- Sidemenu -->
            <div id="sidebar-menu">
                <!-- Left Menu Start -->
                <ul class="metismenu list-unstyled" id="side-menu">
                    <li class="menu-title">Menu</li>

                    @foreach (config('routes') as $route)
                        <li>
                            <a href="{{ route($route['route']) }}">
                                <i class="uil-{{ $route['icon'] }}"></i>
                                <span>{{ $route['name'] }}</span>
                            </a>
                        </li>
                    @endforeach
                    <!-- Ajout de l'onglet Paiements -->
                    <li>
                        <a href="{{ route('payments.index') }}">
                            <i class="uil-credit-card"></i>
                            <span>Paiements</span>
                        </a>
                    </li>
                    <!-- Ajout de l'onglet Dossier de Société -->
                    <li>
                        <a href="{{ route('company_infos.show') }}">
                            <i class="uil-building"></i>
                            <span>Infos Société</span>
                        </a>
                    </li>


                </ul>
            </div>
        </div>

    </div>

    {{-- <nav class="navbar navbar-expand-lg navbar-light" style="background-color:#5AB2FF;"> --}}
    {{--    <div class="container-fluid"> --}}
    {{--        <a class="navbar-brand" href="{{ route('') }}" --}}
    {{--           style="color: #000000; font-family: Arial, sans-serif; font-weight: bold; font-size: 20px;">Home</a> --}}
    {{--        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" --}}
    {{--                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"> --}}
    {{--            <span class="navbar-toggler-icon"></span> --}}
    {{--        </button> --}}
    {{--        <div class="collapse navbar-collapse" id="navbarNav"> --}}
    {{--            <ul class="navbar-nav"> --}}
    {{--                <li class="nav-item"> --}}
    {{--                    <a class="nav-link" href="{{ route('categories.index') }}" --}}
    {{--                       style="color: #ffffff; font-family: Arial, sans-serif; font-weight: bold; font-size: 15px;">Categories</a> --}}
    {{--                </li> --}}
    {{--                <li class="nav-item"> --}}
    {{--                    <a class="nav-link" href="{{ route('products.index') }}" --}}
    {{--                       style="color: #ffffff; font-family: Arial, sans-serif; font-weight: bold; font-size: 15px;">Products</a> --}}
    {{--                </li> --}}
    {{--                <li class="nav-item"> --}}
    {{--                    <a class="nav-link" href="{{ route('clients.index') }}" --}}
    {{--                       style="color: #ffffff; font-family: Arial, sans-serif; font-weight: bold; font-size: 15px;">Clients</a> --}}
    {{--                </li> --}}
    {{--                <li class="nav-item"> --}}
    {{--                    <a class="nav-link" href="{{ route('sales.index') }}" --}}
    {{--                       style="color: #ffffff; font-family: Arial, sans-serif; font-weight: bold; font-size: 15px;">Sales</a> --}}
    {{--                </li> --}}
    {{--                <li class="nav-item"> --}}
    {{--                    <a class="nav-link" href="{{ route('stocks.index') }}" --}}
    {{--                       style="color: #ffffff; font-family: Arial, sans-serif; font-weight: bold; font-size: 15px;">Stocks</a> --}}
    {{--                </li> --}}
    {{--            </ul> --}}
    {{--        </div> --}}
    {{--    </div> --}}
    {{-- </nav> --}}


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
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            @yield('content')
                        </div>
                    </div>
                </div>
                <!-- end page title -->
            </div> <!-- container-fluid -->
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
    <script src="node_modules/chart.js/dist/chart.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @yield('scripts')
    @stack('custom-script')
</body>

</html>
