<!-- resources/views/sale/show.blade.php -->

@extends('base')

@section('title', 'Sale Details')

@section('content')
    <style>
        .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            padding: 20px;
            background-color: #fff;
        }

        .card-header {
            font-size: 1.5em;
            border-bottom: 1px solid #ddd;
            margin-bottom: 15px;
            padding-bottom: 10px;
        }

        .card-body {
            padding: 0;
        }

        .card-body p {
            margin: 0;
            padding: 5px 0;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table th, .table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        .table th {
            background-color: #f2f2f2;
        }

        .summary {
            margin-top: 20px;
        }

        .summary p {
            margin: 5px 0;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 5px;
            text-decoration: none;
            border-radius: 5px;
            color: #fff;
            font-weight: bold;
            text-align: center;
        }

        .btn-primary {
            background-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-secondary {
            background-color: #6c757d;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }
    </style>

    <div class="container">
        <!-- Card for Sale Information -->
        <div class="card">
            <div class="card-header">
                Détails de la Facture
            </div>
            <div class="card-body">
                <p><strong>Numéro de Facture:</strong> {{ $sale->NFact }}</p>
                <p><strong>Date:</strong> {{ $sale->DateFact }}</p>
                <p><strong>Client:</strong> {{ $sale->client->name }}</p>
            </div>
        </div>

        <!-- Table for Product Details -->
        <div class="card">
            <div class="card-header">
                Détails des Produits
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Produit</th>
                            <th>Quantité</th>
                            <th>Prix Unitaire</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sale->details as $detail)
                            <tr>
                                <td>{{ $detail->product->name }}</td>
                                <td>{{ $detail->quantity }}</td>
                                <td>{{ number_format($detail->unit_price, 2) }} MAD</td>
                                <td>{{ number_format($detail->total, 2) }} MAD</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Summary Card -->
        <div class="card summary">
            <div class="card-header">
                Résumé de la Vente
            </div>
            <div class="card-body">
                <p><strong>Montant HT:</strong> {{ number_format($sale->mht, 2) }} MAD</p>
                <p><strong>TVA:</strong> {{ number_format($sale->mtva, 2) }} MAD</p>
                <p><strong>Remise:</strong> {{ number_format($sale->mremise, 2) }} MAD</p>
                <p><strong>Montant TTC:</strong> {{ number_format($sale->mttc, 2) }} MAD</p>
            </div>
        </div>

        <!-- Buttons -->
        <div class="text-center">
            <a href="{{ route('sales.index') }}" class="btn btn-secondary" title="Liste Factures">
                <i class="fas fa-list"></i>
            </a>
            <a href="{{ route('sales.invoice', $sale->id) }}" class="btn btn-primary" title="imprimer">
                <i class="fas fa-print"></i>
            </a>
        </div>
    </div>
@endsection
