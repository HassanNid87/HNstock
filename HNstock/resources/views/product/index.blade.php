@extends('base')

@section('title', 'Produits')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Liste Produits</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Produits</a></li>
                        <li class="breadcrumb-item active">Liste Produits</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <div class="row mb-3">
        <!-- Colonne du Bouton Nouveau Produit -->
        <div class="col-sm-12 col-md-4">
            <a href="{{ route('products.create') }}" class="btn btn-success waves-effect waves-light">
                <i class="mdi mdi-plus me-1"></i>
            </a>
        </div>

        <!-- Colonne du Filtre par Catégorie -->
        <div class="col-sm-12 col-md-4 d-flex align-items-center">
            <form method="get" action="{{ route('products.index') }}" id="categoryForm" class="d-flex w-100">
                <select id="category-filter" name="category" class="form-control form-control-sm w-100" aria-controls="DataTables_Table_0">
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ Request::input('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        <!-- Colonne du Filtre de Recherche -->
        <div class="col-sm-12 col-md-4 d-flex align-items-center">
            <form method="get" action="{{ route('products.index') }}" id="searchForm" class="d-flex w-100">
                <input type="search" name="code" id="code" class="form-control form-control-sm w-100"
                    placeholder="Code / Nom / Description" value="{{ request()->input('code') }}" aria-controls="DataTables_Table_0">
                <input type="hidden" name="tab" value="list">
            </form>
        </div>
    </div>
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" id="product-tabs" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="list-tab" data-bs-toggle="tab" href="#list" role="tab" aria-controls="list" aria-selected="true">Liste</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="grid-tab" data-bs-toggle="tab" href="#grid" role="tab" aria-controls="grid" aria-selected="false">Grille</a>
        </li>
    </ul>

    <!-- Tab content -->
    <div class="tab-content mt-4" id="product-tabs-content">
        <!-- List Tab -->
        <div class="tab-pane fade show active" id="list" role="tabpanel" aria-labelledby="list-tab">

            <div class="table-responsive mb-4">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <div class="row">

                    </div>

                    <table class="table table-centered datatable dt-responsive nowrap table-card-list dataTable no-footer dtr-inline" style="border-collapse: collapse; border-spacing: 0px 12px; width: 100%;" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                        <thead style="background-color: #dde0e0;">
                            <tr class="bg-transparent">
                                <th style="width: 22px;"></th>
                                <th class="sorting" style="width: 86px;">Image</th>
                                <th class="sorting" style="width: 120px;">Nom</th>
                                <th class="sorting" style="width: 217px;">Description</th>
                                <th class="sorting" style="width: 144px;">Catégorie</th>
                                <th class="sorting" style="width: 144px;">Stock</th>
                                <th class="sorting" style="width: 59px;">Prix A</th>
                                <th class="sorting" style="width: 59px;">Prix V</th>
                                <th style="width: 150px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                                <tr role="row" class="odd">
                                    <td class="sorting_1 dtr-control">
                                        <div class="form-check text-center">
                                            <input type="checkbox" class="form-check-input" id="productcheck1">
                                            <label class="form-check-label" for="productcheck1"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <img width="50px" height="50px" src="{{ asset('storage/' . $product->image) }}" alt="Product Image" class="rounded-circle">
                                    </td>
                                    <td><a href="javascript: void(0);" class="text-dark fw-bold">{{ $product->name }}</a></td>
                                    <td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 200px;">
                                        {!! $product->description !!}
                                    </td>
                                    <td>
                                        @if ($product->category)
                                            <a href="{{ route('categories.show', $product->category_id) }}" class="btn btn-link">
                                                <span class="badge" style="background-color:#F97300;">{{ $product->category->name }}</span>
                                            </a>
                                        @else
                                            ----------
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-success" style="font-size: 12px;">
                                            {{ $product->stock ? $product->stock->quantity : 'N/A' }}
                                        </span>
                                    </td>
                                    <td>{{ number_format($product->priceA, 2) }}</td>
                                    <td class="text-dark fw-bold">{{ number_format($product->priceV, 2) }}</td>
                                    <td>
                                        <div class="btn-group gap-2">
                                            <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-outline-primary rounded" title="Edit">
                                                <i class="mdi mdi-pencil-outline"></i>
                                            </a>
                                            <form method="POST" action="{{ route('products.destroy', $product) }}" onsubmit="return confirm('Are you sure you want to delete this product?')" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger rounded" title="Delete">
                                                    <i class="mdi mdi-delete"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" align="center"><h4>No Products</h4></td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <!-- Grid Tab -->
        <div class="tab-pane fade" id="grid" role="tabpanel" aria-labelledby="grid-tab">

                        <!-- Zone de recherche pour l'onglet grille -->
         <div class="row">
                            <!-- Formulaire de Filtrage par Catégorie -->
            <div class="row">
                    <!-- Sidebar for cart -->
                    <aside class="col-md-12">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h2 class="h5 mb-0">Panier</h2>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('createInvoice') }}">
                                    @csrf
                                    <table class="table table-bordered table-striped">
                                        <thead id="cart-header" class="table-dark">
                                            <tr>
                                                <th>Image</th> <!-- Nouvelle colonne pour l'image -->
                                                <th>Nom du produit</th>
                                                <th>Quantité</th>
                                                <th>Prix unitaire</th>
                                                <th>Total</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="cart-items">
                                            <!-- Les éléments du panier seront insérés ici -->
                                        </tbody>
                                     </table>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <strong id="cart-total" class="badge" style="background-color:#790cdf; font-size:16;">Total: 0.00 MAD</strong>
                                    </div>
                                    <button type="submit" class="btn btn-success btn-sm mt-3" id="create-invoice">
                                        <i class="fas fa-file-invoice"></i> Créer la facture
                                    </button>
                                </form>
                            </div>
                        </div>
                    </aside>
            </div>

            <div class="row row-cols-1 row-cols-md-4 g-4">
                @foreach ($products as $product)
                <div class="col">
                    <div class="card h-100" style="max-width: 200px; padding: 6px;">
                        <img class="card-img-top" src="{{ asset('storage/' . $product->image) }}" alt="" style="height: 110px; object-fit: cover;">
                        <div class="card-body" style="padding: 3px;">
                            <h6 class="card-title" style="font-size: 0.875rem;">{{ $product->name }}</h6>
                            <p class="card-text" style="font-size: 0.75rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                {!! $product->description !!}
                            </p>
                            <span class="badge" style="background-color:#F97300;">{{ $product->category->name }}</span>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <span style="font-size: 0.85rem;">
                                    <span class="badge bg-success">Stock: {{ $product->stock ? $product->stock->quantity : 'N/A' }}</span>
                                </span>
                                <span style="font-size: 0.85rem;">
                                    <span class="badge bg-danger">{{ number_format($product->priceV, 2) }} MAD</span>
                                </span>
                            </div>
                        </div>
                        <div class="card-footer" style="padding: 3px;">
                            <div class="d-flex align-items-center">
                                <button type="button" class="btn btn-outline-primary quantity-decrease"
                                    style="padding: 2px 5px; font-size: 0.75rem;">
                                    -
                                </button>

                                <input type="number" id="quantity-{{ $product->id }}" name="quantity"
                                    min="1" max="{{ $product->stock ? $product->stock->quantity : 1 }}" value="0"
                                    class="form-control mx-2"
                                    style="max-width: 60px; font-size: 0.75rem; text-align: center;">

                                <button type="button" class="btn btn-outline-primary quantity-increase"
                                    style="padding: 2px 5px; font-size: 0.75rem;">
                                    +
                                </button>

                                <!-- Ajouter un espacement ici -->
                                <div style="flex-grow: 1;"></div>

                                <button title="Ajouter au panier" class="btn btn-danger add-to-cart"
                                    data-id="{{ $product->id }}"
                                    data-name="{{ $product->name }}"
                                    data-price="{{ $product->priceV }}"
                                    data-image="{{ asset('storage/' . $product->image) }}"
                                    style="height: 30px; width: 30px;">
                                    <i class="fas fa-cart-plus" style="font-size: 0.7rem;"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS (pour les onglets) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

   <script>
       const cart = [];

       document.addEventListener('DOMContentLoaded', function() {
           // Masquer l'en-tête du tableau si le panier est vide au chargement initial
           updateCart();

           document.querySelectorAll('.add-to-cart').forEach(button => {
               button.addEventListener('click', function() {
                   const id = this.dataset.id;
                   const name = this.dataset.name;
                   const price = parseFloat(this.dataset.price);
                   const quantity = parseInt(document.getElementById('quantity-' + id).value);
                   const imageUrl = this.dataset.image; // Ajouter une donnée pour l'image

                   const existingProduct = cart.find(product => product.id === id);
                   if (existingProduct) {
                       existingProduct.quantity = quantity;
                   } else {
                       cart.push({ id, name, price, quantity, imageUrl });
                   }

                   updateCart();
               });
           });

           function updateCart() {
               let cartItems = '';
               let total = 0;

               if (cart.length === 0) {
                   document.getElementById('cart-header').classList.add('hidden');
               } else {
                   document.getElementById('cart-header').classList.remove('hidden');
               }

               cart.forEach(product => {
                   const itemTotal = product.price * product.quantity;
                   total += itemTotal;
                   cartItems += `
                       <tr>
                           <td ><img class="rounded-circle" src="${product.imageUrl}" alt="${product.name}" style="width: 50px; height: 50px; object-fit: cover;"></td>
                           <td>${product.name}</td>
                           <td>${product.quantity}</td>
                           <td>${product.price.toFixed(2)} </td>
                           <td>${itemTotal.toFixed(2)} </td>
                           <td>
                               <button class="btn btn-sm btn-outline-danger remove-from-cart" data-id="${product.id}">
                                   <i class="fas fa-trash-alt"></i>
                               </button>
                               <input type="hidden" name="cart[${product.id}][id]" value="${product.id}" />
                               <input type="hidden" name="cart[${product.id}][quantity]" value="${product.quantity}" />
                           </td>
                       </tr>
                   `;
               });

               document.getElementById('cart-items').innerHTML = cartItems;
               document.getElementById('cart-total').innerText = `Total: ${total.toFixed(2)} MAD`;

               // Add event listeners for remove buttons
               document.querySelectorAll('.remove-from-cart').forEach(button => {
                   button.addEventListener('click', function() {
                       const id = this.dataset.id;
                       const index = cart.findIndex(product => product.id === id);
                       if (index > -1) {
                           cart.splice(index, 1);
                           updateCart();
                       }
                   });
               });
           }

           document.getElementById('create-invoice').addEventListener('click', createInvoice);

           function createInvoice() {
               if (cart.length === 0) {
                   alert('Votre panier est vide.');
                   return;
               }

               console.log('Données du panier avant l\'envoi:', cart);

               const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

               fetch('http://127.0.0.1:8000/create-invoice', {
                   method: 'POST',
                   headers: {
                       'Content-Type': 'application/json',
                       'X-CSRF-TOKEN': csrfToken
                   },
                   body: JSON.stringify({ cart })
               })
               .then(response => {
                   if (!response.ok) {
                       throw new Error('Erreur réseau');
                   }
                   return response.json();
               })
               .then(data => {
                   alert(data.message);
                   cart.length = 0;
                   updateCart();
               })
               .catch(error => {
                   console.error('Erreur:', error);
               });
           }
       });

       </script>
       <script>
           document.addEventListener('DOMContentLoaded', function () {
               // Gérer l'incrémentation
               document.querySelectorAll('.quantity-increase').forEach(button => {
                   button.addEventListener('click', function () {
                       const input = this.parentNode.querySelector('input[name="quantity"]');
                       const max = parseInt(input.max);
                       if (parseInt(input.value) < max) {
                           input.value = parseInt(input.value) + 1;
                       }
                   });
               });

               // Gérer la décrémentation
               document.querySelectorAll('.quantity-decrease').forEach(button => {
                   button.addEventListener('click', function () {
                       const input = this.parentNode.querySelector('input[name="quantity"]');
                       const min = parseInt(input.min);
                       if (parseInt(input.value) > min) {
                           input.value = parseInt(input.value) - 1;
                       }
                   });
               });
           });
       </script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Gestion du filtre par catégorie
        const categoryFilter = document.getElementById('category-filter');
        const categoryForm = document.getElementById('categoryForm');

        function filterStocks() {
            categoryForm.submit();
        }

        categoryFilter.addEventListener('change', filterStocks);
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Gestion de la recherche
        const searchInput = document.getElementById('code');
        const searchForm = document.getElementById('searchForm');
        let timeout;

        searchInput.addEventListener('input', function() {
            clearTimeout(timeout);
            timeout = setTimeout(function() {
                if (searchInput.value.trim() === '') {
                    searchForm.submit();
                }
            }, 300); // Délai de 300ms
        });
    });
</script>

@endsection
