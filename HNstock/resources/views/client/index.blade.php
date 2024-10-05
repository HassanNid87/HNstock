@extends('base')

@section('title', 'Clients')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0">Liste Clients</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Clients</a></li>
                    <li class="breadcrumb-item active">Liste Clients</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row mb-3">
    <!-- Colonne du Bouton Nouveau Client -->
    <div class="col-sm-12 col-md-6 d-flex align-items-center">
        <a href="{{ route('clients.create') }}" title="Nouveau Client">
            <button type="button" class="btn btn-success waves-effect waves-light">
                <i class="mdi mdi-plus me-1"></i>
            </button>
        </a>
    </div>

    <!-- Colonne du Filtre de Recherche -->
    <div class="col-sm-12 col-md-6 d-flex align-items-center">
        <form method="get" id="clientForm" class="d-flex w-100">
            <input type="search" name="code" id="code" class="form-control form-control-sm me-2 w-100"
                   placeholder="Code / Nom / Adresse" value="{{ Request::input('code') }}" aria-controls="DataTables_Table_0">
        </form>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="table-responsive mb-4">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                <div class="row">
                    <!-- Table -->
                    <div class="col-sm-12">
                        <table class="table table-centered datatable dt-responsive nowrap table-card-list dataTable no-footer dtr-inline"
                               style="border-collapse: collapse; border-spacing: 0px 12px; width: 100%;" id="DataTables_Table_0"
                               role="grid" aria-describedby="DataTables_Table_0_info">
                            <thead style="background-color: #dde0e0;">
                                <tr class="bg-transparent" role="row">
                                    <!-- Table headers -->
                                    <th style="width: 22px;"></th>
                                    <th style="width: 120px;">Code</th>
                                    <th style="width: 217px;">Client</th>
                                    <th style="width: 144px;">Type</th>
                                    <th style="width: 144px;">Adresse</th>
                                    <th style="width: 59px;">Tel</th>
                                    <th style="width: 144px;">Whatsapp</th>
                                    <th style="width: 59px;">Débit</th>
                                    <th style="width: 59px;">Crédit</th>
                                    <th style="width: 59px;">Solde</th>
                                    <th style="width: 59px;">Email</th>
                                    <th style="width: 59px;">SiteWeb</th>
                                    <th style="width: 150px;">Actions</th>
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
                                        <td><a href="javascript: void(0);" class="text-dark fw-bold">{{ $client->code }}</a></td>
                                        <td style="white-space: nowrap;">
                                            @if ($client->photo)
                                                <img width="40px" height="40px" src="{{ asset('storage/' . $client->photo) }}" alt="Client Photo" class="rounded-circle">
                                            @else
                                                <img width="40px" height="40px" src="{{ asset('images/default.png') }}" alt="Default Photo" class="rounded-circle">
                                            @endif
                                            <span>{{ $client->name }}</span>
                                        </td>
                                        <td>{{ $client->Type }}</td>
                                        <td>{{ $client->adresse }}</td>
                                        <td>{{ $client->tel }}</td>
                                        <td>{{ $client->whatsapp }}</td>
                                        <td>{{ number_format($client->total_debit, 2) }}</td>
                                        <td>{{ number_format($client->total_credit, 2) }}</td>
                                        <td style="color: #000000; font-family: Arial, sans-serif; font-weight: bold; font-size: 13px;">
                                            {{ number_format($client->solde, 2) }}
                                        </td>
                                        <td>{{ $client->email }}</td>
                                        <td>{{ $client->siteweb }}</td>
                                        <td style="white-space: nowrap;">
                                            <!-- Delete Button -->
                                            <form method="POST" action="{{ route('clients.destroy', $client) }}" onsubmit="return confirm('Are you sure you want to delete this client?')" style="display:inline;">
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
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="13" align="center"><h4>No Clients</h4></td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>


            </div>
        </div>
    </div>

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
