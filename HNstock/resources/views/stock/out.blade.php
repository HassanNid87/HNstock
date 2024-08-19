@extends('base')

@section('title', 'Stock Out')

@section('content')
<style>
    /* Style pour le conteneur du sélecteur */
    .filter-container {
        margin: 20px 0;
        padding: 15px;
        border-radius: 5px;
        border: 1px solid #ddd;
        background-color: #f9f9f9;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    /* Style pour le sélecteur */
    #category-filter {
        width: 150px; /* Ajustez la largeur selon vos besoins */
        padding: 5px;
        border-radius: 4px;
        border: 1px solid #ced4da;
        background-color: #fff;
        font-size: 14px; /* Ajustez la taille de la police selon vos besoins */
        color: #495057;
    }

    /* Style pour les options du sélecteur */
    #category-filter option {
        padding: 10px; /* Ajustez cette valeur selon vos besoins */
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

</style>

<div class="container my-5">
    <a href="{{ route('stocks.index') }}" class="btn btn-secondary mb-3">Stock Liste</a>

    <!-- Formulaire de filtrage par date -->
    <form action="{{ route('stock.out') }}" method="GET" class="mb-4">
        <div class="row">
            <div class="col-md-3">
                <label for="start_date" class="form-label">Du</label>
                <input type="date" id="start_date" name="start_date" class="form-control" value="{{ request('start_date', date('Y-m-d')) }}">
            </div>
            <div class="col-md-3">
                <label for="end_date" class="form-label">Au</label>
                <input type="date" id="end_date" name="end_date" class="form-control" value="{{ request('end_date', date('Y-m-d')) }}">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary" title="Filtrer">
                    <i class="fas fa-filter"></i>
                </button>
            </div>
        </div>
    </form>

    <!-- Carte pour afficher les sorties de stock -->
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="card-title">Stock Out</h5>
        </div>
        <div class="card-body">
            <div class="filter-container">
                <!-- Liste déroulante pour les catégories -->
                <div class="form-group mb-4">
                    <!--<label for="category-filter" class="form-label">Select Category</label>-->
                    <select id="category-filter" class="form-select">
                        <option value="">Select Categorie</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <br>
                    <div class="form-group">
                        <!-- <label for="name">Name or Description</label>-->
                        <input type="text" name="name" id="name-filter" class="form-control" placeholder="CodeBarre / Name / Description">
                    </div>

                        <br>
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="table-dark">
                            <tr align="center">
                                <th>Product</th>
                                <th>Description</th>
                                <th>Quantity</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody id="stock-tbody" align="center">
                            @foreach ($stockOuts as $stockOut)
                                <tr data-category-id="{{ $stockOut['product']->category->id }}">
                                    <td hidden class="product-codebar">{{ $stockOut['product']->codebare }}</td>
                                    <td class="product-name">{{ $stockOut['product']->name }}</td>
                                    <td class="product-name">{{ $stockOut['product']->description }}</td>
                                    <td>{{ $stockOut['quantity'] }}</td>
                                    <td>{{ $stockOut['date'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

        </div>
    </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('category-filter').addEventListener('change', function() {
        var selectedCategoryId = this.value;
        var rows = document.querySelectorAll('#stock-tbody tr');

        rows.forEach(row => {
            var rowCategoryId = row.getAttribute('data-category-id');
            if (selectedCategoryId === "" || rowCategoryId === selectedCategoryId) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    });
</script>

<script>
    document.getElementById('name-filter').addEventListener('keyup', function() {
        var filter = this.value.toLowerCase();
        var rows = document.querySelectorAll('#stock-tbody tr');

        rows.forEach(function(row) {
            var productName = row.querySelector('.product-name').textContent.toLowerCase();
            var productDescription = row.querySelector('.product-description')?.textContent.toLowerCase();
            var productCodeBarre = row.querySelector('.product-codebar')?.textContent.toLowerCase();

            if (productName.includes(filter) || (productDescription && productDescription.includes(filter)) || (productCodeBarre && productCodeBarre.includes(filter))) {
                row.style.display = ''; // Afficher la ligne
            } else {
                row.style.display = 'none'; // Masquer la ligne
            }
        });
    });
    </script>
@endsection
