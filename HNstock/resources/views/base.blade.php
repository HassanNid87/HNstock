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
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.2/css/bootstrap.min.css">


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
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
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box">
                    <a href="/" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="assets/images/logo-sm.png" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="assets/images/logo-dark.png" alt="" height="20">
                        </span>
                    </a>

                    <a href="/" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="assets/images/logo-sm.png" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="assets/images/logo-light.png" alt="" height="20">
                        </span>
                    </a>
                </div>

                <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect vertical-menu-btn">
                    <i class="fa fa-fw fa-bars"></i>
                </button>

                <!-- App Search-->
                <form class="app-search d-none d-lg-block">
                    <div class="position-relative">
                        <input type="text" class="form-control" placeholder="Rechercher...">
                        <span class="uil-search"></span>
                    </div>
                </form>
            </div>

            <div class="d-flex">

                <div class="dropdown d-inline-block d-lg-none ms-2">
                    <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="uil-search"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-search-dropdown">
                        <form class="p-3">
                            <div class="form-group m-0">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Rechercher..." aria-label="Recipient's username">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="dropdown d-inline-block language-switch">
                    <button type="button" class="btn header-item waves-effect" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="{{ asset('storage/photoprofil/drapomaroc.jpg') }}" alt="Header Language" height="16">
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a href="#" class="dropdown-item notify-item">
                            <img src=""  class="me-1" height="12">
                            <span class="align-middle">English</span>
                        </a>
                        <a href="#" class="dropdown-item notify-item">
                            <img src=""  class="me-1" height="12">
                            <span class="align-middle">Spanish</span>
                        </a>
                        <a href="#" class="dropdown-item notify-item">
                            <img src=""  class="me-1" height="12">
                            <span class="align-middle">German</span>
                        </a>
                        <a href="#" class="dropdown-item notify-item">
                            <img src=""  class="me-1" height="12">
                            <span class="align-middle">Italian</span>
                        </a>
                        <a href="#" class="dropdown-item notify-item">
                            <img src=""  class="me-1" height="12">
                            <span class="align-middle">Russian</span>
                        </a>
                    </div>
                </div>

                <div class="dropdown d-none d-lg-inline-block ms-1">
                    <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="uil-apps"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                        <div class="px-lg-2">
                            <div class="row g-0">
                                <div class="col">
                                    <a class="dropdown-icon-item" href="#">
                                        <img src="" alt="">
                                        <span>Gmail</span>
                                    </a>
                                </div>
                                <div class="col">
                                    <a class="dropdown-icon-item" href="#">
                                        <img src="" alt="">
                                        <span>Twiter</span>
                                    </a>
                                </div>
                                <div class="col">
                                    <a class="dropdown-icon-item" href="#">
                                        <img src="" alt="">
                                        <span>Quran</span>
                                    </a>
                                </div>
                            </div>
                            <div class="row g-0">
                                <div class="col">
                                    <a class="dropdown-icon-item" href="#">
                                        <img src=""">
                                        <span>Facebook</span>
                                    </a>
                                </div>
                                <div class="col">
                                    <a class="dropdown-icon-item" href="#">
                                        <img src="" alt="">
                                        <span>Youtube</span>
                                    </a>
                                </div>
                                <div class="col">
                                    <a class="dropdown-icon-item" href="#">
                                        <img src="" alt="">
                                        <span>Whatsapp</span>
                                    </a>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>

                <div class="dropdown d-none d-lg-inline-block ms-1">
                    <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="fullscreen">
                        <i class="uil-minus-path"></i>
                    </button>
                </div>

                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="uil-bell"></i>
                        <span class="badge bg-danger rounded-pill">3</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown">
                        <div class="p-3">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h5 class="m-0 font-size-16">Notifications</h5>
                                </div>
                                <div class="col-auto">
                                    <a href="#!" class="small">Tout marquer comme lu</a>
                                </div>
                            </div>
                        </div>
                        <div data-simplebar style="max-height: 230px;">
                            <a href="" class="text-reset notification-item">
                                <div class="d-flex align-items-start">
                                    <div class="avatar-xs me-3">
                                        <span class="avatar-title bg-primary rounded-circle font-size-16">
                                            <i class="uil-shopping-basket"></i>
                                        </span>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mt-0 mb-1">Votre commande a été passée</h6>
                                        <div class="font-size-12 text-muted">
                                            <p class="mb-1">La commande a été enregistrée avec succès.</p>
                                            <p class="mb-0"><i class="mdi mdi-clock-outline"></i> Il y a 3 minutes</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="" class="text-reset notification-item">
                                <div class="d-flex align-items-start">
                                    <img src="assets/images/users/avatar-3.jpg" class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                    <div class="flex-grow-1">
                                        <h6 class="mt-0 mb-1">Rachid Moutaouakil</h6>
                                        <div class="font-size-12 text-muted">
                                            <p class="mb-1">Votre facture a été mise à jour.</p>
                                            <p class="mb-0"><i class="mdi mdi-clock-outline"></i> Il y a 1 heure</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="" class="text-reset notification-item">
                                <div class="d-flex align-items-start">
                                    <div class="avatar-xs me-3">
                                        <span class="avatar-title bg-success rounded-circle font-size-16">
                                            <i class="uil-truck"></i>
                                        </span>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mt-0 mb-1">Votre article a été expédié</h6>
                                        <div class="font-size-12 text-muted">
                                            <p class="mb-1">L'article a été envoyé et est en route.</p>
                                            <p class="mb-0"><i class="mdi mdi-clock-outline"></i> Il y a 3 minutes</p>
                                        </div>
                                    </div>
                                </div>
                            </a>

                            <a href="" class="text-reset notification-item">
                                <div class="d-flex align-items-start">
                                    <div class="avatar-xs me-3">
                                        <span class="avatar-title bg-danger rounded-circle font-size-16">
                                            <i class="uil-exclamation-triangle"></i>
                                        </span>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mt-0 mb-1">Votre commande a été annulée</h6>
                                        <div class="font-size-12 text-muted">
                                            <p class="mb-1">Votre commande a été annulée en raison d'un problème.</p>
                                            <p class="mb-0"><i class="mdi mdi-clock-outline"></i> Il y a 1 heure</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="p-2 border-top">
                            <div class="d-grid">
                                <a class="btn btn-sm btn-link font-size-14 text-center" href="javascript:void(0)">
                                    <i class="uil-arrow-circle-right me-1"></i> Voir plus..
                                </a>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="rounded-circle header-profile-user" src="{{ asset('storage/photoprofil/HassanNid.jpg') }}" alt="Profile Avatar">
                        <span class="d-none d-xl-inline-block ms-1 fw-medium font-size-15">Hassan NidElarj</span>
                        <i class="uil-angle-down d-none d-xl-inline-block font-size-15"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <a class="dropdown-item" href="#"><i class="uil uil-user-circle font-size-18 align-middle text-muted me-1"></i> <span class="align-middle">View Profile</span></a>
                        <a class="dropdown-item" href="#"><i class="uil uil-wallet font-size-18 align-middle me-1 text-muted"></i> <span class="align-middle">My Wallet</span></a>
                        <a class="dropdown-item d-block" href="#"><i class="uil uil-cog font-size-18 align-middle me-1 text-muted"></i> <span class="align-middle">Settings</span> <span class="badge bg-soft-success rounded-pill mt-1 ms-2">03</span></a>
                        <a class="dropdown-item" href="#"><i class="uil uil-lock-alt font-size-18 align-middle me-1 text-muted"></i> <span class="align-middle">Lock screen</span></a>
                        <a class="dropdown-item" href="#"><i class="uil uil-sign-out-alt font-size-18 align-middle me-1 text-muted"></i> <span class="align-middle">Sign out</span></a>
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

        <div data-simplebar class="sidebar-menu-scroll">
            <!--- Sidemenu -->
            <div id="sidebar-menu">
                <!-- Left Menu Start -->
                <ul class="metismenu list-unstyled" id="side-menu">
                   <!-- <li class="menu-title">Menu</li>-->

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
                        <script>document.write(new Date().getFullYear())</script> - 2019 © All rights reserved.
                    </div>
                    <div class="col-sm-6">
                        <div class="text-sm-end d-none d-sm-block">
                            Created <i class="mdi mdi-heart text-danger"></i> by <a href="#" target="_blank" class="text-reset">HassanNid: 06.68.28.33.63</a>
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
