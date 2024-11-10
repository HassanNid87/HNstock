@extends('base')

@section('title', 'Stocks')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0">Liste Stock</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Stock</a></li>
                    <li class="breadcrumb-item active">Liste Stock</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-inline-flex">
                <a href="{{ route('stocks.create') }}" title="Add Stock">
                    <button type="button" class="btn btn-success waves-effect waves-light me-2">
                        <i class="mdi mdi-plus me-1"></i>
                    </button>
                </a>
                <a href="{{ route('stock.out') }}" class="btn btn-primary">
                    <i class="fas fa-sign-out-alt me-1"></i>
                    Stock Sorti
                </a>
            </div>

            <div class="d-inline-flex w-50">
                <form method="get" id="stockForm" class="d-inline-flex align-items-center w-100">
                    <div class="me-2 w-50">
                        <select id="category-filter" name="category" class="form-control form-control-sm" aria-controls="DataTables_Table_0">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ Request::input('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-50">
                        <input type="search" name="name" id="name-filter" class="form-control form-control-sm" style="height: 100%;"
                               placeholder="CodeBarre / Name / Description" value="{{ Request::input('name') }}" aria-controls="DataTables_Table_0">
                    </div>
                </form>
            </div>
        </div>
    </div>




        <div class="table-responsive mb-4">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
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
                                    <th style="width: 150px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="stock-tbody">
                                @forelse ($stocks as $stock)
                                    <tr role="row" class="odd">
                                        <td class="text-center">
                                            <input type="checkbox" class="form-check-input" id="stockcheck{{ $stock->id }}" value="{{ $stock->id }}">
                                        </td>
                                        <td class="text-center">
                                            @if ($stock->product && $stock->product->image)
                                                <img width="50px" height="50px" src="{{ asset('storage/' . $stock->product->image) }}" alt="Product Image" class="rounded-circle">
                                            @else
                                                <img width="50px" height="50px" src="{{ asset('storage/default-image.png') }}" alt="Default Image" class="rounded-circle">
                                            @endif
                                        </td>
                                        <td>
                                            {{ $stock->product ? $stock->product->name : 'N/A' }}
                                        </td>
                                        <td>
                                            {{ $stock->product ? $stock->product->description : 'N/A' }}
                                        </td>
                                        <td>
                                            @if ($stock->product && !$stock->product->category->isDefault)
                                                <a href="{{ route('categories.show', $stock->product->category->id) }}" class="btn btn-link">
                                                    <span class="badge" style="background-color:#F97300;">
                                                        {{ $stock->product->category->name }}
                                                    </span>
                                                </a>
                                            @else
                                                ----------
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge {{ $stock->quantity > 0 ? 'bg-success' : 'bg-danger' }}">
                                                {{ $stock->quantity }}
                                            </span>
                                        </td>
                                        <td style="white-space: nowrap;">
                                            <!-- Edit Stock Button -->
                                            <a href="{{ route('stocks.edit', $stock) }}" class="btn btn-sm btn-outline-primary rounded" title="Edit">
                                                <i class="mdi mdi-pencil-outline"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center"><h4>No Stocks</h4></td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>


                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const nameFilter = document.getElementById('name-filter');
    const categoryFilter = document.getElementById('category-filter');
    const stockForm = document.getElementById('stockForm');

    function filterStocks() {
        stockForm.submit();
    }

    nameFilter.addEventListener('input', function() {
        if (nameFilter.value === '') {
            filterStocks(); // Soumettre automatiquement le formulaire si le champ est vidé
        }
    });

    categoryFilter.addEventListener('change', filterStocks);
});

</script>


@endsection
