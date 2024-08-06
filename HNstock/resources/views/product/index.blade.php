@extends('base')
@section('title', 'Products')

@section('content')
<style>
    .no-wrap {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>


<div class="container-fluid">
   <!-- Sidebar for cart -->
   <aside class="col-md-3">
    <h2>Cart</h2>
    <form method="POST" action="{{ route('createInvoice') }}">
        @csrf
        <ul id="cart-items" class="list-group mb-3"></ul>
        <p id="cart-total">Total: 0.00 MAD</p>
        <button class="btn btn-primary" onclick="createInvoice()" id="create-invoice">Create Invoice</button>
    </form>
</aside>
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
                    <a type="reset" class="btn btn-secondary" href="{{ route('products.index') }}">Reset</a>
                </div>
                <div class="form-group my-2">
                    <a type="reset" class="btn btn-primary" href="#listeProducts">Products List </a>
                </div>
            </form>
        </aside>
        <main class="col-md-9">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Products</h1>
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
                            <div class="my-1">
                                <span style="font-size: 0.875rem;">Category: <span class="badge bg-primary">{{ $product->category?->name }}</span></span>
                            </div>
                            <div class="my-1">
                                <input type="number" id="quantity-{{ $product->id }}" name="quantity" min="1" max="{{ $product->quantity }}" value="1" class="form-control mb-2">
                                <button class="btn btn-danger add-to-cart" data-id="{{ $product->id }}" data-name="{{ $product->name }}" data-price="{{ $product->priceV }}">Add to Cart</button>
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


    <div class="row">
        <!-- Sidebar for filters -->

        <!-- Main content for product list -->
        <main class="col-md-12" id="listeProducts">
            <div class="d-flex justify-content-between align-items-center" >
                <h1>Product List</h1>
                <a href="{{ route('products.create') }}" class="btn btn-primary">Create</a>
            </div>
            <table class="table">
                <thead align="center">
                    <tr>
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


<script>
  const cart = [];

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const name = this.dataset.name;
            const price = parseFloat(this.dataset.price);
            const quantity = parseInt(document.getElementById('quantity-' + id).value);

            const existingProduct = cart.find(product => product.id === id);
            if (existingProduct) {
                existingProduct.quantity = quantity;
            } else {
                cart.push({ id, name, price, quantity });
            }

            updateCart();
        });
    });

    function updateCart() {
        let cartItems = '';
        let total = 0;

        cart.forEach(product => {
            total += product.price * product.quantity;
            cartItems += `<li>${product.name} - ${product.quantity} x ${product.price} MAD</li>`;
        });

        document.getElementById('cart-items').innerHTML = cartItems;
        document.getElementById('cart-total').innerText = `Total: ${total.toFixed(2)} MAD`;
    }
});

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
</script>
