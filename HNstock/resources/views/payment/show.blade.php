@extends('base')

@section('title', 'Détails du Paiement')

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

        .btn-warning {
            background-color: #ffc107;
        }

        .btn-warning:hover {
            background-color: #e0a800;
        }
    </style>

    <div class="container">
        <!-- Card for Payment Information -->
        <div class="card">
            <div class="card-header">
                Détails du Paiement
            </div>
            <div class="card-body">
                <p><strong>Numéro de Paiement:</strong> {{ $payment->Npayment }}</p>
                <p><strong>Montant:</strong> {{ number_format($payment->montant, 2) }} MAD</p>
                <p><strong>Date de Paiement:</strong> {{ $payment->date_payment->format('d-m-Y') }}</p>
                <p><strong>Mode de Paiement:</strong> {{ $payment->mode_payment }}</p>
                <p><strong>Client:</strong> {{ $payment->client ? $payment->client->name : 'N/A' }}</p>
            </div>
        </div>

        <!-- Card for Payment Details Table -->
        <div class="card">
            <div class="card-header">
                Détails du Règlement
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>N Facture</th>
                            <th>Date Facture</th>
                            <th>Montant TTC</th>
                            <th>Montant Restant</th>
                            <th>Montant Réglé</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($payment->details as $detail)
                            <tr>
                                <td>{{ $detail->NFact }}</td>
                                <td>{{ $detail->DateFact }}</td>
                                <td>{{ number_format($detail->mttc, 2) }} MAD</td>
                                <td>{{ number_format($detail->montant_restant, 2) }} MAD</td>
                                <td>{{ number_format($detail->montant_regle, 2) }} MAD</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="text-center">
            <a href="{{ route('payments.index') }}" class="btn btn-secondary" title="Liste Réglement">
                <i class="fas fa-list"></i>
            </a>
            <a href="" class="btn btn-primary" title="imprimer">
                <i class="fas fa-print"></i>
            </a>
        </div>
    </div>
@endsection
