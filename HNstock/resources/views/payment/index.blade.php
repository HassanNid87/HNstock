@extends('base')

@section('title', 'Liste des Paiements')

@section('content')
<div class="container">
    <h1>Liste des Paiements</h1>
    <a href="{{ route('payments.create') }}" class="btn btn-primary">Ajouter un Paiement</a>
    <table class="table mt-3">
        <thead>
            <tr>
                <!-- <th>#</th> -->
                <th>Numéro de Paiement</th>
                <th>Montant</th>
                <th>Date</th>
                <th>Mode de Paiement</th>
                <th>Client</th> <!-- Nouvelle colonne pour afficher le client -->
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($payments as $payment)
            <tr>
                <!-- <td>{{ $payment->id }}</td> -->
                <td>{{ $payment->Npayment ?? 'N/A' }}</td>
                <td>{{ $payment->montant ?? 'N/A' }}</td>
                <td>{{ $payment->date_payment ?? 'N/A' }}</td>
                <td>{{ $payment->mode_payment ?? 'N/A' }}</td>
                <td>{{ $payment->client ? $payment->client->name : 'N/A' }}</td> <!-- Vérifie si client existe -->
                <td>
                    <a href="{{ route('payments.edit', $payment->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                    <a href="{{ route('payments.show', $payment->id) }}" class="btn btn-info btn-sm">Détails</a>
                    <form action="{{ route('payments.destroy', $payment->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $payments->links() }}
</div>
@endsection
