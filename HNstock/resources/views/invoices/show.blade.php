<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture</title>
    <style>
        /* Stylez la facture ici */
        body { font-family: Arial, sans-serif; }
        .container { width: 80%; margin: 0 auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid #ddd; }
        th, td { padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .header { margin-bottom: 20px; }
        .footer { margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Facture</h1>
            <p><strong>Nom de la société:</strong> {{ $companyInfo->name }}</p>
            <p><strong>Adresse:</strong> {{ $companyInfo->address }}</p>
            <p><strong>Téléphone:</strong> {{ $companyInfo->phone }}</p>
            <p><strong>Email:</strong> {{ $companyInfo->email }}</p>
            <p><strong>Site web:</strong> {{ $companyInfo->website }}</p>
            <p><strong>Numéro de facture:</strong> {{ $sale->NFact }}</p>
            <p><strong>Date de facture:</strong> {{ $sale->DateFact }}</p>
        </div>

        <table>
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
                        <td>{{ $detail->unit_price }}</td>
                        <td>{{ $detail->total }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="footer">
            <p>Merci pour votre achat !</p>
        </div>
    </div>
</body>
</html>
