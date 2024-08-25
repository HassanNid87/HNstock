@extends('base')
@section('title', 'Stock Out')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0">Stock Sorti</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Stock</a></li>
                    <li class="breadcrumb-item active">Stock Sorti</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">

        <div class="col-lg-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="d-inline-flex">
                    <a href="{{ route('stocks.index') }}" title="Retour au Stock">
                        <button type="button" class="btn btn-success waves-effect waves-light me-2">
                            <i class="mdi mdi-eye me-1"></i> <!-- Nouvelle icône -->
                            Stock Réel
                        </button>
                    </a>
                </div>
            </div>


            <div class="row">
                <!-- Formulaire pour le filtre de date (50%) -->
                <div class="col-md-6">
                    <form method="get" id="dateFilterForm" action="{{ url()->current() }}" class="d-flex align-items-center">
                        <div class="input-daterange input-group w-100" id="datepicker6" data-date-format="yyyy-mm-dd" data-date-autoclose="true">
                            <input type="text" class="form-control text-start form-control-sm" placeholder="From" name="start_date" id="start_date" value="{{ request('start_date') }}" autocomplete="off" autocorrect="off">
                            <input type="text" class="form-control text-start form-control-sm" placeholder="To" name="end_date" id="end_date" value="{{ request('end_date') }}" autocomplete="off" autocorrect="off">
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm ms-2">
                            <i class="mdi mdi-filter-variant"></i>
                        </button>
                        <a class="btn btn-secondary btn-sm ms-2" href="{{ route('stock.out') }}" title="Reset">
                            <i class="fas fa-redo"></i>
                        </a>
                    </form>
                </div>

                <!-- Filtre pour la catégorie et la zone de recherche (50%) -->
                <div class="col-md-6">
                    <div class="row">
                        <!-- Formulaire pour le filtre de catégorie (50% de la moitié) -->
                        <div class="col-md-6">
                            <form method="get" id="categoryFilterForm" class="d-flex align-items-center">
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

                        <!-- Formulaire pour le filtre par nom (50% de la moitié) -->
                        <div class="col-md-6">
                            <form method="get" id="nameFilterForm" class="d-flex align-items-center">
                                <input type="search" name="name" id="name-filter" class="form-control form-control-sm w-100"
                                       placeholder="CodeBarre / Name / Description" value="{{ Request::input('name') }}" aria-controls="DataTables_Table_0">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<br>


        <div class="table-responsive mb-4">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-centered datatable dt-responsive nowrap table-card-list dataTable no-footer dtr-inline"
                               style="border-collapse: collapse; border-spacing: 0px 12px; width: 100%;"
                               id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                            <thead style="background-color: #dde0e0;">
                                <tr align="center">
                                    <th>Image</th>
                                    <th>Product</th>
                                    <th>Description</th>
                                    <th>Catégorie</th>
                                    <th>Quantity</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody id="stock-tbody">
                                @foreach ($stockOuts as $stockOut)
                                <tr data-category-id="{{ $stockOut['product']->category->id }}">
                                    <td hidden class="product-codebar">{{ $stockOut['product']->codebare }}</td>
                                    <td class="text-center">
                                        @if ($stockOut['product'] && $stockOut['product']->image)
                                            <img width="50px" height="50px" src="{{ asset('storage/' . $stockOut['product']->image) }}" alt="Product Image" class="rounded-circle">
                                        @else
                                            <img width="50px" height="50px" src="{{ asset('storage/default-image.png') }}" alt="Default Image" class="rounded-circle">
                                        @endif
                                    </td>
                                    <td class="product-name">{{ $stockOut['product']->name }}</td>
                                    <td class="product-description">{{ $stockOut['product']->description }}</td>
                                    <td> <span class="badge" style="background-color:#F97300;">{{ $stockOut['product']->category->name ?? 'Non spécifié' }}</span></td>
                                    <td> <span class="badge bg-success" style="font-size: 12px;">{{ $stockOut['quantity'] }}</span></td>
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
</div>


<script>
    $(document).ready(function () {
        $('#datepicker6').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        });
    });
    </script>



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

        if (productName.includes(filter) ||
            (productDescription && productDescription.includes(filter)) ||
            (productCodeBarre && productCodeBarre.includes(filter))) {
            row.style.display = ''; // Afficher la ligne
        } else {
            row.style.display = 'none'; // Masquer la ligne
        }
    });
});

</script>

<script>
   document.addEventListener('DOMContentLoaded', function() {
    const nameFilter = document.getElementById('name-filter');
    const nameFilterForm = document.getElementById('nameFilterForm');
    const dateFilterForm = document.getElementById('dateFilterForm');
    const savedStartDate = document.getElementById('start_date');
    const savedEndDate = document.getElementById('end_date');

    nameFilter.addEventListener('input', function() {
        if (nameFilter.value === '') {
            // Copier les valeurs actuelles des champs de date dans le formulaire de recherche par nom
            if (savedStartDate && savedEndDate) {
                nameFilterForm.appendChild(createHiddenInput('start_date', savedStartDate.value));
                nameFilterForm.appendChild(createHiddenInput('end_date', savedEndDate.value));
            }
            nameFilterForm.submit(); // Soumettre automatiquement le formulaire
        }
    });

    function createHiddenInput(name, value) {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = name;
        input.value = value;
        return input;
    }
});

</script>



@endsection
