<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .invoice-header, .invoice-footer {
            text-align: center;
            margin-bottom: 20px;
        }
        .invoice-details {
            margin-bottom: 20px;
        }
        .invoice-table th, .invoice-table td {
            text-align: center;
        }
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
        }
        .invoice-table th, .invoice-table td {
            border: 1px solid #dee2e6;
            padding: 8px;
        }
        .invoice-table th {
            background-color: #f8f9fa;
        }
        .invoice-total {
            font-weight: bold;
        }
        .logo img {
            max-height: 60px;
        }
        .contact-info {
            font-size: 14px;
            margin-top: 10px;
        }
        .footer-text {
            font-size: 12px;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <!-- En-tête de la facture -->
        <div class="invoice-header">
            <div class="row">
                <div class="col-6 text-left">
                    <!-- Logo de la société -->
                    @if($companyInfo->logo)
                        <div class="logo">
                            <img src="{{ asset('storage/' . $companyInfo->logo) }}" alt="Logo de la société">
                        </div>
                    @endif
                </div>
                <div class="col-6 text-right">
                    <!-- Coordonnées de la société -->
                    <div class="contact-info">
                        <p><strong>{{ $companyInfo->name }}</strong></p>
                        <p>{{ $companyInfo->address }}</p>
                        <p>Téléphone: {{ $companyInfo->phone }}</p>
                        <p>Email: {{ $companyInfo->email }}</p>
                        <p>Site web: {{ $companyInfo->website }}</p>
                    </div>
                </div>
            </div>
            <h1>Facture</h1>
            <p><strong>Numéro de facture :</strong> {{ $sale->NFact }}</p>
            <p><strong>Date de facture :</strong> {{ $sale->DateFact }}</p>
        </div>

        <!-- Détails de la facture -->
        <div class="invoice-details">
            <h4>Détails de la vente</h4>
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
                            <td>{{ number_format($detail->unit_price, 2) }} €</td>
                            <td>{{ number_format($detail->total, 2) }} €</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pied de page -->
        <div class="invoice-footer">
            <p><strong>Total général :</strong> {{ number_format($sale->total, 2) }} €</p>
            <p class="footer-text">
                Merci pour votre achat ! Si vous avez des questions ou des préoccupations, n'hésitez pas à nous contacter.
            </p>
        </div>
    </div>
</body>
</html>
