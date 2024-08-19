@extends('base')

@section('title', 'Modifier le Paiement')

@section('content')
<div class="container">
    <h1>Modifier le Paiement</h1>
    <form action="{{ route('payments.update', $payment->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Numéro de paiement -->
        <div class="mb-3">
            <label for="Npayment" class="form-label">Numéro de Paiement</label>
            <input type="text" name="Npayment" id="Npayment" class="form-control" value="{{ $payment->Npayment }}" readonly required>
        </div>

        <!-- Montant -->
        <div class="mb-3">
            <label for="montant" class="form-label">Montant</label>
            <input type="number" name="montant" id="montant" class="form-control" step="0.01" value="{{ $payment->montant }}" required>
        </div>

        <!-- Date de paiement -->
        <div class="mb-3">
            <label for="date_payment" class="form-label">Date de Paiement</label>
            <input type="date" name="date_payment" id="date_payment" class="form-control" value="{{ $payment->date_payment->format('Y-m-d') }}" required>
        </div>

        <!-- Mode de paiement -->
        <div class="mb-3">
            <label for="mode_payment" class="form-label">Mode de Paiement</label>
            <input type="text" name="mode_payment" id="mode_payment" class="form-control" value="{{ $payment->mode_payment }}" required>
        </div>

        <hr>

        <!-- Sélection du client -->
        <div class="mb-3">
            <label for="client_id" class="form-label">Client</label>
            <select name="client_id" id="client_id" class="form-select" required>
                <option value="" disabled>Sélectionnez un client</option>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}" {{ $payment->client_id == $client->id ? 'selected' : '' }}>
                        {{ $client->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Liste des factures -->
        <div class="mb-3">
            <label for="sales" class="form-label">Factures</label>
            <table class="table">
                <thead>
                    <tr>
                        <th>  #
                        </th>
                        <th>N Facture</th>
                        <th>Date Facture</th>
                        <th>Montant TTc</th>
                        <th>Montant Restant</th>
                        <th>Montant Réglée</th>
                    </tr>
                </thead>
                <tbody id="sales-list">
                    @foreach ($payment->details as $detail)
                        <tr>
                            <td>
                                <input class="form-check-input" type="checkbox" name="sales[]" value="{{ $detail->id }}" data-amount="{{ $detail->montant_restant }}" id="sale{{ $detail->id }}">
                            </td>
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

        <hr>

        <!-- Total des factures sélectionnées -->
        <div class="mb-3">
            <label for="total_selected" class="form-label">Total des Factures Sélectionnées</label>
            <input type="text" id="total_selected" class="form-control" readonly>
        </div>

        <!-- Différence entre le montant du paiement et le total des factures sélectionnées -->
        <div class="mb-3">
            <label for="difference" class="form-label">Différence</label>
            <input type="text" id="difference" class="form-control" readonly>
        </div>

        <button type="submit" class="btn btn-primary">Mettre à Jour</button>
    </form>
</div>

<!-- Script JavaScript pour gérer les interactions -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var salesTableBody = document.getElementById('sales-list');
        var totalSelected = 0;

        // Fonction pour mettre à jour le total et la différence
        function updateTotalAndDifference() {
            var checkboxes = salesTableBody.querySelectorAll('input[type="checkbox"]:checked');
            totalSelected = Array.from(checkboxes).reduce((total, checkbox) => {
                return total + parseFloat(checkbox.getAttribute('data-amount'));
            }, 0);

            var montantPayment = parseFloat(document.getElementById('montant').value) || 0;
            var difference = montantPayment - totalSelected;

            document.getElementById('total_selected').value = totalSelected.toFixed(2);
            document.getElementById('difference').value = difference.toFixed(2);
        }

        // Ajouter des événements pour mettre à jour les totaux lors de la sélection/désélection des factures
        salesTableBody.addEventListener('change', function(event) {
            if (event.target.type === 'checkbox') {
                updateTotalAndDifference();
            }
        });

        // Ajouter un événement pour mettre à jour la différence lorsque le montant du paiement change
        document.getElementById('montant').addEventListener('input', function() {
            updateTotalAndDifference();
        });

        // Initialiser le calcul des totaux
        updateTotalAndDifference();
    });
</script>

<script>
    var selectedSales = @json($selectedSales);

    selectedSales.forEach(function(saleId) {
        var checkbox = document.getElementById(`sale${saleId}`);
        if (checkbox) {
            checkbox.checked = true;
        }
    });
</script>
@endsection
