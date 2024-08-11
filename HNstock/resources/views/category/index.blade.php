{{-- resources/views/categories/index.blade.php --}}
@extends('base')

@section('title', 'Category')

<style>


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

</style>

@section('content')
<div class="container my-5">
    <div class="card">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Category Liste</h5>
            <a href="{{ route('categories.create') }}" class="btn btn-light">+</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped table-hover">
                <thead class="table-dark" align="center">
                    <tr>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody align="center">
                    @forelse ($categories as $category)
                        <tr>
                            <td>{{ $category->name }}</td>
                            <td>
                                <div class="btn-group gap-2">
                                    <a href="{{ route('categories.show', $category) }}" >
                                       <span class="btn btn-sm btn-outline-info rounded" title="Show"><i class="fas fa-eye"></i></span>
                                    </a>
                                    <a href="{{ route('categories.edit', $category) }}" >
                                       <span class="btn btn-sm btn-outline-info rounded" title="Update"> <i class="fas fa-edit"></i></span>
                                    </a>
                                    <form method="POST" action="{{ route('categories.destroy', $category) }}" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" align="center"><h6>No Category.</h6></td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $categories->links() }}
        </div>
    </div>
</div>
@endsection
