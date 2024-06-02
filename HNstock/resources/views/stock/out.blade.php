{{-- resources/views/stocks/out.blade.php --}}
@extends('base')

@section('title', 'Stock Out')

@section('content')
<div class="container my-5">
    <h1>Stock Out</h1>
    <a href="{{ route('stocks.index') }}" class="btn btn-secondary">Stock Liste</a>
    <br>
    <br>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Date</th>
                <th>Product</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($stockOuts as $stockOut)
                <tr>
                    <td>{{ $stockOut['date'] }}</td>
                    <td>{{ $stockOut['product']->name }}</td>
                    <td>{{ $stockOut['quantity'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
