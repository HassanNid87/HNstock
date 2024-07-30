@extends('base')
@section('title', $isUpdate ? 'Update Product' : 'Create Product')

@php
    $route = $isUpdate ? route('products.update', $product) : route('products.store');
@endphp

@section('content')
<h1>@yield('title')</h1>
<form action="{{ $route }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if ($isUpdate)
    @method('PUT')
    @endif

    <div class="form-group">
        <label for="name" class="form-label">Name</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $product->name) }}">
    </div>
    <div class="form-group">
        <label for="description" class="form-label">Description</label>
        <textarea name="description" id="description" class="form-control">{{ old('description', $product->description) }}</textarea>
    </div>
    <div class="form-group">
        <label for="category_id" class="form-label">Category</label>
        <select name="category_id" id="category_id" class="form-select">
            <option value="">Please choose your category</option>
            @foreach ($categories as $category)
            <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="image" class="form-label">Image</label>
        <input type="file" name="image" id="image" class="form-control">
        @if ($product->image)
        <img width="100px" src="/storage/{{ $product->image }}" alt="">
        @endif
    </div>
    <div class="form-group">
        <label for="priceA" class="form-label">Price A</label>
        <input type="number" name="priceA" step="0.01" id="priceA" class="form-control" value="{{ old('priceA', $product->priceA) }}">
    </div>
    <div class="form-group">
        <label for="priceV" class="form-label">Price V</label>
        <input type="number" name="priceV" id="priceV" step="0.01" class="form-control" value="{{ old('priceV', $product->priceV) }}">
    </div>
    <div class="form-group my-3">
        <button type="submit" class="btn btn-primary w-100">{{ $isUpdate ? 'Update' : 'Create' }}</button>
    </div>
</form>
@endsection
