@extends('base')

@section('title', 'Détails du Paiement')

@section('content')
<div class="container">
    <h1>Détails du Paiement</h1>
    <div class="mb-3">
        <label for="Npayment" class="form-label">Numéro de Paiement</label>
        <p>{{ $payment->Npayment }}</p>
    </div>

    <div class="mb-3">
        <label for="montant" class="form-label">Montant</label>
        <p>{{ $payment->montant }}</p>
    </div>

    <div class="mb-3">
        <label for="date_payment" class="form-label">Date de Paiement</label>
        <p>{{ $payment->date_payment->format('d-m-Y') }}</p>
    </div>

    <div class="mb-3">
        <label for="mode_payment" class="form-label">Mode de Paiement</label>
        <p>{{ $payment->mode_payment }}</p>
    </div>

    <div class="mb-3">
        <label for="client_id" class="form-label">Client</label>
        <p>{{ $payment->client ? $payment->client->name : 'N/A' }}</p>
    </div>

    <a href="{{ route('payments.edit', $payment->id) }}" class="btn btn-warning">Modifier</a>
    <a href="{{ route('payments.index') }}" class="btn btn-secondary">Retour</a>
</div>
@endsection
