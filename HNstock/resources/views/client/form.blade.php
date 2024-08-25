@extends('base')

@section('title', ($isUpdate ? 'Update' : 'Create') . ' Client')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0">{{ $isUpdate ? 'Editer Un Client' : 'Ajouter Un Client' }}</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Clients</a></li>
                    <li class="breadcrumb-item active">{{ $isUpdate ? 'Editer Un Client' : 'Ajouter Un Client' }}</li>
                </ol>
            </div>

        </div>
    </div>
<div class="row">
    <!-- Première carte : Code, Nom, Adresse, Type -->
    <div class="card">
        <a href="#client-info-collapse" class="text-dark" data-bs-toggle="collapse" aria-expanded="true" aria-controls="client-info-collapse">
            <div class="p-4">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <div class="avatar-xs">
                            <div class="avatar-title rounded-circle bg-soft-primary text-primary">
                                01
                            </div>
                        </div>
                    </div>
                    <div class="flex-grow-1 overflow-hidden">
                        <h5 class="font-size-16 mb-1">Informations de Base</h5>
                        <p class="text-muted text-truncate mb-0">Remplissez les informations principales du client</p>
                    </div>
                    <div class="flex-shrink-0">
                        <i class="mdi mdi-chevron-down accor-down-icon font-size-24"></i>
                    </div>
                </div>
            </div>
        </a>
        <div id="client-info-collapse" class="collapse show" data-bs-parent="#addproduct-accordion">
            <div class="p-4 border-top">
                <form action="{{ $isUpdate ? route('clients.update', $client) : route('clients.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if ($isUpdate)
                        @method('PUT')
                    @endif
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="code" class="form-label">Code</label>
                                <input type="text" name="code" id="code" class="form-control" value="{{ old('code', $client->code) }}">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">Nom</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $client->name) }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="adresse" class="form-label">Adresse</label>
                                <input type="text" name="adresse" id="adresse" class="form-control" value="{{ old('adresse', $client->adresse) }}">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="type" class="form-label">Type</label>
                                <select name="type" id="type" class="form-control">
                                    <option value="">Sélectionner un type</option>
                                    <option value="Société" {{ old('type', $client->type) == 'Société' ? 'selected' : '' }}>Société</option>
                                    <option value="Individuel" {{ old('type', $client->type) == 'Individuel' ? 'selected' : '' }}>Individuel</option>
                                </select>
                            </div>
                        </div>

                    </div>
            </div>
        </div>
    </div>

    <!-- Deuxième carte : Téléphone, WhatsApp, Email, Site Web -->
    <div class="card mt-4">
        <a href="#client-contact-collapse" class="text-dark" data-bs-toggle="collapse" aria-expanded="false" aria-controls="client-contact-collapse">
            <div class="p-4">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <div class="avatar-xs">
                            <div class="avatar-title rounded-circle bg-soft-primary text-primary">
                                02
                            </div>
                        </div>
                    </div>
                    <div class="flex-grow-1 overflow-hidden">
                        <h5 class="font-size-16 mb-1">Informations de Contact</h5>
                        <p class="text-muted text-truncate mb-0">Informations de contact du client</p>
                    </div>
                    <div class="flex-shrink-0">
                        <i class="mdi mdi-chevron-down accor-down-icon font-size-24"></i>
                    </div>
                </div>
            </div>
        </a>
        <div id="client-contact-collapse" class="collapse" data-bs-parent="#addproduct-accordion">
            <div class="p-4 border-top">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="tel" class="form-label">Téléphone</label>
                            <input type="text" name="tel" id="tel" class="form-control" value="{{ old('tel', $client->tel) }}">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="whatsapp" class="form-label">WhatsApp</label>
                            <input type="text" name="whatsapp" id="whatsapp" class="form-control" value="{{ old('whatsapp', $client->whatsapp) }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $client->email) }}">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="siteweb" class="form-label">Site Web</label>
                            <input type="url" name="siteweb" id="siteweb" class="form-control" value="{{ old('siteweb', $client->siteweb) }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Troisième carte : Photo, Solde-Max -->
    <div class="card mt-4">
        <a href="#client-extra-collapse" class="text-dark" data-bs-toggle="collapse" aria-expanded="false" aria-controls="client-extra-collapse">
            <div class="p-4">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <div class="avatar-xs">
                            <div class="avatar-title rounded-circle bg-soft-primary text-primary">
                                03
                            </div>
                        </div>
                    </div>
                    <div class="flex-grow-1 overflow-hidden">
                        <h5 class="font-size-16 mb-1">Informations Supplémentaires</h5>
                        <p class="text-muted text-truncate mb-0">Ajoutez la photo et le solde maximum</p>
                    </div>
                    <div class="flex-shrink-0">
                        <i class="mdi mdi-chevron-down accor-down-icon font-size-24"></i>
                    </div>
                </div>
            </div>
        </a>
        <div id="client-extra-collapse" class="collapse" data-bs-parent="#addproduct-accordion">
            <div class="p-4 border-top">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="photo" class="form-label">Photo</label>
                            <input type="file" name="photo" id="photo" class="form-control">
                            <div id="photo-preview" class="mt-2" style="{{ !$client->photo ? 'display:none;' : '' }}">
                                @if ($client->photo)
                                    <img width="100" src="{{ asset('storage/' . $client->photo) }}" alt="Client Photo" id="photo-preview-img">
                                @else
                                    <img width="100" src="" alt="Client Photo" id="photo-preview-img" style="display:none;">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="soldemax" class="form-label">Solde-Max</label>
                            <input type="number" name="soldemax" id="soldemax" class="form-control" step="0.01" value="{{ old('soldemax', $client->soldemax) }}">
                        </div>
                    </div>
                </div>
                <div class="row">

                        <div class="mb-0">
                            <label for="Notes" class="form-label">Notes</label>
                            <textarea name="description" id="description" placeholder="Notes" class="form-control"></textarea>
                        </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Bouton Create/Update placé en dehors des cartes -->
    <div class="form-group mt-4">
        <button type="submit" class="btn btn-primary btn-sm">
            <i class="fas fa-save fa-sm"></i> {{ $isUpdate ? 'Update' : 'Create' }}
        </button>
    </div>
</div>
<br>
<script>
    document.getElementById('photo').addEventListener('change', function(event) {
        const preview = document.getElementById('photo-preview');
        const previewImg = document.getElementById('photo-preview-img');
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewImg.style.display = 'block';
                preview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            previewImg.src = '';
            previewImg.style.display = 'none';
            preview.style.display = 'none';
        }
    });
</script>
@endsection
