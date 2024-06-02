@extends('base')

@section('title',($isUpdate?'Update':'Create') . ' Client')

@php
    $route = route('clients.store');
    if ($isUpdate) {
        $route = route('clients.update', $client);
            }
@endphp
@section('content')
    <h1>@yield('title')</h1>
    <form action="{{ $route }}" method="POST" class="" enctype="multipart/form-data">
        @csrf
        @if($isUpdate)
        @method('PUT')
        @endif

         <div class="form-group">
             <label for="name" class="form-label">Name</label>
             <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $client->name) }}">
         </div>
         <div class="form-group">
             <label for="tel" class="form-label">Tel</label>
             <input type="text" name="tel" id="tel" class="form-control" value="{{ old('tel', $client->tel) }}">
         </div>
         <div class="form-group">
             <label for="email" class="form-label">Email</label>
             <input type="text" name="email" id="email" class="form-control" value="{{ old('email', $client->email) }}">
                @if ($client)
                <img width="100" src="/storage/{{ $client->photo }}" alt="" class="">
                @endif
            </div>
         <div class="form-group">
             <label for="photo" class="form-label">Photo</label>
             <input type="file" name="photo" id="photo" class="form-control">
         </div>
         <br>
         <div class="form-group my-3">
             <input type="submit"  class="btn btn-primary w-100" value="{{ $isUpdate?'Edit': 'Create' }}">
         </div>

     </form>

@endsection


