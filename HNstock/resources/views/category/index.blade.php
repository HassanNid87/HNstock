@extends('base')
@section('title' , 'Category')

@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Category Liste </h1>
        <a href="{{route('categories.create')}}" class="btn btn-primary">Create</a>
    </div>
    <table class="table">
        <thead align="center">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Actions         </th>
            </tr>
        </thead>
        <tbody align="center">
         @forelse ($categories as $category)
         <tr>
                <td>{{$category->id}}</td>
                <td>{{$category->name}}</td>

                <td>
                  <div class="btn-group gap-2">
                        <a href="{{ route('categories.show', $category) }}" class="btn btn-sm btn-outline-info rounded" >Show</a>
                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-outline-primary rounded" >Update</a>
                        <form method="POST" action="{{ route('categories.destroy',$category) }}">
                        @csrf
                        @method('DELETE')
                            <input type="submit"  class="btn btn-sm btn-outline-danger rounded" value="Delete">
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
@endsection
