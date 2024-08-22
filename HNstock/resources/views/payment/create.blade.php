@extends('base')

@section('title', 'Ajouter un Paiement')

@section('content')


<div class="row">
    <div class="col-lg-12">
        <div id="addproduct-accordion" class="custom-accordion">
            <div class="card">
                <a href="#addproduct-billinginfo-collapse" class="text-dark" data-bs-toggle="collapse" aria-expanded="true" aria-controls="addproduct-billinginfo-collapse">
                    <div class="p-4">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar-xs">
                                    <div class="avatar-title rounded-circle bg-soft-primary text-primary">
                                        01
                                    </div>
                                </div>
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <h5 class="font-size-16 mb-1">Informations de Base</h5>
                                <p class="text-muted text-truncate mb-0">Remplissez toutes les informations ci-dessous</p>
                            </div>
                            <div class="flex-shrink-0">
                                <i class="mdi mdi-chevron-up accor-down-icon font-size-24"></i>
                            </div>

                        </div>

                    </div>
                </a>

                <div id="addproduct-billinginfo-collapse" class="collapse show" data-bs-parent="#addproduct-accordion">
                    <div class="p-4 border-top">
                        <form action="{{ route('payments.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="Npayment" class="form-label">N° Réglement</label>
                                        <input type="text" name="Npayment" id="Npayment" class="form-control" value="{{ $Npayment }}" readonly required>

                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                            <label for="date_payment" class="form-label">Date de Paiement</label>
                                             <input type="date" name="date_payment" id="date_payment" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="mode_payment" class="form-label">Mode de Paiement</label>
                                        <input type="text" name="mode_payment" id="mode_payment" class="form-control" required>
                                    </div>
                                </div>
                     <!--   </form>-->
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="client_id" class="form-label">Client</label>
                                <select name="client_id" id="client_id" class="form-select" required>
                                    <option value="" disabled selected>Sélectionnez un client</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="montant" class="form-label">Montant</label>
                                 <input type="number" name="montant" id="montant" class="form-control" step="0.01" required>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Liste des factures -->

                <div class="row">
                    <div class="mb-3">
                        <table class="table" id="sales-table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Numéro de Facture</th>
                                    <th>Date de Facture</th>
                                    <th>Montant TTC</th>
                                    <th>Montant Restant</th>
                                    <th>Montant à Régler</th>
                                </tr>
                            </thead>
                            <tbody id="sales-list">
                                <!-- Les lignes de factures seront ajoutées ici par JavaScript -->
                            </tbody>
                        </table>
                    </div>

                </div>

                </div>

                </div>
            </div>
            <div class="card">
                <a href="#addproduct-metadata-collapse" class="text-dark collapsed" data-bs-toggle="collapse" aria-haspopup="true" aria-expanded="false" aria-controls="addproduct-metadata-collapse">
                    <div class="p-4">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar-xs">
                                    <div class="avatar-title rounded-circle bg-soft-primary text-primary">
                                        02
                                    </div>
                                </div>
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <h5 class="font-size-16 mb-1">Montants Totaux</h5>
                                <p class="text-muted text-truncate mb-0">les montants totaux calculés les factures declient</p>
                            </div>
                            <div class="flex-shrink-0">
                                <i class="mdi mdi-chevron-up accor-down-icon font-size-24"></i>
                            </div>

                        </div>

                    </div>
                </a>

                <div id="addproduct-metadata-collapse" class="collapse" data-bs-parent="#addproduct-accordion">
                    <div class="p-4 border-top">
                        <form>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="total_remaining" class="form-label">Total des Montants Restants   </label>
                                        <input type="text" id="total_remaining" class="form-control" readonly></div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="total_selected" class="form-label">Total des Factures Sélectionnées</label>
                                         <input type="text" id="total_selected" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="difference" class="form-label">Solde</label>
                                        <input type="text" id="difference" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>

        <div class="row mb-4">
            <div class="col ms-auto">
                <div class="d-flex flex-reverse flex-wrap gap-2">
                    <a href="{{ route('payments.index') }}" class="btn btn-secondary" title="Liste Factures">
                        <i class="fas fa-list"></i>
                    </a>
                    <a href="#" class="btn btn-danger"> <i class="uil uil-times"></i> Cancel </a>
                    <a href="#" class="btn btn-success" t> <i class="uil uil-file-alt">

                    </i> </a>
                </div>
            </div> <!-- end col -->
        </div>
    </form>
    </div>
    </div>
