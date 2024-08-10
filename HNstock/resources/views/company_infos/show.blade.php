<!-- resources/views/company_infos/show.blade.php -->
@extends('base')

@section('title', 'Informations de la société')

@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h1>Informations de la société</h1>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="row mb-3">
                    <div class="col-md-4"><strong>Nom de la société:</strong></div>
                    <div class="col-md-8">{{ $companyInfo->name }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Adresse:</strong></div>
                    <div class="col-md-8">{{ $companyInfo->address }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Site web:</strong></div>
                    <div class="col-md-8">{{ $companyInfo->website }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Téléphone:</strong></div>
                    <div class="col-md-8">{{ $companyInfo->phone }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Fax:</strong></div>
                    <div class="col-md-8">{{ $companyInfo->fax }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Email:</strong></div>
                    <div class="col-md-8">{{ $companyInfo->email }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Patente:</strong></div>
                    <div class="col-md-8">{{ $companyInfo->patente }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Logo:</strong></div>
                    <div class="col-md-8">
                        @if ($companyInfo->logo)
                            <img src="{{ asset('storage/' . $companyInfo->logo) }}" alt="Logo de la société" width="100">
                        @else
                            <span>Aucun logo disponible</span>
                        @endif
                    </div>
                </div>

                <a href="{{ route('company_infos.edit', $companyInfo->id) }}" class="btn btn-primary mt-3">Modifier</a>
            </div>
        </div>
    </div>
@endsection
