@extends('base')
@section('title' , 'Clients')

@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Clients : {{$client->name}} </h1>
        <a href="{{route('clients.index')}}" class="btn btn-primary">Go Back</a>
    </div>
    <table class="table">
        <thead class="">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Update Product</th>
            </tr>
        </thead>
        <tbody>
         @forelse ($sales as $sale)
         <tr>
                <td>{{$sale->id}}</td>
                <td>{{$sale->NFact}}</td>

                <td>
                  <div class="btn-group gap-2">
                        <a href="{{ route('sales.edit', $sale) }}" class="btn btn-primary" >Update</a>
                  </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" align="center"><h6>No Sale for this client</h6></td>
            </tr>
         @endforelse

        </tbody>
    </table>
@endsection
