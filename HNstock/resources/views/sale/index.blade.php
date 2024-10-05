@extends('base')
@section('title', 'Sales')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0">Liste des Ventes</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Ventes</a></li>
                    <li class="breadcrumb-item active">Liste des Ventes</li>
                </ol>
            </div>

        </div>
    </div>
</div>

<div class="col-lg-12">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="col-md-4">
            <div>
                <a href="{{ route('sales.create') }}" title="Nouvelle Facture">
                    <button type="button" class="btn btn-success waves-effect waves-light me-2">
                    <i class="mdi mdi-plus me-1"></i> <!-- Nouvelle icône -->

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
                <a class="btn btn-secondary btn-sm ms-2" href="{{ route('sales.index') }}" title="Reset">
                    <i class="fas fa-redo"></i>
                </a>
            </form>
        </div>

        <!-- Filtre pour le code client et le numéro de facture (50%) -->
        <div class="col-md-6">
            <div class="row">
                <!-- Formulaire pour le filtre de code client (50% de la moitié) -->
                <div class="col-md-6">
                    <form method="get" id="clientForm" class="d-flex align-items-center">
                        <input type="search" name="code" id="code" class="form-control form-control-sm w-100"
                               placeholder="Client Code" value="{{ Request::input('code') }}" aria-controls="DataTables_Table_0">
                    </form>
                </div>

                <!-- Formulaire pour le filtre de numéro de facture (50% de la moitié) -->
                <div class="col-md-6">
                    <form method="get" id="searchForm" class="d-flex align-items-center">
                        <input type="search" name="NFacture" id="NFacture" class="form-control form-control-sm w-100"
                               placeholder="N° Facture" value="{{ Request::input('NFacture') }}" aria-controls="DataTables_Table_0">
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
                                        <th style="width: 24px;" class="sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="

                                        : activate to sort column descending">
                                            <!--<div class="form-check text-center">
                                                <input type="checkbox" class="form-check-input" id="invoicecheck">
                                                <label class="form-check-label" for="invoicecheck"></label>
                                            </div>-->
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 96px;" aria-label="Invoice ID: activate to sort column ascending">N°Fact</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 110px;" aria-label="Date: activate to sort column ascending">Date</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 127px;" aria-label="Billing Name: activate to sort column ascending">Client</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 77px;" aria-label="Amount: activate to sort column ascending">M TTC</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 65px;" aria-label="Status: activate to sort column ascending">Statut</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 77px;" aria-label="reste: activate to sort column ascending">Reste</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 127px;" aria-label="Download Pdf: activate to sort column ascending">Download Pdf</th>
                                        <th style="width: 120px;" class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending">Actions</th></tr>
                                </thead>
                                    <tbody>
                                        @forelse ($sales as $sale)
                                        <tr role="row" class="odd">
                                            <td class="sorting_1 dtr-control">
                                                <div class="form-check text-center">
                                                    <input type="checkbox" class="form-check-input" id="invoicecheck1">
                                                    <label class="form-check-label" for="invoicecheck1"></label>
                                                </div>
                                            </td>
                                            <td class="sorting_1">
                                                <a href="javascript: void(0);" class="text-dark fw-bold">#{{ $sale->NFact }}</a></td>
                                            <td>{{ $sale->DateFact }}</td>
                                            <td> @if ($sale->client)
                                                <a href="{{ route('clients.show', $sale->client_id) }}" class="btn btn-link">
                                                    <span class="badge" style="background-color:#789ec2;">
                                                        {{ $sale->client->name }}
                                                    </span>
                                                </a>
                                            @else
                                                ----------
                                            @endif</td>
                                            <td class="text-dark fw-bold">{{ number_format($sale->mttc, 2) }}</td>
                                            <td>
                                                @php
                                                // Déterminez la couleur de fond en fonction du statut
                                                $backgroundColor = '';
                                                switch ($sale->status) {
                                                    case 'Réglée':
                                                        $backgroundColor = '#11a333'; // Vert clair
                                                        break;
                                                    case 'EnAttente':
                                                        $backgroundColor = '#c00515'; // Rouge clair
                                                        break;
                                                    case 'PartPayée':
                                                        $backgroundColor = '#f3bc06'; // Orange clair
                                                        break;
                                                    default:
                                                        $backgroundColor = '#ffffff'; // Couleur par défaut si aucun statut ne correspond
                                                        break;
                                                }
                                            @endphp

                                            <a class="btn btn-link">
                                                <span class="badge" style="background-color: {{ $backgroundColor }};">
                                                    {{ $sale->status }}
                                                </span>
                                            </a>
                                            </td>
                                            <td>{{ number_format($sale->montant_restant, 2) }}</td>
                                            <td>
                                                <button class="btn btn-light btn-sm w-xs">
                                                    <a href="{{ route('sales.invoice', $sale->id) }}"  title="Print">


                                                        PDF   <i class="uil uil-download-alt ms-2"></i></a>
                                                </button>
                                            </td>
                                            <td style="white-space: nowrap;">
                                                <!-- Delete Button -->
                                                <form method="POST" action="{{ route('sales.destroy', $sale) }}" onsubmit="return confirm('Are you sure you want to delete this sale?')" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded" title="Delete">
                                                        <i class="uil uil-trash-alt font-size-14"></i>
                                                    </button>
                                                </form>

                                                <!-- Edit Button -->
                                                <a href="{{ route('sales.edit', $sale) }}" class="btn btn-sm btn-outline-primary rounded" title="Update">
                                                    <i class="uil uil-pen font-size-14"></i>
                                                </a>

                                                <!-- Button for Showing Details -->
                                                <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-sm btn-outline-info rounded" title="Afficher les détails">
                                                    <i class="uil uil-eye font-size-14"></i>
                                                </a>

                                                <!-- Button for Making a Payment -->
                                                <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-sm btn-outline-success rounded" title="Effectuer un paiement">
                                                    <i class="uil uil-credit-card font-size-14"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">No sales found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
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
                        <input type="checkbox" name="status[]" value="EnAttente" id="status_enattente" class="form-check-input" {{ in_array('EnAttente', Request::input('status', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="status_enattente">EnAttente</label>
                    </div>
                    <div class="form-check me-3">
                        <input type="checkbox" name="status[]" value="PartPayée" id="status_partpayee" class="form-check-input" {{ in_array('PartPayée', Request::input('status', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="status_partpayee">PartPayée</label>
                    </div>
                    <div class="form-check me-3">
                        <input type="checkbox" name="status[]" value="Réglée" id="status_reglee" class="form-check-input" {{ in_array('Réglée', Request::input('status', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="status_reglee">Réglée</label>
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
    </script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('NFacture');
        const searchForm = document.getElementById('searchForm');

        // Listen for input changes
        searchInput.addEventListener('input', function() {
            if (searchInput.value === '') {
                searchForm.submit(); // Automatically submit the form if the input is cleared
            }
        });
    });
    </script>


<script>
  document.addEventListener('DOMContentLoaded', function() {
    const clientInput = document.getElementById('code');
    const clientForm = document.getElementById('clientForm');

    clientInput.addEventListener('input', function() {
        if (clientInput.value === '') {
            clientForm.submit(); // Soumettre automatiquement le formulaire si le champ est vidé
        }
    });
});

</script>


<script>
    // Soumet le formulaire chaque fois qu'une case est cochée ou décochée
    document.querySelectorAll('input[type="checkbox"]').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });
    });
</script>


@endsection
