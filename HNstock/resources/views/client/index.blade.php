@extends('base')

@section('title', 'Clients')

@section('content')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="">Client List </h1>
    <a href="{{ route('clients.create') }}" class="btn btn-primary">Create</a>
</div>
    <table class="table">
        <thead >
            <tr align="center">
                <th>Id</th>
                <th>Name</th>
                <th>Tel</th>
                <th>Email</th>
                <th>Photo</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse  ($clients as $client )
            <tr align="center">
                <td>{{ $client->id }}</td>
                <td>{{ $client->name }}</td>
                <td>{{ $client->tel }}</td>
                <td>{{ $client->email }}</td>
                <td><img width="50px" height="50px"src="storage/{{ $client->photo }}" alt="" class=""></td>
                <td>
                    <div class="btn-group gap-2">
                            <a href="{{ route('clients.edit', $client) }}" class="btn btn-sm btn-outline-primary rounded">Update</a>
                            <form action="{{ route('clients.destroy', $client) }}" class="" method="POST" onsubmit="return confirm('Are you sure you want to delete this client?')">
                               @csrf
                               @method('DELETE')
                               <input type="submit" class="btn btn-sm btn-outline-danger rounded" value="Delete">
                            </form>
                    </div>
                </td>
            </tr>
                @empty
                <tr>
                    <td colspan="5" align="center"><h4>No Clients</h4></td>
                </tr>

            @endforelse
        </tbody>
    </table>
@endsection
