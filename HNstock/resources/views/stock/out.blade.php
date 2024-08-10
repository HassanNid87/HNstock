@extends('base')

@section('title', 'Stock Out')

@section('content')
<div class="container my-5">
    <a href="{{ route('stocks.index') }}" class="btn btn-secondary mb-3">Stock Liste</a>

    <!-- Formulaire de filtrage par date -->
    <form action="{{ route('stock.out') }}" method="GET" class="mb-4">
        <div class="row">
            <div class="col-md-3">
                <label for="start_date" class="form-label">Du</label>
                <input type="date" id="start_date" name="start_date" class="form-control" value="{{ request('start_date', date('Y-m-d')) }}">
            </div>
            <div class="col-md-3">
                <label for="end_date" class="form-label">Au</label>
                <input type="date" id="end_date" name="end_date" class="form-control" value="{{ request('end_date', date('Y-m-d')) }}">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary" title="Filtrer">
                    <i class="fas fa-filter"></i>
                </button>
            </div>
        </div>
    </form>

    <!-- Carte pour afficher les sorties de stock -->
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="card-title">Stock Out</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Categorie</th>
                        <th>Product</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($stockOuts as $stockOut)
                        <tr>
                            <td>{{ $stockOut['date'] }}</td>
                            <td>{{ $stockOut['category'] }}</td>
                            <td>{{ $stockOut['product']->name }}</td>
                            <td>{{ $stockOut['quantity'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
