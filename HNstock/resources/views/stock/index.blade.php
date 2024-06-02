{{-- resources/views/stocks/index.blade.php --}}
@extends('base')

@section('content')

    <h1>Stock List</h1>
    <a href="{{ route('stocks.create') }}" class="btn btn-primary">Add Stock</a>
    <a href="{{ route('stock.out') }}" class="btn btn-secondary"> Stock Out</a>
    <table class="table">
        <thead>
            <tr align="center">
                <th>Product</th>
                <th>Quantity</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody align="center">
            @foreach ($stocks as $stock)
                <tr>
                    <td>{{ $stock->product->name }}</td>
                    <td>{{ $stock->quantity }}</td>
                    <td>
                        <a href="{{ route('stocks.edit', $stock->id) }}" class="btn btn-sm btn-outline-primary rounded">Edit</a>
                        <form action="{{ route('stocks.destroy', $stock->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger rounded" value="Delete">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
