{{-- resources/views/categories/index.blade.php --}}
@extends('base')

@section('title', 'Category')

<style>
    .table {
        margin: 20px 0;
        width: 100%;
        text-align: center;
        border-collapse: collapse;
    }

    .table thead {
        background-color: #343a40;
        color: white;
    }

    .table tbody tr:hover {
        background-color: #f5f5f5;
    }

    .table td,
    .table th {
        padding: 10px;
        vertical-align: middle;
        border: 1px solid #ddd;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f2f2f2;
    }

    .table-hover tbody tr:hover {
        background-color: #e9ecef;
    }

    .table th {
        font-weight: bold;
    }

    .table td {
        font-size: 14px;
    }

    .btn-group .btn {
        margin-right: 5px;
    }
</style>

@section('content')
    <div class="container my-5">
        <div class="card">
            @include('category.inc.category-modal')

            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Liste Categories </h5>
                <span role="button" href="{{ route('categories.create') }}" id="openAddForm" class="btn btn-light">+</span>
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
                                        <a href="{{ route('categories.show', $category) }}">
                                            <span class="btn btn-sm btn-outline-info rounded" title="Show">
                                                <i class="fas fa-eye"></i>
                                            </span>
                                        </a>
                                        <a href="{{ route('categories.edit', $category) }}" >
                                           <span class="btn btn-sm btn-outline-info rounded" title="Update"> <i class="fas fa-edit"></i></span>
                                        </a>

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

        $("#openAddForm").click(function() {
            openForm('', '');
        });


        $(".edit-category").click(function() {
            const name = $(this).data("name");
            const id = $(this).data("id");

            openForm(name, id);
        });


        $("#categoryNameForm").submit(function(e) {
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
                success: function() {
                    closeError();
                    submitBtn.removeAttr('disabled').html("save");
                    location.reload();
                },
                error: function(error) {
                    submitBtn.removeAttr('disabled').html("save");

                    if(error.status === HTTP_STATUS.CREATED) {
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
