@extends('base')

@section('title', 'Clients')


@section('content')

<div class="row">
    <div class="col-lg-12">

            <div>
                <a href="{{ route('clients.create') }}" title="Nouvelle Facture">
                    <button type="button" class="btn btn-success waves-effect waves-light mb-3">
                        <i class="mdi mdi-plus me-1"></i>
                        Nouveau Client
                    </button>
                </a>

            </div>
            <div class="table-responsive mb-4">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <div class="row">
                        <!--<div class="col-sm-12 col-md-6">
                            <div class="dataTables_length" id="DataTables_Table_0_length">
                                <label>Show
                                    <select name="DataTables_Table_0_length" aria-controls="DataTables_Table_0" class="custom-select custom-select-sm form-control form-control-sm form-select form-select-sm">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select> entries</label>
                                </div>
                            </div>-->
                            <div class="col-sm-12 col-md-6">
                                <form method="get" id="clientForm">
                                    <div class="dataTables_length" id="DataTables_Table_0_length">
                                        <label class="d-flex align-items-center">
                                            <input type="search" name="code" id="code" class="form-control form-control-sm me-2 w-auto"
                                                   placeholder="Code / Nom / Adresse" value="{{ Request::input('code') }}" aria-controls="DataTables_Table_0">
                                        </label>
                                    </div>
                                </form>

                            </div>


                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-centered datatable dt-responsive nowrap table-card-list dataTable no-footer dtr-inline" style="border-collapse: collapse; border-spacing: 0px 12px; width: 100%;" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                                    <thead style="background-color: #dde0e0;">
                                        <tr class="bg-transparent" role="row">
                                            <th style="width: 22px;" class="sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="

                                            : activate to sort column descending">
                                                <!--<div class="form-check text-center">
                                                    <input type="checkbox" class="form-check-input" id="customercheck">
                                                    <label class="form-check-label" for="customercheck"></label>
                                                </div>-->
                                            </th>
                                            <th style="width: 120px;" class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Customer ID: activate to sort column ascending">Code</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 217px;" aria-label="Customer: activate to sort column ascending">Client</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 144px;" aria-label="Customer: activate to sort column ascending">Adresse</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 144px;" aria-label="Email: activate to sort column ascending">Tel</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 86px;" aria-label="Join Date: activate to sort column ascending">Email</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 59px;" aria-label="Status: activate to sort column ascending">Débit</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 59px;" aria-label="Status: activate to sort column ascending">Crédit</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 59px;" aria-label="Status: activate to sort column ascending">Solde</th>
                                            <th style="width: 150px;" class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                        @forelse ($clients as $client)
                         <tr role="row" class="odd">
                            <td class="sorting_1 dtr-control">
                                <div class="form-check text-center">
                                    <input type="checkbox" class="form-check-input" id="customercheck1">
                                    <label class="form-check-label" for="customercheck1"></label>
                                </div>
                            </td>

                            <td><a href="javascript: void(0);" class="text-dark fw-bold">{{ $client->code }}</a> </td>
                            <td style="white-space: nowrap;">
                                @if ($client->photo)
                                <img width="40px" height="40px" src="{{ asset('storage/' . $client->photo) }}" alt="Client Photo" class="rounded-circle">
                            @else
                                <img width="40px" height="40px" src="{{ asset('images/default.png') }}" alt="Default Photo" class="rounded-circle">
                            @endif                                <span>{{ $client->name }}</span>
                            </td>
                            <td>{{ $client->adresse }}</td>

                            <td>    {{ $client->tel }}      </td>
                            <td>   {{ $client->email }}     </td>
                            <td>   {{ number_format($client->total_debit, 2) }}   </td>
                            <td>   {{ number_format($client->total_credit, 2) }}     </td>
                             <td   style="color: #000000; font-family: Arial, sans-serif; font-weight: bold; font-size: 13px;">
                                            {{ number_format($client->solde, 2) }}       </td>
                            <td style="white-space: nowrap;">
                                   <!-- Delete Button -->
                                   <form method="POST" action="{{ route('clients.destroy', $client) }}" onsubmit="return confirm('Are you sure you want to delete this sale?')" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded" title="Delete">
                                        <i class="uil uil-trash-alt font-size-14"></i>
                                    </button>
                                </form>

                                <!-- Edit Button -->
                                <a href="{{ route('clients.edit', $client) }}" class="btn btn-sm btn-outline-primary rounded" title="Update">
                                    <i class="uil uil-pen font-size-14"></i>
                                </a>

                            </td>
                            @empty
                            <tr>
                                <td colspan="10" align="center"><h4>No Clients</h4></td>
                            </tr>
                        @endforelse
                        </tbody>
                </table>
            </div>
        </div>
                <div class="row">
                    <div class="col-sm-12 col-md-5">
                        <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">
                            Showing 1 to 10 of 12 entries
                        </div>
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





<script>
    $(document).ready(function() {
        $('#toggle-filter').on('click', function() {
            var filters = $('#filters');
            filters.slideToggle(); // Utilisation de slideToggle pour un effet de glissement
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
@endsection
