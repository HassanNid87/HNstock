@extends('base')

@section('title', 'Stocks')

@section('content')
<div class="row">
    <div class="col-lg-12">

        <div class="d-inline-flex">
            <a href="{{ route('stocks.create') }}" title="Add Stock">
                <button type="button" class="btn btn-success waves-effect waves-light mb-3 me-2">
                    <i class="mdi mdi-plus me-1"></i>
                    Nouveau Stock
                </button>
            </a>
            <a href="{{ route('stock.out') }}" class="btn btn-primary mb-3">
                <i class="fas fa-sign-out-alt me-1"></i>
                Stock Out
            </a>
        </div>


        <div class="row">
            <div class="col-sm-12 col-md-6">
                <form method="get" id="stockForm">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="dataTables_length" id="DataTables_Table_0_length">
                                <label class="d-flex align-items-center">
                                    <select id="category-filter" name="category" class="form-control form-control-sm me-2 w-auto" aria-controls="DataTables_Table_0">
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ Request::input('category') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="dataTables_length" id="DataTables_Table_0_length">
                                <label class="d-flex align-items-center">
                                    <input type="search" name="name" id="name-filter" class="form-control form-control-sm me-2 w-auto"
                                           placeholder="CodeBarre / Name / Description" value="{{ Request::input('name') }}" aria-controls="DataTables_Table_0">
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
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
                                            <img width="50px" height="50px" src="{{ asset('storage/' . $stock->product->image) }}" alt="Product Image" class="rounded-circle">
                                        </td>
                                        <td>{{ $stock->product->name }}</td>
                                        <td>{{ $stock->product->description }}</td>
                                        <td>
                                            @if ($stock->product->category)
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

                                            <a href="{{ route('stocks.edit',$stock) }}" class="btn btn-sm btn-outline-primary rounded" title="Edit">
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
