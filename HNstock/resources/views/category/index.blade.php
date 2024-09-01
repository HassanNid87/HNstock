@extends('base')

@section('title', 'Category')

@section('content')
    <div class="container my-5">
        <div class="card shadow-sm">
            @include('category.inc.category-modal')

            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Liste des Catégories</h5>
                <span role="button" href="{{ route('categories.create') }}" id="openAddForm"
                      class="btn btn-light">
                    Nouvelle Catégorie
                </span>
            </div>

            <div class="card-body">
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
                                    <a href="{{ route('categories.show', $category) }}"
                                       class="btn btn-sm btn-outline-info rounded" title="Afficher">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button role="button" data-name="{{ $category->name }}"
                                            data-id="{{ $category->id }}"
                                            class="btn btn-sm btn-outline-warning edit-category rounded"
                                            title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form method="POST" action="{{ route('categories.destroy', $category) }}"
                                          style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded"
                                                title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" align="center">
                                <h6>No Category.</h6>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

                {{ $categories->links() }}
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script>
        const formModal = $("#categoryForm");
        const nameInput = $("#categoryNameForm input[name='name']");
        const idInput = $("#categoryNameForm #activeCategoryId");
        const submitBtn = $("#categoryNameForm button[type='submit']")
        const categoryErrorAlert = $("#categoryNameForm #categoryErrorAlert");


        const openForm = (name, id) => {
            nameInput.val(name);
            idInput.val(id);

            formModal.modal('show');
        }

        const showError = (error) => {
            categoryErrorAlert.html(`<p class="mb-0">${error}</p>`);
            categoryErrorAlert.show();
        }

        const closeError = () => {
            categoryErrorAlert.hide();
        }

        $("#openAddForm").click(function () {
            openForm('', '');
        });


        $(".edit-category").click(function () {
            const name = $(this).data("name");
            const id = $(this).data("id");

            openForm(name, id);
        });


        $("#categoryNameForm").submit(function (e) {
            e.preventDefault();

            const name = nameInput.val();
            const id = idInput.val();

            if (isEmpty(name)) {
                return;
            }

            const route = "{{ route('categories.update', ['category' => -1]) }}";
            const method = isEmpty(id) ? "POST" : "PUT";

            submitBtn.attr('disabled', 'disabled').html("saving...")
            $.ajax(route.replace("-1", id), {
                data: {
                    name,
                    _token: "{{ csrf_token() }}",
                    _method: method
                },
                method: "POST",
                dataType: "json",
                success: function () {
                    closeError();
                    submitBtn.removeAttr('disabled').html("save");
                    location.reload();
                },
                error: function (error) {
                    submitBtn.removeAttr('disabled').html("save");

                    if (error.status === HTTP_STATUS.CREATED) {
                        location.reload();
                        return;
                    }

                    if (error.status === HTTP_STATUS.UNPROCESSABLE_CONTENT) {
                        showError(error.responseJSON.message);
                        return;
                    }
                },
            });
        });
    </script>
@endsection
