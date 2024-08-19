@extends('base')
@section('title', $isUpdate ? 'Update Product' : 'Create Product')

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
                      <!--  <label for="category_id" class="form-label">Categorie</label>-->
                        <select name="category_id" id="category_id" class="form-select">
                            <option value="">Categorie</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <!--<label for="codebare" class="form-label">Code Barre</label>-->
                        <input type="text" name="codebare" id="codebare" placeholder="Code Barre" class="form-control" value="{{ old('codebare', $product->codebare) }}">
                    </div>

                    <div class="form-group mb-3">
                        <!--<label for="name" class="form-label">Nom</label>-->
                        <input type="text" name="name" id="name" placeholder="Nom" class="form-control" value="{{ old('name', $product->name) }}">
                    </div>

                    <div class="form-group mb-3">
                        <!--<label for="description" class="form-label">Description</label>-->
                        <textarea name="description" id="description" placeholder="Description" class="form-control">{{ old('description', $product->description) }}</textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" name="image" id="image" class="form-control" onchange="previewImage(event)">
                        <div id="image-container" class="mt-2" style="display: {{ $product->image ? 'block' : 'none' }};">
                            <img id="image-preview" width="100px"  src="/storage/{{ $product->image }}" alt="Product Image">
                        </div>
                    </div>

                    <hr>

                    <div class="form-group mb-3">
                        <label for="priceA" class="form-label">Prix Achat</label>
                        <input type="number" name="priceA" placeholder="Prix d'Achat" step="0.01" id="priceA" class="form-control" value="{{ old('priceA', $product->priceA) }}">
                    </div>

                    <div class="form-group mb-3">
                       <label for="priceV" class="form-label">Prix Vente</label>
                        <input type="number" name="priceV" id="priceV" placeholder="Prix de vente" step="0.01" class="form-control" value="{{ old('priceV', $product->priceV) }}">
                    </div>

                    <div class="form-group mb-3">
                        <!--<label for="unite" class="form-label">Unité</label>-->
                        <input type="text" name="unite" id="unite" placeholder="Unité" class="form-control" value="{{ old('unite', $product->unite) }}">
                    </div>
                    <hr>
                    <div class="form-group mb-3">
                        <!--<label for="etagere" class="form-label">Étagère</label>-->
                        <input type="text" name="etagere" id="etagere" placeholder="Étagère" class="form-control" value="{{ old('etagere', $product->etagere) }}">
                    </div>

                    <div class="form-group mb-3">
                        <label for="stockmax" class="form-label">Stock-Max</label>
                        <input type="number" name="stockmax" id="stockmax" class="form-control" value="{{ old('priceV', $product->stockmax) }}">
                    </div>
                    <div class="form-group mb-3">
                        <label for="stockmin" class="form-label">Stock-Min</label>
                        <input type="number" name="stockmin" id="stockmin" class="form-control" value="{{ old('priceV', $product->stockmin) }}">
                    </div>


                    <!--<div class="form-group mb-3">
                        <label for="priceVgros" class="form-label">Prix V-Gros</label>
                        <input type="number" name="priceVgros" id="priceVgros" step="0.01" class="form-control" value="{{ old('priceV', $product->priceVgros) }}">
                    </div>-->


                    <hr>


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
