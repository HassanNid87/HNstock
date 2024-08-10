@extends('base')

@section('title', 'Home')

@section('content')
<div class="container-fluid">
    <div class="row">
        <main class="col-md-9">
            <!-- Contenu spécifique à la page d'accueil -->
            <h1>Bienvenue sur la page d'accueil</h1>
            <p>Ce projet est une application de gestion de stock.</p>

            <!-- Ajouter d'autres éléments comme des tableaux, des graphiques, etc. -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Tableau de bord</h5>
                    <p class="card-text">Des statistiques et autres informations clés peuvent être affichées ici.</p>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
