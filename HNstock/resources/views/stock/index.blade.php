{{-- resources/views/stocks/index.blade.php --}}
@extends('base')

@section('content')

<div class="container my-5">
    <a href="{{ route('stock.out') }}" class="btn btn-secondary mb-3">Stock Out</a>

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="card-title">Stock List</h5>
        </div>
        <div class="card-body">
            <!--<a href="{{ route('stocks.create') }}" class="btn btn-primary mb-3">Add Stock</a>-->
            <table class="table table-bordered">
                <thead>
                    <tr align="center">
                        <th>Categorie</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <!--<th>Actions</th>
                    </tr>
                </thead>
                <tbody align="center">
                    @foreach ($stocks as $stock)
                        <tr>
                            <td>{{ $stock->product->category->name }}</td>
                            <td>{{ $stock->product->name }}</td>
                            <td>{{ $stock->quantity }}</td>
                           <!-- <td>
                                <a href="{{ route('stocks.edit', $stock->id) }}" class="btn btn-sm btn-outline-primary rounded">Edit</a>
                                <form action="{{ route('stocks.destroy', $stock->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded" value="Delete">Delete</button>
                                </form>
                            </td>-->
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
