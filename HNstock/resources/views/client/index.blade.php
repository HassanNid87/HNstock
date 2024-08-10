@extends('base')

@section('title', 'Clients')

@section('content')
<div class="container my-5">
    <div class="card">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Client List</h5>
            <a href="{{ route('clients.create') }}" class="btn btn-light">
                <i class="fas fa-plus"></i>
            </a>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr align="center">
                        <th>Name</th>
                        <th>Tel</th>
                        <th>Email</th>
                        <th>Photo</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($clients as $client)
                        <tr align="center">
                            <td>{{ $client->name }}</td>
                            <td>{{ $client->tel }}</td>
                            <td>{{ $client->email }}</td>
                            <td>
                                @if ($client->photo)
                                    <img width="50px" height="50px" src="{{ asset('storage/' . $client->photo) }}" alt="Client Photo">
                                @else
                                    <img width="50px" height="50px" src="{{ asset('images/default.png') }}" alt="Default Photo">
                                @endif
                            </td>
                            <td>
                                <div class="btn-group gap-2">
                                    <a href="{{ route('clients.edit', $client) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('clients.destroy', $client) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this client?')" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" align="center"><h4>No Clients</h4></td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
