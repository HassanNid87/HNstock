@extends('base')
@section('title', $isUpdate ? 'Update Product' : 'Creer un Produit')

@php
    $route = $isUpdate ? route('products.update', $product) : route('products.store');
@endphp

@section('content')
    <div class="container my-5">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title">@yield('title')</h5>
            </div>
            <div class="card-body">
                <form action="{{ $route }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if ($isUpdate)
                        @method('PUT')
                    @endif

                    <div class="form-group mb-3">
                        <label for="name" class="form-label">Nom</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $product->name) }}">
                    </div>

                    <div class="form-group mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control">{{ old('description', $product->description) }}</textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label for="category_id" class="form-label">Categorie</label>
                        <select name="category_id" id="category_id" class="form-select">
                            <option value="">Categorie</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" name="image" id="image" class="form-control" onchange="previewImage(event)">
                        <div id="image-container" class="mt-2" style="display: {{ $product->image ? 'block' : 'none' }};">
                            <img id="image-preview" width="100px" src="/storage/{{ $product->image }}" alt="Product Image">
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="priceA" class="form-label">Price A</label>
                        <input type="number" name="priceA" step="0.01" id="priceA" class="form-control" value="{{ old('priceA', $product->priceA) }}">
                    </div>

                    <div class="form-group mb-3">
                        <label for="priceV" class="form-label">Price V</label>
                        <input type="number" name="priceV" id="priceV" step="0.01" class="form-control" value="{{ old('priceV', $product->priceV) }}">
                    </div>

                    <div class="form-group mb-3">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-save"></i> {{ $isUpdate ? 'Update' : 'Create' }}
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
<script>
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('image-preview');
        const container = document.getElementById('image-container');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                container.style.display = 'block'; // Afficher la zone de prévisualisation
            }

            reader.readAsDataURL(input.files[0]);
        } else {
            container.style.display = 'none'; // Masquer la zone si aucun fichier sélectionné
        }
    }
</script>
