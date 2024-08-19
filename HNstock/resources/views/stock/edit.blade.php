@extends('base')

@section('title', 'Edit Stock')

@section('content')
<h1>Edit Stock</h1>
<a href="{{ route('stocks.index') }}" class="btn btn-secondary mb-3">
    <i class="fas fa-arrow-left"></i> Back to Stock List
</a>
<form action="{{ route('stocks.update', $stock) }}" method="POST">
    @csrf
    @method('PUT')

    <!-- Category Selector -->
    <div class="form-group">
        <label for="category_id">Category</label>
        <select name="category_id" id="category_id" class="form-control">
            <option value="">Select Category</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ $category->id == $stock->product->category_id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Product Selector -->
    <div class="form-group">
        <label for="product_id">Product</label>
        <select name="product_id" id="product_id" class="form-control">
            <option value="">Select Product</option>
            @foreach ($products as $product)
                <option value="{{ $product->id }}"
                        data-category="{{ $product->category_id }}"
                        data-price="{{ $product->price }}"
                        {{ $product->id == $stock->product_id ? 'selected' : '' }}>
                    {{ $product->name }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Quantity Input -->
    <div class="form-group">
        <label for="quantity">Quantity</label>
        <input type="number" name="quantity" id="quantity" class="form-control" value="{{ $stock->quantity }}" required>
    </div>

    <br>
    <button type="submit" class="btn btn-primary">Update Stock</button>
</form>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const categorySelect = document.querySelector('#category_id');
        const productSelect = document.querySelector('#product_id');

        // Handle category change
        categorySelect.addEventListener('change', function() {
            const selectedCategory = this.value;
            const products = productSelect.querySelectorAll('option');

            products.forEach(product => {
                product.style.display = product.getAttribute('data-category') === selectedCategory || selectedCategory === '' ? 'block' : 'none';
            });

            if (selectedCategory === '') {
                productSelect.value = ''; // Reset product selection if no category is selected
            }
        });

        // Set the initial category to the current product's category
        const initialCategory = productSelect.querySelector('option:checked').getAttribute('data-category');
        if (initialCategory) {
            categorySelect.value = initialCategory;
            categorySelect.dispatchEvent(new Event('change')); // Trigger the change event to filter products
        }
    });
</script>
@endsection
