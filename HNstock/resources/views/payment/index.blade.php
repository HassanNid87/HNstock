@extends('base')
@section('title', 'Liste des Paiements')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0">Liste Réglements</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Réglements</a></li>
                    <li class="breadcrumb-item active">Liste Réglements</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<div class="col-lg-12">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="col-md-4">
            <div>
                <a href="{{ route('payments.create') }}" title="Nouvelle Facture">
                    <button type="button" class="btn btn-success waves-effect waves-light me-2">
                    <i class="mdi mdi-plus me-1"></i>

                </button>
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Formulaire pour le filtre de date (50%) -->
        <div class="col-md-6">
            <form method="get" id="dateFilterForm" action="{{ url()->current() }}" class="d-flex align-items-center">
                <div class="input-daterange input-group w-100" id="datepicker6" data-date-format="yyyy-mm-dd" data-date-autoclose="true">
                    <input type="text" class="form-control text-start form-control-sm" placeholder="From" name="start_date" id="start_date" value="{{ request('start_date') }}" autocomplete="off" autocorrect="off">
                    <input type="text" class="form-control text-start form-control-sm" placeholder="To" name="end_date" id="end_date" value="{{ request('end_date') }}" autocomplete="off" autocorrect="off">
                </div>
                <button type="submit" class="btn btn-primary btn-sm ms-2">
                    <i class="mdi mdi-filter-variant"></i>
                </button>
                <a class="btn btn-secondary btn-sm ms-2" href="{{ route('payments.index') }}" title="Reset">
                    <i class="fas fa-redo"></i>
                </a>
            </form>
        </div>

        <!-- Filtre pour le code client et le numéro de règlement (50%) -->
        <div class="col-md-6">
            <div class="row">
                <!-- Formulaire pour le filtre de code client (50% de la moitié) -->
                <div class="col-md-6">
                    <form method="get" id="clientForm" class="d-flex align-items-center">
                        <input type="search" name="code" id="code" class="form-control form-control-sm w-100"
                               placeholder="Code Client" value="{{ request('code') }}" aria-controls="DataTables_Table_0">
                    </form>
                </div>

                <!-- Formulaire pour le filtre de numéro de règlement (50% de la moitié) -->
                <div class="col-md-6">
                    <form method="get" id="searchForm" class="d-flex align-items-center">
                        <input type="search" name="Npayment" id="Npayment" class="form-control form-control-sm w-100"
                               placeholder="N° Réglement" value="{{ Request::input('Npayment') }}" aria-controls="DataTables_Table_0">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-lg-12">
        <div class="table-responsive mb-4">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                  <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-centered datatable dt-responsive nowrap table-card-list dataTable no-footer dtr-inline" style="border-collapse: collapse; border-spacing: 0px 12px; width: 100%;" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                            <thead style="background-color: #dde0e0;">
                                <tr class="bg-transparent" role="row">
                                    <th style="width: 24px;" class="sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label=": activate to sort column descending">
                                        <!--<div class="form-check text-center">
                                            <input type="checkbox" class="form-check-input" id="invoicecheck">
                                            <label class="form-check-label" for="invoicecheck"></label>
                                        </div>-->
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 86px;" aria-label="Invoice ID: activate to sort column ascending">N° Régelement</th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 100px;" aria-label="Date: activate to sort column ascending">Date</th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 117px;" aria-label="Client: activate to sort column ascending">Client</th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 37px;" aria-label="Amount: activate to sort column ascending">Montant</th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 105px;" aria-label="Status: activate to sort column ascending">Mode Régl</th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 127px;" aria-label="Download Pdf: activate to sort column ascending">Download Pdf</th>
                                    <th style="width: 120px;" class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($payments as $payment)
                                    <tr role="row" class="odd">
                                        <td class="sorting_1 dtr-control">
                                            <div class="form-check text-center">
                                                <input type="checkbox" class="form-check-input" id="invoicecheck1">
                                                <label class="form-check-label" for="invoicecheck1"></label>
                                            </div>
                                        </td>
                                        <td class="sorting_1">
                                            <a href="javascript: void(0);" class="text-dark fw-bold">#{{ $payment->Npayment ?? 'N/A' }}</a>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($payment->date_payment)->format('Y-m-d') }}</td>
                                        <td> @if ($payment->client)
                                            <a href="" class="btn btn-link">
                                                <span class="badge" style="background-color:#789ec2;">
                                                    {{ $payment->client->name }}
                                                </span>
                                            </a>
                                        @else
                                            ----------
                                        @endif</td>
                                        <td class="text-dark fw-bold">{{ $payment->montant ?? 'N/A' }}</td>
                                        <td>  @php
                                            // Déterminez la couleur de fond en fonction du statut
                                            $backgroundColor = '';
                                            switch ($payment->mode_payment) {
                                                case 'Espèce':
                                                    $backgroundColor = '#11a333'; // Vert clair
                                                    break;
                                                case 'Chèque':
                                                    $backgroundColor = '#c00515'; // Rouge clair
                                                    break;
                                                case 'VirBancaire':
                                                    $backgroundColor = '#f3bc06'; // Orange clair
                                                    break;
                                                    case 'Carte de Crédit':
                                                    $backgroundColor = '#921A40'; // Orange clair
                                                    break;
                                                default:
                                                    $backgroundColor = '#ffffff'; // Couleur par défaut si aucun statut ne correspond
                                                    break;
                                            }
                                        @endphp
                                        <a class="btn btn-link">
                                            <span class="badge" style="background-color: {{ $backgroundColor }};">
                                                {{ $payment->mode_payment }}
                                            </span>
                                        </a>
                                        </td>
                                        <td style="white-space: nowrap;">
                                            <!-- Download Pdf Button -->
                                            <button class="btn btn-light btn-sm w-xs">
                                                <a href=""  title="Print">
                                                    PDF   <i class="uil uil-download-alt ms-2"></i></a>
                                            </button>
                                        </td>
                                        <td>
                                             <!-- Edit Button -->
                                             <a href="{{ route('payments.edit', $payment) }}" class="btn btn-sm btn-outline-primary rounded" title="Update">
                                                <i class="uil uil-pen font-size-14"></i>
                                            </a>
                                            <!-- Delete Button -->
                                            <form method="POST" action="{{ route('payments.destroy', $payment) }}" onsubmit="return confirm('Are you sure you want to delete this payment?')" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger rounded" title="Delete">
                                                    <i class="uil uil-trash-alt font-size-14"></i>
                                                </button>
                                            </form>
                                            <!-- Button for Showing Details -->
                                            <a href="{{ route('payments.show', $payment) }}" class="btn btn-sm btn-outline-info rounded" title="Afficher les détails">
                                                <i class="uil uil-eye font-size-14"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No Régelement found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-5">
                        <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">
                                 Affichage de 1 à 10 sur 12 entrées                        </div>
                    </div>
                    <div class="col-sm-12 col-md-7">
                        <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
                            <ul class="pagination">
                                <li class="paginate_button page-item previous disabled" id="DataTables_Table_0_previous">
                                    <a href="#" aria-controls="DataTables_Table_0" data-dt-idx="0" tabindex="0" class="page-link">
                                        Previous</a>
                                    </li>
                                    <li class="paginate_button page-item active">
                                        <a href="#" aria-controls="DataTables_Table_0" data-dt-idx="1" tabindex="0" class="page-link">1</a>
                                    </li>
                                    <li class="paginate_button page-item ">
                                        <a href="#" aria-controls="DataTables_Table_0" data-dt-idx="2" tabindex="0" class="page-link">2</a>
                                    </li>
                                    <li class="paginate_button page-item next" id="DataTables_Table_0_next">
                                        <a href="#" aria-controls="DataTables_Table_0" data-dt-idx="3" tabindex="0" class="page-link">Next</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="mb-3">
            <form method="get" action="{{ url()->current() }}" id="filterForm">
                <div class="form-group d-flex flex-wrap">
                    <div class="form-check me-3">
                        <input type="checkbox" name="mode_payment[]" value="Espèce" id="mode_payment_Espèce" class="form-check-input" {{ in_array('Espèce', Request::input('mode_payment', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="mode_payment_Espèce">Espèce</label>
                    </div>
                    <div class="form-check me-3">
                        <input type="checkbox" name="mode_payment[]" value="Chèque" id="mode_payment_Chèque" class="form-check-input" {{ in_array('Chèque', Request::input('mode_payment', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="mode_payment_Chèque">Chèque</label>
                    </div>
                    <div class="form-check me-3">
                        <input type="checkbox" name="mode_payment[]" value="VirBancaire" id="mode_payment_VirBancaire" class="form-check-input" {{ in_array('VirBancaire', Request::input('mode_payment', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="mode_payment_VirBancaire">Virement Bancaire</label>
                    </div>
                    <div class="form-check me-3">
                        <input type="checkbox" name="mode_payment[]" value="Carte de Crédit" id="mode_payment_Carte" class="form-check-input" {{ in_array('Carte de Crédit', Request::input('mode_payment', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="mode_payment_Carte">Carte de Crédit</label>
                    </div>
                    <div class="form-check me-3">
                        <input type="checkbox" name="mode_payment[]" value="Autre" id="mode_payment_Autre" class="form-check-input" {{ in_array('Autre', Request::input('mode_payment', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="mode_payment_Autre">Autre</label>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#datepicker6').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('Npayment');
        const searchForm = document.getElementById('searchForm');

        // Listen for input changes
        searchInput.addEventListener('input', function() {
            if (searchInput.value === '') {
                searchForm.submit(); // Automatically submit the form if the input is cleared
            }
        });

        const clientInput = document.getElementById('code');
        const clientForm = document.getElementById('clientForm');

        clientInput.addEventListener('input', function() {
            if (clientInput.value === '') {
                clientForm.submit(); // Automatically submit the form if the input is cleared
            }
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Soumet le formulaire chaque fois qu'une case est cochée ou décochée
        document.querySelectorAll('#filterForm input[type="checkbox"]').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                document.getElementById('filterForm').submit();
            });
        });
    });
</script>


@endsection
