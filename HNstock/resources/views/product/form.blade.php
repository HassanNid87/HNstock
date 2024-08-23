@extends('base')
@section('title', $isUpdate ? 'Update Product' : 'Create Product')

@php
    $route = $isUpdate ? route('products.update', $product) : route('products.store');
@endphp

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div id="addproduct-accordion" class="custom-accordion">
            <div class="card">
                <a href="#addproduct-billinginfo-collapse" class="text-dark" data-bs-toggle="collapse" aria-expanded="true" aria-controls="addproduct-billinginfo-collapse">
                    <div class="p-4">

                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar-xs">
                                    <div class="avatar-title rounded-circle bg-soft-primary text-primary">
                                        01
                                    </div>
                                </div>
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <h5 class="font-size-16 mb-1">Informations de Base</h5>
                                <p class="text-muted text-truncate mb-0">Remplissez toutes les informations ci-dessous</p>
                            </div>
                            <div class="flex-shrink-0">
                                <i class="mdi mdi-chevron-up accor-down-icon font-size-24"></i>
                            </div>

                        </div>

                    </div>
                </a>

                <div id="addproduct-billinginfo-collapse" class="collapse show" data-bs-parent="#addproduct-accordion">
                    <div class="p-4 border-top">
                        <form action="{{ $route }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @if ($isUpdate)
                                @method('PUT')
                            @endif
                            <div class="mb-3">
                                <label class="form-label" for="productname">Nom Produit</label>
                                <input type="text" name="name" id="name" placeholder="Nom" class="form-control" value="{{ old('name', $product->name) }}">
                            </div>
                            <div class="row">
                                <div class="col-lg-4">

                                    <div class="mb-3">
                                        <label class="form-label">Categorie</label>
                                        <select name="category_id" id="category_id" class="form-select">
                                            <option value="">Categorie</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="priceA">Prix d'achat</label>
                                        <input type="number" name="priceA" placeholder="Prix d'Achat" step="0.01" id="priceA" class="form-control" value="{{ old('priceA', $product->priceA) }}">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="priceV">Prix de vente</label>
                                        <input type="number" name="priceV" id="priceV" placeholder="Prix de vente" step="0.01" class="form-control" value="{{ old('priceV', $product->priceV) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-0">
                                <label class="form-label" for="productdesc">Description</label>
                                <textarea name="description" id="description" placeholder="Description" class="form-control">{{ old('description', $product->description) }}</textarea>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">

                                    <div class="mb-3">
                                        <label class="form-label" for="Code Barre">Code Barre</label>
                                        <input type="text" name="codebare" id="codebare" placeholder="Code Barre" class="form-control" value="{{ old('codebare', $product->codebare) }}">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="unite" class="form-label">Unité</label>
                                        <input type="text" name="unite" id="unite" placeholder="Unité" class="form-control" value="{{ old('unite', $product->unite) }}">
                                      </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="etagere" class="form-label">Étagère</label>
                                        <input type="text" name="etagere" id="etagere" placeholder="Étagère" class="form-control" value="{{ old('etagere', $product->etagere) }}">
                                       </div>
                                </div>

                            </div>

                     <!--   </form>-->
                    </div>
                </div>
            </div>

            <div class="card">
                <a href="#addproduct-img-collapse" class="text-dark collapsed" data-bs-toggle="collapse" aria-haspopup="true" aria-expanded="false" aria-controls="addproduct-img-collapse">
                    <div class="p-4">

                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar-xs">
                                    <div class="avatar-title rounded-circle bg-soft-primary text-primary">
                                        02
                                    </div>
                                </div>
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <h5 class="font-size-16 mb-1">Image du produit</h5>
                                <p class="text-muted text-truncate mb-0">cliquer et télécharger l'image de produit</p>
                            </div>
                            <div class="flex-shrink-0">
                                <i class="mdi mdi-chevron-up accor-down-icon font-size-24"></i>
                            </div>
                        </div>
                    </div>
                </a>
                <div id="addproduct-img-collapse" class="collapse" data-bs-parent="#addproduct-accordion">
                    <div class="p-4 border-top">
                        <form action="#" class="dropzone dz-clickable">
                            <div class="dz-message needsclick">
                                <div class="mb-3">
                                    <i class="display-4 text-muted uil uil-cloud-upload"></i>
                                    <div class="col-lg-4">
                                        <input type="file" name="image" id="image" class="form-control" onchange="previewImage(event)">
                                        <div id="image-container" class="mb-3" style="display: {{ $product->image ? 'block' : 'none' }};">
                                            <img id="image-preview" width="100px"  src="/storage/{{ $product->image }}" alt="Product Image">
                                        </div>
                                         </div>
                                </div>
                            </div>
                         <!--   </form>-->
                    </div>
                </div>
            </div>

            <div class="card">
                <a href="#addproduct-metadata-collapse" class="text-dark collapsed" data-bs-toggle="collapse" aria-haspopup="true" aria-expanded="false" aria-controls="addproduct-metadata-collapse">
                    <div class="p-4">

                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar-xs">
                                    <div class="avatar-title rounded-circle bg-soft-primary text-primary">
                                        03
                                    </div>
                                </div>
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <h5 class="font-size-16 mb-1">Stock Produit</h5>
                                <p class="text-muted text-truncate mb-0">Pour bien gérer le stock de produit</p>
                            </div>
                            <div class="flex-shrink-0">
                                <i class="mdi mdi-chevron-up accor-down-icon font-size-24"></i>
                            </div>

                        </div>

                    </div>
                </a>

                <div id="addproduct-metadata-collapse" class="collapse" data-bs-parent="#addproduct-accordion">
                    <div class="p-4 border-top">
                        <form>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                             <label for="stockmax" class="form-label">Stock-Max</label>
                                             <input type="number" name="stockmax" id="stockmax" class="form-control" value="{{ old('stockmax', $product->stockmax) }}">
                                            </div>

                                </div>

                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label for="stockmin" class="form-label">Stock-Min</label>
                                        <input type="number" name="stockmin" id="stockmin" class="form-control" value="{{ old('stockmin', $product->stockmin) }}">
                                    </div>
                                </div>
                            </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col ms-auto">
                <div class="d-flex flex-reverse flex-wrap gap-2">
                    <a href="#" class="btn btn-danger"> <i class="uil uil-times"></i> Cancel </a>
                    <a href="#" class="btn btn-success" t> <i class="uil uil-file-alt">
                        <button type="submit">
                            {{ $isUpdate ? 'Update' : 'Create' }}
                        </button>
                    </i> </a>
                </div>
            </div> <!-- end col -->
        </div>
    </form>
    </div>
</div>


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

@endsection
