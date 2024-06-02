@extends('base')
@section('title' , 'Products')

@section('content')
<div class="container-fluid">
    <div class="row">
        <aside class="col-md-3">
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
                    <a type="reset" class="btn btn-secondary" href="{{ route('store.index') }}">Reset</a>
                </div>
            </form>
        </aside>
        <main class="col-md-9">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Last Products</h1>
            </div>
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach ($products as $product)
                <div class="col">
                    <div class="card h-100">
                        <img class="card-img-top" src="storage/{{ $product->image }}" alt="" style="height: 100%; object-fit: cover;">
                        <div class="card-body">
                            <h6 class="card-title">{{ $product->name }}</h6>
                            <p class="card-text" style="font-size: 0.875rem;">{!! $product->description !!}</p>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <span style="font-size: 0.875rem;">Quantity: <span class="badge bg-success">{{ $product->quantity }}</span></span>
                                <span style="font-size: 0.875rem;">Price: <span class="badge bg-primary">{{ $product->priceV }} MAD</span></span>
                            </div>
                            <hr>
                            <div class="my-2">
                                <span style="font-size: 0.875rem;">Category: <span class="badge bg-primary">{{ $product->category?->name }}</span></span>
                            </div>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">{{ $product->created_at }}</small>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </main>
    </div>
</div>
@endsection
