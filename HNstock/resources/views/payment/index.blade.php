@extends('base')
@section('title', 'Liste des Paiements')
@section('content')

<div class="row">
    <div class="col-md-4">
        <div>
            <a href="{{ route('payments.create') }}" title="Nouveau Régelement">
                <button type="button" class="btn btn-success waves-effect waves-light mb-3">
                    <i class="mdi mdi-plus me-1"></i>
                    Nouveau Réglement
                </button>
            </a>
        </div>
    </div>
    <div class="col-md-8">
        <div class="float-end">
            <div class="mb-3">
                <form method="get" action="{{ url()->current() }}">
                    <div class="input-daterange input-group" id="datepicker6" data-date-format="yyyy-mm-dd" data-date-autoclose="true">
                        <input type="text" class="form-control text-start" placeholder="From" name="start_date" value="{{ request('start_date') }}">
                        <input type="text" class="form-control text-start" placeholder="To" name="end_date" value="{{ request('end_date') }}">
                        <button type="submit" class="btn btn-primary">
                            <i class="mdi mdi-filter-variant"></i>
                        </button>
                        <a class="btn btn-secondary" href="{{ route('payments.index') }}" title="Reset">
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
                                    <input type="search" name="code" id="code" class="form-control form-control-sm" placeholder="Code Client" value="{{ request('code') }}" aria-controls="DataTables_Table_0">
                                </label>
                            </div>
                        </form>

                    </div>
                    <div class="col-sm-12 col-md-6">
                        <form method="get" id="searchForm">
                            <div id="DataTables_Table_0_filter" class="dataTables_filter">
                                <label>
                                    <input type="search" name="Npayment" id="Npayment" class="form-control form-control-sm" placeholder="N° Réglement" value="{{ Request::input('Npayment') }}" aria-controls="DataTables_Table_0">
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
                            Showing {{ $payments->firstItem() }} to {{ $payments->lastItem() }} of {{ $payments->total() }} entries
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-7">
                        <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
                            {{ $payments->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>

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

@endsection
