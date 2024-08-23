@extends('base')

@section('title', 'Produits')

@section('content')


<div class="row">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('products.create') }}" class="btn btn-success waves-effect waves-light mb-3">
            <i class="mdi mdi-plus me-1"></i>
            Nouveau Produit
        </a>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-6">
            <form method="get" action="{{ route('products.index') }}">
                <div class="dataTables_length" id="DataTables_Table_0_length">
                    <label class="d-flex align-items-center">
                        <input type="search" name="code" id="code" class="form-control form-control-sm me-2 w-auto"
                               placeholder="Code / Nom / Description" value="{{ request()->input('code') }}" aria-controls="DataTables_Table_0">
                        <input type="hidden" name="tab" value="list">
                    </label>
                </div>
                <!-- Ajoutez ici les autres champs de filtre -->
            </form>

        </div>
        <div class="col-sm-12 col-md-6">

        </div>
    </div>
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
                                <h5 class="font-size-16 mb-1">Liste Produits</h5>
                                <p class="text-muted text-truncate mb-0">Affichage des produits sous forme de tableau détaillé</p>
                            </div>
                            <div class="flex-shrink-0">
                                <i class="mdi mdi-chevron-up accor-down-icon font-size-24"></i>
                            </div>

                        </div>

                    </div>
                </a>

                <div id="addproduct-billinginfo-collapse" class="collapse show" data-bs-parent="#addproduct-accordion">
                    <div class="p-4 border-top">
                        <div class="row">
                            <div class="col-lg-12">

                                <div class="table-responsive mb-4">
                                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">

                                        <!--<div class="row">
                                            <div class="col-sm-12 col-md-6">
                                                <div class="dataTables_length" id="DataTables_Table_0_length">
                                                    <label>Show entries
                                                        <select name="DataTables_Table_0_length" aria-controls="DataTables_Table_0" class="custom-select custom-select-sm form-control form-control-sm form-select form-select-sm">
                                                            <option value="10">10</option>
                                                            <option value="25">25</option>
                                                            <option value="50">50</option>
                                                            <option value="100">100</option>
                                                        </select> </label>
                                                </div>
                                             </div>
                                       </div>-->
                                            <div class="row">
                                                <div class="col-sm-12">
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
                                            <div class="row">
                                                <div class="col-sm-12 col-md-5">
                                                    <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">Showing 1 to 10 of 12 entries
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-7">
                                                        <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
                                                            <ul class="pagination">
                                                                <li class="paginate_button page-item previous disabled" id="DataTables_Table_0_previous">
                                                                    <a href="#" aria-controls="DataTables_Table_0" data-dt-idx="0" tabindex="0" class="page-link">Previous</a>
                                                                </li>
                                                                <li class="paginate_button page-item active">
                                                                    <a href="#" aria-controls="DataTables_Table_0" data-dt-idx="1" tabindex="0" class="page-link">1</a>
                                                                </li>
                                                                <li class="paginate_button page-item ">
                                                                    <a href="#" aria-controls="DataTables_Table_0" data-dt-idx="2" tabindex="0" class="page-link">2</a>
                                                                </li>
                                                                <li class="paginate_button page-item next" id="DataTables_Table_0_next">
                                                                    <a href="#" aria-controls="DataTables_Table_0" data-dt-idx="3" tabindex="0" class="page-link">Next
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                         </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                                <h5 class="font-size-16 mb-1">Grille Produits</h5>
                                <p class="text-muted text-truncate mb-0">Affichage des produits sous forme de cartes</p>
                            </div>
                            <div class="flex-shrink-0">
                                <i class="mdi mdi-chevron-up accor-down-icon font-size-24"></i>
                            </div>
                        </div>
                    </div>
                </a>
                <div id="addproduct-img-collapse" class="collapse" data-bs-parent="#addproduct-accordion">
                    <div class="p-4 border-top">
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
                                            min="1" max="{{ $product->stock ? $product->stock->quantity : 1 }}" value="1"
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


        </div>
        <div class="row mb-4">
            <div class="col ms-auto">
                <div class="d-flex flex-reverse flex-wrap gap-2">
                    <a href="#" class="btn btn-danger"> <i class="uil uil-times"></i> Cancel </a>
                    <a href="#" class="btn btn-success" t> <i class="uil uil-file-alt">

                    </i> </a>
                </div>
            </div> <!-- end col -->
        </div>
    </form>
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


@endsection
