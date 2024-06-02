@extends('base')
@section('title', 'Products')

@section('content')


<div class="container-fluid">
    <div class="row">
        <!-- Sidebar for filters -->
        <aside class="col-md-2">
            <h1>Filters</h1>
            <form method="get">
                <div class="form-group">
                    <label for="name">Name or Description</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Name" value="{{ Request::input('name') }}">
                </div>
                <h3>Categories</h3>
                @php
                    $categoriesIds = Request::input('categories') ?? [];
                @endphp
                <div class="form-check">
                    @foreach ($categories as $key => $category)
                    <div class="form-check">
                        <input @checked(in_array($category->id, $categoriesIds)) type="checkbox" name="categories[]" value="{{ $category->id }}" class="form-check-input">
                        <label class="form-check-label">{{ $category->name }}</label>
                    </div>
                    @endforeach
                </div>
                <h3>Pricing</h3>
                <div class="form-group">
                    <label for="max">Max</label>
                    <input type="text" min="{{ $priceVOptions->minPriceV }}" max="{{ $priceVOptions->maxPriceV }}" name="max" id="max" class="form-control" placeholder="Max Price" value="{{ Request::input('max') }}">
                    <label for="min">Min</label>
                    <input type="text" min="{{ $priceVOptions->minPriceV }}" max="{{ $priceVOptions->maxPriceV }}" name="min" id="min" class="form-control" placeholder="Min Price" value="{{ Request::input('min') }}">
                </div>
                <div class="form-group my-2">
                    <input type="submit" class="btn btn-primary" value="Filter">
                    <a type="reset" class="btn btn-secondary" href="{{ route('products.index') }}">Reset</a>
                </div>
            </form>
        </aside>
        <!-- Main content for product list -->
        <main class="col-md-10">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Product List</h1>
                <a href="{{ route('products.create') }}" class="btn btn-primary">Create</a>
            </div>
            <table class="table">
                <thead align="center">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Stock</th>
                        <th>Image</th>
                        <th>Price A</th>
                        <th>Price V</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                    <tr align="center">
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{!! $product->description !!}</td>
                        <td>
                            @if ($product->category)
                            <a href="{{ route('categories.show', $product->category_id) }}" class="btn btn-link">
                                <span class="badge" style="background-color:#F97300;">{{ $product->category->name }}</span>
                            </a>
                            @else
                            ----------
                            @endif
                        </td>
                        <td>{{ $product->stock ? $product->stock->quantity : 'N/A' }}</td>
                        <td><img width="50px" height="50px" src="storage/{{ $product->image }}" alt=""></td>
                        <td>{{ $product->priceA }}</td>
                        <td>{{ $product->priceV }}</td>
                        <td>
                            <div class="btn-group gap-2">
                                <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-outline-primary rounded">Update</a>
                                <form method="POST" action="{{ route('products.destroy', $product) }}" onsubmit="return confirm('Are you sure you want to delete this product?')">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" class="btn btn-sm btn-outline-danger rounded" value="Delete">
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" align="center"><h6>No products.</h6></td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </main>
    </div>
</div>

@endsection
