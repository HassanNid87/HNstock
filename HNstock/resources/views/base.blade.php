<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | {{ config('app.name') }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .navbar-nav .nav-link:hover {
            color: #000000 !important; /* Changer la couleur du texte lors du survol */
            background-color: #ffffff !important; /* Changer la couleur de fond lors du survol */
        }


    </style>

</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color:#5AB2FF;">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('store.index') }}" style="color: #000000; font-family: Arial, sans-serif; font-weight: bold; font-size: 20px;">Home</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('categories.index') }}" style="color: #ffffff; font-family: Arial, sans-serif; font-weight: bold; font-size: 15px;">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products.index') }}" style="color: #ffffff; font-family: Arial, sans-serif; font-weight: bold; font-size: 15px;">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('clients.index') }}" style="color: #ffffff; font-family: Arial, sans-serif; font-weight: bold; font-size: 15px;">Clients</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('sales.index') }}" style="color: #ffffff; font-family: Arial, sans-serif; font-weight: bold; font-size: 15px;">Sales</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('stocks.index') }}" style="color: #ffffff; font-family: Arial, sans-serif; font-weight: bold; font-size: 15px;">Stocks</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        @if($errors->any())
            <div class="alert alert-danger" role="alert">
                <strong>Errors</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @yield('content')
    </div>



    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybBgq8aXCbibzQG8poVRW6LhJ6MzzT6Qf6KpG7rBPsSx5K+N2" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-pZIm8a0DYdL4Dk5cz1EziFW/Mun0HjElcpM1Z9uj4rU7nsfzFiMnU3/P+7x7BSZ6" crossorigin="anonymous"></script>

    <script src="node_modules/chart.js/dist/chart.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>
</html>
