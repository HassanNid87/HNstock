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

</style>

@section('content')
<div class="container my-5">
    <div class="card">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Liste Clients</h5>
            <a href="{{ route('clients.create') }}" class="btn btn-light">
                <i class="fas fa-plus"></i>
            </a>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped table-hover">
                <thead class="table-dark">
                    <tr align="center">
                        <th>Nom</th>
                        <th>Tel</th>
                        <th>Email</th>
                        <th>Adresse</th>
                        <th>Solde</th>
                        <th>Photo</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($clients as $client)
                        <tr align="center">
                            <td>{{ $client->name }}</td>
                            <td>{{ $client->tel }}</td>
                            <td>{{ $client->email }}</td>
                            <td>{{ $client->adresse }}</td>
                            <td>{{ number_format($client->solde, 2) }}</td>
                            <td>
                                @if ($client->photo)
                                    <img width="40px" height="40px" src="{{ asset('storage/' . $client->photo) }}" alt="Client Photo" class="rounded-circle">
                                @else
                                    <img width="40px" height="40px" src="{{ asset('images/default.png') }}" alt="Default Photo" class="rounded-circle">
                                @endif
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
                            <td colspan="7" align="center"><h4>No Clients</h4></td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination Links -->
            <div class="d-flex justify-content-center mt-4">
                {{ $clients->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
