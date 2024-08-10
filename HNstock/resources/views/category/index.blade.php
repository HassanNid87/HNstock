{{-- resources/views/categories/index.blade.php --}}
@extends('base')

@section('title', 'Category')

@section('content')
<div class="container my-5">
    <div class="card">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Category Liste</h5>
            <a href="{{ route('categories.create') }}" class="btn btn-light">+</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead align="center">
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
                                <a href="{{ route('categories.show', $category) }}" class="btn btn-sm btn-outline-info rounded" title="Show">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-outline-primary rounded" title="Update">
                                    <i class="fas fa-edit"></i>
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
                        <td colspan="3" align="center"><h6>No Category.</h6></td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $categories->links() }}
        </div>
    </div>
</div>
@endsection
