@extends('base')
@section('title', 'Sales')
@section('content')


<div class="row">
    <div class="col-md-4">
        <div>
            <a href="{{ route('sales.create') }}" title="Nouvelle Facture">
                <button type="button" class="btn btn-success waves-effect waves-light mb-3">
                    <i class="mdi mdi-plus me-1">
                        </i>
                        Nouvelle Facture
                </button>
            </a>
        </div>
    </div>
    <div class="col-md-8">
        <div class="float-end">
            <div class="mb-3">
                <form method="get" action="{{ url()->current() }}">
                    <div class="input-daterange input-group" id="datepicker6" data-date-format="yyyy-mm-dd" data-date-autoclose="true">
                        <input type="text" class="form-control text-start" placeholder="From" name="start_date" value="{{ request('start_date') }}" autocomplete="off" autocorrect="off">
                        <input type="text" class="form-control text-start" placeholder="To" name="end_date" value="{{ request('end_date') }}" autocomplete="off" autocorrect="off">
                        <button type="submit" class="btn btn-primary">
                            <i class="mdi mdi-filter-variant"></i>
                        </button>
                        <a class="btn btn-secondary" href="{{ route('sales.index') }}" title="Reset">
                            <i class="fas fa-redo"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
<div class="row">
    <div class="col-lg-12">
        <div class="table-responsive mb-4">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <form method="get" id="clientForm">
                            <div class="dataTables_length" id="DataTables_Table_0_length">
                                <label>
                                    <input type="search" name="code" id="code" class="form-control form-control-sm" placeholder="Client Code" value="{{ Request::input('code') }}" aria-controls="DataTables_Table_0">
                                </label>
                            </div>
                        </form>

                    </div>
                    <div class="col-sm-12 col-md-6">
                        <form method="get" id="searchForm">
                            <div id="DataTables_Table_0_filter" class="dataTables_filter">
                                <label>
                                    <input type="search" name="NFacture" id="NFacture" class="form-control form-control-sm" placeholder="N° Facture" value="{{ Request::input('NFacture') }}" aria-controls="DataTables_Table_0">
                                </label>
                            </div>
                        </form>
                    </div>
                </div>
                <!--<div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="dataTables_length" id="DataTables_Table_0_length">
                            <label>Show entries
                                <select name="DataTables_Table_0_length" aria-controls="DataTables_Table_0" class="custom-select custom-select-sm form-control form-control-sm form-select form-select-sm">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select> </label>
                        </div>
                     </div>
               </div>-->
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
                    <div class="row">
                        <div class="col-sm-12 col-md-5">
                            <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">Showing 1 to 10 of 12 entries
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-7">
                                <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
                                    <ul class="pagination">
                                        <li class="paginate_button page-item previous disabled" id="DataTables_Table_0_previous">
                                            <a href="#" aria-controls="DataTables_Table_0" data-dt-idx="0" tabindex="0" class="page-link">Previous</a>
                                        </li>
                                        <li class="paginate_button page-item active">
                                            <a href="#" aria-controls="DataTables_Table_0" data-dt-idx="1" tabindex="0" class="page-link">1</a>
                                        </li>
                                        <li class="paginate_button page-item ">
                                            <a href="#" aria-controls="DataTables_Table_0" data-dt-idx="2" tabindex="0" class="page-link">2</a>
                                        </li>
                                        <li class="paginate_button page-item next" id="DataTables_Table_0_next">
                                            <a href="#" aria-controls="DataTables_Table_0" data-dt-idx="3" tabindex="0" class="page-link">Next
                                                </a>
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

    <div class="col-md-2">
        <div class="float-end">
            <div class="mb-3">
                <form method="get" action="{{ url()->current() }}" id="filterForm">
                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" name="status[]" value="EnAttente" id="status_enattente" class="form-check-input" {{ in_array('EnAttente', Request::input('status', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="status_enattente">EnAttente</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="status[]" value="PartPayée" id="status_partpayee" class="form-check-input" {{ in_array('PartPayée', Request::input('status', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="status_partpayee">PartPayée</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="status[]" value="Réglée" id="status_reglee" class="form-check-input" {{ in_array('Réglée', Request::input('status', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="status_reglee">Réglée</label>
                        </div>
                    </div>
                </form>
            </div>
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
