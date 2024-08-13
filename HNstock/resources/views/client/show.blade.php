@extends('base')
@section('title', 'Clients')

@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Clients : {{ $client->name }}</h1>
        <a href="{{ route('clients.index') }}" class="btn btn-primary">Go Back</a>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Téléphone</th>
                <th>Email</th>
                <th>Adresse</th>
                <th>Solde</th>
                <th>Photo</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $client->id }}</td>
                <td>{{ $client->name }}</td>
                <td>{{ $client->tel }}</td>
                <td>{{ $client->email }}</td>
                <td>{{ $client->adresse }}</td>
                <td>{{ number_format($client->solde, 2) }}</td>
                <td>
                    @if ($client->photo)
                        <img width="100" src="{{ asset('storage/' . $client->photo) }}" alt="Client Photo" class="rounded-circle">
                    @else
                        <img width="100" src="{{ asset('images/default.png') }}" alt="Default Photo" class="rounded-circle">
                    @endif
                </td>
            </tr>
        </tbody>
    </table>

    <h3>Ventes</h3>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Numéro de Facture</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($sales as $sale)
                <tr>
                    <td>{{ $sale->id }}</td>
                    <td>{{ $sale->NFact }}</td>
                    <td>
                        <div class="btn-group gap-2">
                            <a href="{{ route('sales.edit', $sale) }}" class="btn btn-primary">Update</a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" align="center"><h6>No Sale for this client</h6></td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
