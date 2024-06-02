<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture</title>
    <!-- Include any CSS styles here -->

</head>
<body>
    <h1>Facture</h1>

    <!-- Afficher les détails de la vente ici -->
    <p>Numéro de facture : {{ $sale->NFact }}</p>
    <p>Date de facture : {{ $sale->DateFact }}</p>
    <!-- Autres détails de la vente -->

    <!-- Afficher les détails des produits vendus -->
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

    <!-- Afficher d'autres détails de la facture -->

    <!-- Include any additional HTML content here -->

    <!-- Include any JavaScript here -->

</body>
</html>
