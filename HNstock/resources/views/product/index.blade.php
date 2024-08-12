@extends('base')
@section('title', 'Products')

@section('content')
<style>
    .no-wrap {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .hidden {
    display: none;
}

.table {
    margin: 20px 0;
    width: 100%;
    text-align: center;
    border-collapse: collapse;
}

.table thead {
    background-color: #343a40;
    color: white;
}

.table tbody tr:hover {
    background-color: #f5f5f5;
}

.table td, .table th {
    padding: 10px;
    vertical-align: middle;
    border: 1px solid #ddd;
}

.table-striped tbody tr:nth-of-type(odd) {
    background-color: #f2f2f2;
}

.table-hover tbody tr:hover {
    background-color: #e9ecef;
}

.table th {
    font-weight: bold;
}

.table td {
    font-size: 14px;
}

.btn-group .btn {
    margin-right: 5px;
}

img.rounded {
    border-radius: 8px;
    object-fit: cover;
}

</style>


<div class="container-fluid">

 <!-- Sidebar for cart -->
 <aside class="col-md-12">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h2 class="h5 mb-0">Panier</h2>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('createInvoice') }}">
                @csrf
                <table class="table">
                    <thead id="cart-header" class="table-header">
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



    <div class="row">

        <aside class="col-md-3">
            <h1>Filters</h1>
            <form method="get">
                <div class="form-group">
                   <!-- <label for="name">Name or Description</label>-->
                    <input type="text" name="name" id="name" class="form-control" placeholder="Name or Description" value="{{ Request::input('name') }}">
                </div>
                <hr>
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
                <hr>
                <h3>Prix</h3>
                <div class="form-group">
               <!--     <label for="max">Max</label>-->
                    <input type="text" min="{{ $priceVOptions->minPriceV }}" max="{{ $priceVOptions->maxPriceV }}" name="max" id="max" class="form-control" placeholder="Prix Max" value="{{ Request::input('max') }}">
                   <br>
                    <!--<label for="min">Min</label>-->
                    <input type="text" min="{{ $priceVOptions->minPriceV }}" max="{{ $priceVOptions->maxPriceV }}" name="min" id="min" class="form-control" placeholder="Prix Min" value="{{ Request::input('min') }}">
                </div>
                <div class="form-group my-2">
                    <button type="submit" class="btn btn-primary" title="Filtrer">
                        <i class="fas fa-filter"></i>
                    </button>
                    <a type="reset" class="btn btn-secondary" href="{{ route('products.index') }}" title="Reset">
                        <i class="fas fa-undo"></i>
                    </a>
                </div>

                <div class="form-group my-2">
                    <a class="btn btn-primary" href="#listeProducts" title="Liste Produits">
                        <i class="fas fa-list"></i>
                    </a>
                </div>
            </form>
        </aside>
        <main class="col-md-9">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Produits</h1>
                <a href="{{ route('products.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                </a>
                            </div>

            <div class="row row-cols-1 row-cols-md-4 g-4">
                @foreach ($products as $product)
                <div class="col">
                    <div class="card h-100" style="max-width: 200px; padding: 6px;">
                        <img class="card-img-top" src="storage/{{ $product->image }}" alt="" style="height: 110px; object-fit: cover;">
                        <div class="card-body" style="padding: 3px;">
                            <h6 class="card-title" style="font-size: 0.875rem;">{{ $product->name }}</h6>
                            <p class="card-text" style="font-size: 0.75rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                {!! $product->description !!}
                            </p>
                             <!-- Empêcher le retour à la ligne -->
                             <span class="badge" style="background-color:#F97300;">{{ $product->category->name }}</span>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <span style="font-size: 0.85rem;"><span class="badge bg-success" >Stock: {{ $product->stock->quantity }}</span></span>
                                <span style="font-size: 0.85rem;"><span class="badge bg-danger">{{ $product->priceV }} MAD</span></span>
                            </div>

                        </div>
                        <div class="card-footer" style="padding: 3px;">
                            <div class="d-flex align-items-center">
                                <button type="button" class="btn btn-outline-primary quantity-decrease"
                                    style="padding: 2px 5px; font-size: 0.75rem;">
                                    -
                                </button>

                                <input type="number" id="quantity-{{ $product->id }}" name="quantity"
                                    min="1" max="{{ $product->quantity }}" value="1"
                                    class="form-control mx-2"
                                    style="max-width: 60px; font-size: 0.75rem; text-align: center;">

                                <button type="button" class="btn btn-outline-primary quantity-increase"
                                    style="padding: 2px 5px; font-size: 0.75rem;">
                                    +
                                </button>

                                <!-- Ajouter un espacement ici -->
                                <div style="flex-grow: 1;"></div>

                                <button title="ajouter au panier" class="btn btn-danger add-to-cart"
                                    data-id="{{ $product->id }}"
                                    data-name="{{ $product->name }}"
                                    data-price="{{ $product->priceV }}"
                                    data-image="{{ asset('storage/' . $product->image) }}"
                                    style="padding: 0.5px 4px; font-size: 0.7rem; height: 30px; width: 30px;">
                                    <i class="fas fa-cart-plus" style="font-size: 0.7rem;"></i>
                                </button>
                            </div>
                        </div>

                    </div>
                </div>



                @endforeach
            </div>


        </main>

    </div>


    <div class="row">
        <!-- Sidebar for filters -->

        <!-- Main content for product list -->
        <main class="col-md-12" id="listeProducts">
            <div class="d-flex justify-content-between align-items-center" >
                <h1>Liste Produits</h1>
                <a href="{{ route('products.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                </a>
            </div>
            <table class="table table-bordered table-striped table-hover">
                <thead class="table-dark" align="center">
                    <tr>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Categorie</th>
                        <th>Stock</th>
                        <th>Image</th>
                        <th>Prix A</th>
                        <th>Prix V</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr align="center">
                            <td>{{ $product->name }}</td>
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
                            <td>
                                <img width="40px" height="40px" src="{{ asset('storage/' . $product->image) }}" alt="Product Image" class="rounded">
                            </td>
                            <td>{{ number_format($product->priceA, 2) }} </td>
                            <td>{{ number_format($product->priceV, 2) }} </td>
                            <td>
                                <div class="btn-group gap-2">
                                    <a href="{{ route('products.edit', $product) }}" >
                                       <span title="Edit" class="btn btn-sm btn-outline-primary rounded"> <i class="fas fa-edit"></i></span>
                                    </a>
                                    <form method="POST" action="{{ route('products.destroy', $product) }}" onsubmit="return confirm('Are you sure you want to delete this product?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded" title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" align="center"><h6>No products.</h6></td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </main>
    </div>

</div>



@endsection


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
                    <td><img src="${product.imageUrl}" alt="${product.name}" style="width: 40px; height: 40px; object-fit: cover;"></td>
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