</div>


<!-- Script JavaScript pour filtrer les factures -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    var totalAmount = 0; // Montant total de paiement

    // Quand le client est changé
    document.getElementById('client_id').addEventListener('change', function() {
        var clientId = this.value;
        var salesTableBody = document.getElementById('sales-list');
        salesTableBody.innerHTML = ''; // Vider le tableau actuel des factures
        totalAmount = parseFloat(document.getElementById('montant').value) || 0; // Montant total de paiement
        var remainingAmount = totalAmount; // Montant restant à appliquer sur les factures
        var totalRemainingAmount = 0; // Montant total des montants restants de toutes les factures

        var salesItems = @json($sales); // Charger toutes les ventes

        salesItems.forEach(function(sale) {
            if (sale.client_id == clientId && (sale.status === 'EnAttente' || sale.status === 'PartPayée')) { // Filtrer par statuts 'Attente' et 'Partiellement Payée'
                totalRemainingAmount += sale.montant_restant; // Ajouter au total des montants restants
                var amountToApply = Math.min(sale.montant_restant, remainingAmount); // Calculer le montant à appliquer pour cette facture
                remainingAmount -= amountToApply; // Réduire le montant restant

                var isChecked = amountToApply > 0 ? 'checked' : ''; // Sélectionner la facture si elle reçoit un paiement

                var row = `
                    <tr>
                        <td>
                            <input class="form-check-input" type="checkbox" name="sales[]" value="${sale.id}" data-amount="${sale.montant_restant}" id="sale${sale.id}" ${isChecked}>
                        </td>
                        <td>
                            <label class="form-check-label" for="sale${sale.id}">
                                ${sale.NFact}
                            </label>
                        </td>
                        <td>${sale.DateFact}</td>
                        <td>${sale.mttc}</td>
                        <td>${sale.montant_restant}</td>
                        <td>${amountToApply.toFixed(2)}</td> <!-- Afficher le montant appliqué -->
                    </tr>
                `;
                salesTableBody.innerHTML += row;

                if (remainingAmount <= 0) {
                    return false; // Arrêter la boucle si tout le montant a été utilisé
                }
            }
        });

        // Mettre à jour le total des montants restants et la différence
        document.getElementById('total_remaining').value = totalRemainingAmount.toFixed(2);
        updateTotalAndDifference();
    });

    // Quand le montant du paiement est modifié
    document.getElementById('montant').addEventListener('input', function() {
        totalAmount = parseFloat(this.value) || 0; // Réinitialiser le montant total de paiement
        document.getElementById('client_id').dispatchEvent(new Event('change')); // Réexécuter la logique pour mettre à jour le tableau
    });

    // Mettre à jour le total et la différence entre le montant payé et le total sélectionné
    function updateTotalAndDifference() {
        var checkboxes = document.querySelectorAll('#sales-list input[type="checkbox"]:checked');
        var totalSelected = Array.from(checkboxes).reduce((total, checkbox) => {
            return total + parseFloat(checkbox.getAttribute('data-amount'));
        }, 0);

        var difference = totalAmount - totalSelected;

        document.getElementById('total_selected').value = totalSelected.toFixed(2);
        document.getElementById('difference').value = difference.toFixed(2);
    }

    // Écouter les changements dans le tableau des factures sélectionnées
    document.getElementById('sales-list').addEventListener('change', function(event) {
        if (event.target.type === 'checkbox') {
            updateTotalAndDifference(); // Mettre à jour le total et la différence lorsque les cases sont sélectionnées/désélectionnées
        }
    });

    // Définir la date du jour par défaut
    var today = new Date().toISOString().split('T')[0];
    document.getElementById('date_payment').value = today;

    // Formater le numéro de paiement
    var npayment = "{{ $Npayment }}";
    document.getElementById('Npayment').value = npayment;
});

</script>
@endsection
