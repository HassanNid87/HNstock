<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            width: 80%;
            margin: auto;
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .invoice-header, .invoice-footer {
            margin-bottom: 20px;
        }
        .invoice-details {
            margin-top: 20px;
        }
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .invoice-table th, .invoice-table td {
            text-align: left;
            border: 1px solid #ddd;
            padding: 8px;
        }
        .invoice-table th {
            background-color: #dfdede;
        }
        .invoice-header img {
            max-width: 100px;
            margin-bottom: 20px;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .mt-3 {
            margin-top: 20px;
        }
        .company-info {
            width: 70%;
            float: left;
        }
        .invoice-info {
            width: 30%;
            float: right;
            text-align: left;
        }
        .clear {
            clear: both;
        }
        .footer {
            text-align: center;
            margin-top: 50px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row invoice-header">
        <div class="company-info">
            @if ($companyInfo->logo)
              <img src="{{ asset('storage/' . $companyInfo->logo) }}" alt="Logo de la société" width="100">
            @else
                <span>Aucun logo disponible</span>
             @endif
            <h4>{{ $companyInfo->name }}</h4>
            <p>{{ $companyInfo->address }}</p>
            <p>Site web: {{ $companyInfo->website }}</p>
            <p>Téléphone: {{ $companyInfo->phone }}</p>
            <p>Email: {{ $companyInfo->email }}</p>
        </div>

        <div class="invoice-info">
            <h1>Facture</h1>
            <p>N° facture: {{ $sale->NFact }}</p>
            <p>Date: {{ $sale->DateFact }}</p>
            <p>Client: {{ $sale->client->name }}</p>
        </div>
        <div class="clear"></div>
    </div>
    <div class="row invoice-details">
        <table class="invoice-table">
            <thead>
            <tr>
                <th>Produit</th>
                <th>Quantité</th>
                <th>Prix unitaire</th>
                <th>Total</th>
            </tr>
            </thead>
            <tbody>
            @foreach($sale->details as $detail)
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
    <div class="row invoice-footer text-right mt-3">
        <p><strong>Total: {{ number_format($sale->details->sum('total'), 2) }} MAD</strong></p>
    </div>
    <div class="footer">
        <p>Merci pour votre achat!</p>
    </div>
</div>
</body>
</html>
