@extends('base')

@section('title', 'Liste des Catégories')

@section('content')
<div class="container my-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Liste des Catégories</h5>
            <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                Nouvelle Catégorie
            </button>
        </div>

        <div class="card-body p-4">
            <table class="table table-bordered table-striped table-hover">
                <thead class="table-dark" align="center">
                    <tr>
                        <th>Nom</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody align="center">
                    @forelse ($categories as $category)
                        <tr>
                            <td>{{ $category->name }}</td>
                            <td>
                                <div class="btn-group gap-2">
                                    <a href="{{ route('categories.show', $category) }}" class="btn btn-sm btn-outline-info" title="Afficher">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-outline-warning" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="{{ route('categories.destroy', $category) }}" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center">
                                <em>Aucune catégorie trouvée.</em>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $categories->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>

<!-- Fenêtre modale pour ajouter une nouvelle catégorie -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryModalLabel">Ajouter une nouvelle catégorie</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="categoryForm" action="{{ route('categories.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="form-label">Nom de la catégorie</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nom de la catégorie" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#categoryForm').on('submit', function(event) {
            event.preventDefault();

            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: $(this).serialize(),
                success: function(response) {
                    // Fermer le modal et rafraîchir la liste des catégories
                    $('#addCategoryModal').modal('hide');
                    location.reload(); // Vous pouvez aussi manipuler le DOM pour ajouter la catégorie sans recharger
                },
                error: function(xhr) {
                    console.log(xhr.responseText); // Afficher les erreurs pour déboguer
                }
            });
        });
    });
</script>
@endsection
