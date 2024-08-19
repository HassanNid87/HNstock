@extends('base')

@section('title', ($isUpdate ? 'Update' : 'Create') . ' Client')

@section('content')
<div class="container my-5">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="card-title mb-0">@yield('title')</h5>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ $isUpdate ? route('clients.update', $client) : route('clients.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if ($isUpdate)
                    @method('PUT')
                @endif
                <div class="form-group mb-3">
                    <label for="code" class="form-label">Code</label>
                    <input type="text" name="code" id="code" class="form-control" value="{{ old('code', $client->code) }}">
                </div>

                <div class="form-group mb-3">
                    <label for="name" class="form-label">Nom</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $client->name) }}">
                </div>
                <div class="form-group mb-3">
                    <label for="adresse" class="form-label">Adresse</label>
                    <input type="text" name="adresse" id="adresse" class="form-control" value="{{ old('adresse', $client->adresse) }}">
                </div>

                <div class="form-group mb-3">
                    <label for="tel" class="form-label">Tel</label>
                    <input type="text" name="tel" id="tel" class="form-control" value="{{ old('tel', $client->tel) }}">
                </div>

                <div class="form-group mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $client->email) }}">
                </div>



               <!-- <div class="form-group mb-3">
                    <label for="solde" class="form-label">Solde</label>
                    <input type="number" name="solde" id="solde" class="form-control" step="0.01" value="{{ old('solde', $client->solde) }}">
                </div>-->


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
<hr>
                <div class="form-group mb-3">
                    <label for="soldemax" class="form-label">Solde-Max</label>
                    <input type="number" name="soldemax" id="soldemax" class="form-control" step="0.01" value="{{ old('solde', $client->soldemax) }}">
                </div>
                <hr>

                <div class="form-group mb-3">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-save fa-sm"></i> {{ $isUpdate ? 'Update' : 'Create' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

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
