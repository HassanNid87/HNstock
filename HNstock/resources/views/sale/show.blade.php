<!-- resources/views/sale/show.blade.php -->

@extends('base')

@section('title', 'Sale Details')

@section('content')
    <h1>Sale Details</h1>

    <div class="sale-info">
        <h2>Numero Facture: {{ $sale->NFact }}</h2>
        <p>Date: {{ $sale->DateFact }}</p>
        <p>Client: {{ $sale->client->name }}</p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sale->details as $detail)
                <tr>
                    <td>{{ $detail->product->name }}</td>
                    <td>{{ $detail->quantity }}</td>
                    <td>{{ $detail->unit_price }}</td>
                    <td>{{ $detail->total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <p>Montant HT: {{ $sale->mht }}</p>
        <p>TVA: {{ $sale->mtva }}</p>
        <p>Remise: {{ $sale->mremise }}</p>
        <p>Montant TTC: {{ $sale->mttc }}</p>
    </div>

    <a href="{{ route('sales.index') }}" class="btn btn-primary">Sales Liste</a>
    <a href="{{ route('sales.invoice', $sale->id) }}" class="btn btn-primary">Imprimer</a>

@endsection
