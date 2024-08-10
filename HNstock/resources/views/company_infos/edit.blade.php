<!-- resources/views/company_infos/edit.blade.php -->
@extends('base')

@section('title', 'Modifier les informations de la société')

@section('content')
    <h1>Modifier les informations de la société</h1>
    <form action="{{ route('company_infos.update', $companyInfo->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name" class="form-label">Nom de la société</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $companyInfo->name) }}">
        </div>

        <div class="form-group">
            <label for="logo" class="form-label">Logo</label>
            <input type="file" name="logo" id="logo" class="form-control">
            @if ($companyInfo->logo)
                <img src="{{ asset('storage/' . $companyInfo->logo) }}" alt="Logo actuel" width="100">
            @endif
        </div>

        <div class="form-group">
            <label for="address" class="form-label">Adresse</label>
            <input type="text" name="address" id="address" class="form-control" value="{{ old('address', $companyInfo->address) }}">
        </div>

        <div class="form-group">
            <label for="phone" class="form-label">Téléphone</label>
            <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $companyInfo->phone) }}">
        </div>

        <div class="form-group">
            <label for="fax" class="form-label">Fax</label>
            <input type="text" name="fax" id="fax" class="form-control" value="{{ old('fax', $companyInfo->fax) }}">
        </div>

        <div class="form-group">
            <label for="email" class="form-label">Email</label>
            <input type="text" name="email" id="email" class="form-control" value="{{ old('email', $companyInfo->email) }}">
        </div>

        <div class="form-group">
            <label for="website" class="form-label">Site web</label>
            <input type="text" name="website" id="website" class="form-control" value="{{ old('website', $companyInfo->website) }}">
        </div>

        <div class="form-group">
            <label for="patente" class="form-label">Patente</label>
            <input type="text" name="patente" id="patente" class="form-control" value="{{ old('patente', $companyInfo->patente) }}">
        </div>

        <br>

        <div class="form-group my-3">
            <input type="submit" class="btn btn-primary w-100" value="Modifier">
        </div>
    </form>
@endsection
