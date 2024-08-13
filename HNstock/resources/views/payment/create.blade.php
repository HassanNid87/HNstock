@extends('base')

@section('title', 'Ajouter un Paiement')

@section('content')
<div class="container">
    <h1>Ajouter un Paiement</h1>
    <form action="{{ route('payments.store') }}" method="POST">
        @csrf

       <!-- Numéro de paiement (Généré automatiquement) -->
       <div class="mb-3">
        <label for="Npayment" class="form-label">Numéro de Paiement</label>
        <input type="text" name="Npayment" id="Npayment" class="form-control" value="{{ $Npayment }}" readonly required>
    </div>

        <!-- Montant -->
        <div class="mb-3">
            <label for="montant" class="form-label">Montant</label>
            <input type="number" name="montant" id="montant" class="form-control" step="0.01" required>
        </div>

       <!-- Date de paiement (Date du jour par défaut) -->
       <div class="mb-3">
        <label for="date_payment" class="form-label">Date de Paiement</label>
        <input type="date" name="date_payment" id="date_payment" class="form-control" required>
    </div>

        <!-- Mode de paiement -->
        <div class="mb-3">
            <label for="mode_payment" class="form-label">Mode de Paiement</label>
            <input type="text" name="mode_payment" id="mode_payment" class="form-control" required>
        </div>


        <hr>
       <!-- Sélection du client -->
       <div class="mb-3">
        <label for="client_id" class="form-label">Client</label>
        <select name="client_id" id="client_id" class="form-select" required>
            <option value="" disabled selected>Sélectionnez un client</option>
            @foreach($clients as $client)
                <option value="{{ $client->id }}">{{ $client->name }}</option>
            @endforeach
        </select>
    </div>

  <!-- Liste des factures -->
<div class="mb-3">
    <label for="sales" class="form-label">Factures</label>
    <table class="table table-bordered" id="sales-table">
        <thead>
            <tr>
                <th></th>
                <th>Numéro de Facture</th>
                <th>Date de Facture</th>
                <th>Montant TTC</th>
            </tr>
        </thead>
        <tbody id="sales-list">
            <!-- Les lignes de factures seront ajoutées ici par JavaScript -->
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


        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
</div>
<!-- Script JavaScript pour filtrer les factures -->
<script>
    document.getElementById('client_id').addEventListener('change', function() {
        var clientId = this.value;
        var salesTableBody = document.getElementById('sales-list');
        salesTableBody.innerHTML = ''; // Vider le tableau actuel des factures
        var totalSelected = 0; // Variable pour le total des factures sélectionnées

        var salesItems = @json($sales); // Charger toutes les ventes

        salesItems.forEach(function(sale) {
            if (sale.client_id == clientId && sale.status === 'pending') { // Filtrer par statut 'pending'
                var row = `
                    <tr>
                        <td>
                            <input class="form-check-input" type="checkbox" name="sales[]" value="${sale.id}" data-amount="${sale.mttc}" id="sale${sale.id}">
                        </td>
                        <td>
                            <label class="form-check-label" for="sale${sale.id}">
                                ${sale.NFact}
                            </label>
                        </td>
                        <td>${sale.DateFact}</td>
                        <td>${sale.mttc}</td>
                    </tr>
                `;
                salesTableBody.innerHTML += row;
            }
        });

        // Ajouter un événement pour mettre à jour le total et la différence lorsque les cases sont sélectionnées/désélectionnées
        salesTableBody.addEventListener('change', function(event) {
            if (event.target.type === 'checkbox') {
                var checkboxes = salesTableBody.querySelectorAll('input[type="checkbox"]:checked');
                totalSelected = Array.from(checkboxes).reduce((total, checkbox) => {
                    return total + parseFloat(checkbox.getAttribute('data-amount'));
                }, 0);

                // Calculer et mettre à jour la différence
                var montantPayment = parseFloat(document.getElementById('montant').value) || 0;
                var difference = montantPayment - totalSelected;

                document.getElementById('total_selected').value = totalSelected.toFixed(2);
                document.getElementById('difference').value = difference.toFixed(2);
            }
        });

        // Ajouter un événement pour mettre à jour la différence lorsque le montant du paiement change
        document.getElementById('montant').addEventListener('input', function() {
            var montantPayment = parseFloat(this.value) || 0;
            var difference = montantPayment - totalSelected;

            document.getElementById('difference').value = difference.toFixed(2);
        });
    });
    // Script pour définir la date du jour

    document.addEventListener('DOMContentLoaded', function() {
        var today = new Date().toISOString().split('T')[0];
        document.getElementById('date_payment').value = today;
    });

    // Script pour définir la date du jour et formater le numéro de règlement

    document.addEventListener('DOMContentLoaded', function() {
        var today = new Date().toISOString().split('T')[0];
        document.getElementById('date_payment').value = today;

        // Format du numéro de paiement
        var npayment = "{{ $Npayment }}" + "-" + today.replace(/-/g, '');
        document.getElementById('Npayment').value = npayment;
    });
</script>





@endsection

