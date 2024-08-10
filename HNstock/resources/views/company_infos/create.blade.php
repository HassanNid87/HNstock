<!-- resources/views/company_infos/create.blade.php -->
@extends('base')

@section('title', 'Créer les informations de la société')

@section('content')
    <h1>Créer les informations de la société</h1>
    <form action="{{ route('company_infos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="name" class="form-label">Nom de la société</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
        </div>

        <div class="form-group">
            <label for="logo" class="form-label">Logo</label>
            <input type="file" name="logo" id="logo" class="form-control">
        </div>

        <div class="form-group">
            <label for="address" class="form-label">Adresse</label>
            <input type="text" name="address" id="address" class="form-control" value="{{ old('address') }}">
        </div>

        <div class="form-group">
            <label for="phone" class="form-label">Téléphone</label>
            <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}">
        </div>

        <div class="form-group">
            <label for="fax" class="form-label">Fax</label>
            <input type="text" name="fax" id="fax" class="form-control" value="{{ old('fax') }}">
        </div>

        <div class="form-group">
            <label for="email" class="form-label">Email</label>
            <input type="text" name="email" id="email" class="form-control" value="{{ old('email') }}">
        </div>

        <div class="form-group">
            <label for="website" class="form-label">Site web</label>
            <input type="text" name="website" id="website" class="form-control" value="{{ old('website') }}">
        </div>

        <div class="form-group">
            <label for="patente" class="form-label">Patente</label>
            <input type="text" name="patente" id="patente" class="form-control" value="{{ old('patente') }}">
        </div>

        <br>

        <div class="form-group my-3">
            <input type="submit" class="btn btn-primary w-100" value="Créer">
        </div>
    </form>
@endsection
