@extends('base')

@section('title', 'Clients')

<style>
.table {
    margin: 20px 0;
    width: 100%;
    text-align: center;
    border-collapse: collapse;
}

.table thead {
    background-color: #343a40;
    color: white;
}

.table tbody tr:hover {
    background-color: #f5f5f5;
}

.table td, .table th {
    padding: 10px;
    vertical-align: middle;
    border: 1px solid #ddd;
}

.table-striped tbody tr:nth-of-type(odd) {
    background-color: #f2f2f2;
}

.table-hover tbody tr:hover {
    background-color: #e9ecef;
}

.table th {
    font-weight: bold;
}

.table td {
    font-size: 14px;
}

.btn-group .btn {
    margin-right: 5px;
}

img.rounded-circle {
    border-radius: 50%;
    object-fit: cover;
}

.card-body {
    overflow-x: auto; /* Ajoute une barre de défilement horizontal si nécessaire */
}
</style>

@section('content')
<div class="container-fluid">
    <button type="button" id="toggle-filter" class="">
        <i class="fa fa-fw fa-bars fas fa-filter"></i>
    </button>
    <div class="row">
        <aside id="filters" class="col-md-2">
            <form method="get" action="{{ route('clients.index') }}">
                <br>
                <div class="form-group">
                    <input type="text" name="name" id="name" class="form-control" placeholder="Code / Nom / Adresse" value="{{ Request::input('name') }}">
                </div>
                <hr>
                <div class="form-group">
                    <select name="client" id="client" class="form-control">
                        <option value="">Select Client</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}" {{ Request::input('client') == $client->id ? 'selected' : '' }}>
                                {{ $client->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <hr>
                <div class="form-group">
                    <input type="number" name="maxsolde" id="maxsolde" class="form-control" placeholder="Max Solde" value="{{ Request::input('maxsolde') }}">
                </div>
                <div class="form-group">
                    <br>
                    <input type="number" name="minsolde" id="minsolde" class="form-control" placeholder="Min Solde" value="{{ Request::input('minsolde') }}">
                </div>
                <div class="form-group my-2">
                    <button type="submit" class="btn btn-primary" title="Filtrer">
                        <i class="fas fa-filter"></i>
                    </button>
                    <a class="btn btn-secondary" href="{{ route('clients.index') }}" title="Reset">
                        <i class="fas fa-redo"></i>
                    </a>
                </div>
            </form>
        </aside>
        <main class="col-md-10">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Liste Clients</h5>
                    <a href="{{ route('clients.create') }}" class="btn btn-light">
                        <i class="fas fa-plus"></i>
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead class="table-dark" align="center">
                                <tr align="center">
                                    <th>Photo</th>
                                    <th>Code</th>
                                    <th>Nom</th>
                                    <th>Adresse</th>
                                    <th>Tel</th>
                                    <th>Email</th>
                                    <th>Débit</th>
                                    <th>Crédit</th>
                                    <th>Solde</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($clients as $client)
                                    <tr align="center">
                                        <td>
                                            @if ($client->photo)
                                                <img width="40px" height="40px" src="{{ asset('storage/' . $client->photo) }}" alt="Client Photo" class="rounded-circle">
                                            @else
                                                <img width="40px" height="40px" src="{{ asset('images/default.png') }}" alt="Default Photo" class="rounded-circle">
                                            @endif
                                        </td>
                                        <td>{{ $client->code }}</td>
                                        <td>{{ $client->name }}</td>
                                        <td>{{ $client->adresse }}</td>
                                        <td>{{ $client->tel }}</td>
                                        <td>{{ $client->email }}</td>
                                        <td>{{ number_format($client->total_debit, 2) }}</td>
                                        <td>{{ number_format($client->total_credit, 2) }}</td>
                                        <td style="color: #000000; font-family: Arial, sans-serif; font-weight: bold; font-size: 13px;">
                                            {{ number_format($client->solde, 2) }}
                                        </td>
                                        <td>
                                            <div class="btn-group gap-2">
                                                <a href="{{ route('clients.edit', $client) }}" >
                                                   <span class="btn btn-sm btn-outline-primary" title="Edit"> <i class="fas fa-edit"></i></span>
                                                </a>
                                                <form action="{{ route('clients.destroy', $client) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this client?')" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" align="center"><h4>No Clients</h4></td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination Links -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $clients->links() }}
                    </div>
                </div>
            </div>
        </main>
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
@endsection
