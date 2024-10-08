@extends('base')
@section('title', ($isUpdate ? 'Update' : 'Create') . ' Sale')

@php
    $route = route('sales.store');
    if ($isUpdate) {
        $route = route('sales.update', $sale);
    }

    if (!function_exists('getProductImage')) {
        function getProductImage($product): string
        {
            return $product ? '/storage/' . $product->image : '';
        }
    }
@endphp


@section('style')
    <style>
        .product-image {
            width: 2rem;
            margin: auto;
        }
    </style>
@endsection


@section('content')

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">{{ $isUpdate ? 'Editer Une Vente' : 'Ajouter Une Vente' }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Ventes</a></li>
                        <li class="breadcrumb-item active">{{ $isUpdate ? 'Editer Une Vente' : 'Ajouter Une Vente' }}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <form action="{{ $route }}" method="POST" id="saleForm" enctype="multipart/form-data">
        @csrf

        @if ($isUpdate)
            @method('PUT')
        @endif
        <div class="row">

            <div class="col-lg-12">
                <div id="addproduct-accordion" class="custom-accordion">
                    <div class="card">
                        <a href="#addproduct-billinginfo-collapse" class="text-dark" data-bs-toggle="collapse"
                           aria-expanded="true" aria-controls="addproduct-billinginfo-collapse">
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
                                        <p class="text-muted text-truncate mb-0">Remplissez toutes les informations
                                            ci-dessous</p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <i class="mdi mdi-chevron-up accor-down-icon font-size-24"></i>
                                    </div>

                                </div>

                            </div>
                        </a>

                        <div id="addproduct-billinginfo-collapse" class="collapse show"
                             data-bs-parent="#addproduct-accordion">
                            <div class="p-4 border-top">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="NFact" class="form-label">NFact</label>
                                            <input type="text" name="NFact" id="NFact" class="form-control"
                                                   value="{{ old('NFact', $sale->NFact) }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="DateFact" class="form-label">DateFact</label>
                                            <input type="date" name="DateFact" id="DateFact" class="form-control"
                                                   value="{{ $sale->DateFact ?? date('Y-m-d') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="client_id" class="form-label">Client</label>
                                            <select name="client_id" id="client_id" class="form-select">
                                                <option value="">Sélectionnez un client</option>
                                                @foreach ($clients as $client)
                                                    <option
                                                        @selected(old('client_id', $sale->client_id) == $client->id) value="{{ $client->id }}">
                                                        {{ $client->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <!--   </form>-->
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="card">
                        <a href="#addproduct-img-collapse" class="text-dark collapsed" data-bs-toggle="collapse"
                           aria-haspopup="true" aria-expanded="false" aria-controls="addproduct-img-collapse">
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
                                        <h5 class="font-size-16 mb-1">Lignes Facture</h5>
                                        <p class="text-muted text-truncate mb-0">ajouter et gérer les produits de la
                                            facture</p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <i class="mdi mdi-chevron-up accor-down-icon font-size-24"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <div id="addproduct-img-collapse" class="collapse" data-bs-parent="#addproduct-accordion">
                            <div class="p-4 border-top">
                                <form action="#" class="dropzone dz-clickable">
                                    <div class="dz-message needsclick">
                                        <!-- table ligne facture -->
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>Code Barre</th>
                                                <th>Categorie</th>
                                                <th>Product</th>
                                                <th>Image</th>
                                                <th>Quantity</th>
                                                <th>Unit Price</th>
                                                <th>Total</th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody id="sales-table-body">
                                            @foreach ($sale->details as $index => $detail)
                                                <tr class="sale-row" data-index="{{ $index }}">
                                                    <td>
                                                        <input type="text" name="barcode[]" class="form-control barcode"
                                                               value="{{ $detail->barcode }}"
                                                               placeholder="Enter Barcode">
                                                    </td>
                                                    <td>
                                                        <select name="category_id[]" class="form-select category-select"
                                                                data-index="{{ $index }}">
                                                            <option value="">Select Category</option>
                                                            @foreach ($categories as $category)
                                                                <option
                                                                    @selected($detail->product && $detail->product->category_id == $category->id) value="{{ $category->id }}">
                                                                    {{ $category->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select name="product_id[]" class="form-select product-select"
                                                                data-index="{{ $index }}">
                                                            <option value="">Select Product</option>
                                                            @foreach ($products as $product)
                                                                <option
                                                                    @selected($detail->product_id == $product->id) data-price="{{ $product->priceV }}"
                                                                    data-category="{{ $product->category_id }}"
                                                                    value="{{ $product->id }}">
                                                                    {{ $product->name }}</option>
                                                            @endforeach
                                                        </select>

                                                    </td>
                                                    <td class="text-center">
                                                        <img src="{{ getProductImage($detail->product) }}"
                                                             class="product-image"
                                                             data-index="{{ $index }}" style="max-width: 100px;">
                                                    </td>
                                                    <td>
                                                        <input type="number" name="quantity[]" min="1"
                                                               class="form-control quantity"
                                                               value="{{ $detail->quantity }}">
                                                    </td>
                                                    <td>
                                                        <input type="number" name="unit_price[]"
                                                               class="form-control unit-price" step="0.01"
                                                               value="{{ $detail->unit_price }}">
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control total" name="total[]"
                                                               value="{{ $detail->total }}" step="0.01" readonly>
                                                    </td>
                                                    <td>
                                                        <button
                                                            @disabled($index === 0) class="btn btn-danger btn-rounded delete-product"
                                                            type="button">
                                                            <i class="uil uil-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>


                                        </table>

                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <!-- Bouton pour ajouter une nouvelle ligne -->
                                                <button type="button" id="add-sale-row" class="btn btn-primary">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="stockmax" class="form-label">Montant HT</label>
                                                <input type="number" name="mht" id="mht" class="form-control"
                                                       value="{{ old('mht', $sale->mht) }}" step="0.01" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <!--   </form>-->
                            </div>

                        </div>
                    </div>

                    <div class="card">
                        <a href="#addproduct-metadata-collapse" class="text-dark collapsed" data-bs-toggle="collapse"
                           aria-haspopup="true" aria-expanded="false" aria-controls="addproduct-metadata-collapse">
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
                                        <h5 class="font-size-16 mb-1">Montants Totaux</h5>
                                        <p class="text-muted text-truncate mb-0">les montants totaux calculés pour la
                                            facture</p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <i class="mdi mdi-chevron-up accor-down-icon font-size-24"></i>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <div id="addproduct-metadata-collapse" class="collapse" data-bs-parent="#addproduct-accordion">
                            <div class="p-4 border-top">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="ttva" class="form-label">Taux Tva</label>
                                            <input type="number" name="ttva" value="0" id="ttva"
                                                   class="form-control"
                                                   value="{{ old('ttva', $sale->ttva) }}" step="0.01">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="mtva" class="form-label">Montant TVA</label>
                                            <input type="number" name="mtva" id="mtva" class="form-control"
                                                   value="{{ old('mtva', $sale->mtva) }}" step="0.01">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="tremise" class="form-label">Taux Remise</label>
                                            <input type="number" name="tremise" id="tremise" value="0"
                                                   class="form-control"
                                                   value="{{ old('tremise', $sale->tremise) }}" step="0.01">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="mremise" class="form-label">Montant Remise</label>
                                            <input type="number" name="mremise" id="mremise" class="form-control"
                                                   value="{{ old('mremise', $sale->mremise) }}" step="0.01">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3">
                                        <label for="mttc" class="form-label">Montant TTC</label>
                                        <input type="number" name="mttc" id="mttc" class="form-control"
                                               value="{{ old('mttc', $sale->mttc) }}" step="0.01" readonly>
                                    </div>
                                </div>

                                <!-- Champs "Avance" et "Notes" -->
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="avance" class="form-label">Avance</label>
                                            <input type="number" name="avance" id="avance" class="form-control"
                                                   value="{{ old('avance', $sale->avance) }}" step="0.01">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="notes" class="form-label">Notes</label>
                                            <textarea name="notes" id="notes" rows="1"
                                                      class="form-control">{{ old('notes', $sale->notes) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <!-- Fin des champs "Avance" et "Notes" -->
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col ms-auto">
                            <div class="d-flex flex-reverse flex-wrap gap-2">
                                <a href="{{ route('sales.index') }}" class="btn btn-secondary" title="Liste Factures">
                                    <i class="fas fa-list"></i>
                                </a>

                                <a href="#" class="btn btn-danger"> <i class="uil uil-times"></i> Cancel </a>

                                <button type="submit" class="btn btn-success">
                                    <i class="uil uil-file-alt"></i>
                                    {{ $isUpdate ? 'Update' : 'Create' }}
                                </button>
                            </div>
                        </div> <!-- end col -->
                    </div>
                </div>
            </div>
        </div>
    </form>



    <script>
        const productsImages = @json($products->keyBy('id')->map(fn($item) => $item->image));

        // document.addEventListener('DOMContentLoaded', function () {
        //     const toggleButton = document.getElementById('toggle-amounts');
        //     const additionalAmounts = document.getElementById('additional-amounts');
        //
        //     toggleButton.addEventListener('click', function () {
        //         if (additionalAmounts.style.display === 'none') {
        //             additionalAmounts.style.display = 'block';
        //             toggleButton.innerHTML = '<i class="fas fa-minus"></i> '; // Change the button text
        //         } else {
        //             additionalAmounts.style.display = 'none';
        //             toggleButton.innerHTML = '<i class="fas fa-plus"></i> '; // Change the button text
        //         }
        //     });
        // });


        // Initialiser le tableau lors du chargement du document
        $(document).ready(function () {
            $('#sales-table-body tr').each(function () {
                updateTotal(this);
            });
            calculateSummary();
        });


        // Fonction pour mettre à jour le total d'une ligne
        function updateTotal(row) {
            var quantity = $(row).find('.quantity').val();
            var unitPrice = $(row).find('.unit-price').val();
            var total = quantity * unitPrice;
            $(row).find('.total').val(total.toFixed(2));
        }

        // Fonction pour réinitialiser une ligne
        function resetRow(row) {
            $(row).find('.quantity').val(1);
            $(row).find('.unit-price').val(0);
            updateTotal(row);
            calculateSummary(); // Recalculate summary when resetting a row
        }

        // Fonction pour calculer le résumé
        function calculateSummary() {
            var totalHT = 0;
            $('#sales-table-body tr').each(function () {
                var total = parseFloat($(this).find('.total').val()) || 0;
                totalHT += total;
            });

            $('#mht').val(totalHT.toFixed(2));

            var tvaRate = parseFloat($('#ttva').val()) || 0;
            var remiseRate = parseFloat($('#tremise').val()) || 0;

            var mtva = (totalHT * tvaRate / 100).toFixed(2);
            $('#mtva').val(mtva);

            var remise = (totalHT * remiseRate / 100).toFixed(2);
            $('#mremise').val(remise);

            var totalTTC = (totalHT + parseFloat(mtva) - parseFloat(remise)).toFixed(2);
            $('#mttc').val(totalTTC);

            var montantRestant = parseFloat(totalTTC);
            $('#montant_restant').val((montantRestant ?? 0).toFixed(2));
        }

        // Ajouter une nouvelle ligne de vente
        $('#add-sale-row').click(function () {
            const totalRows = $(".sale-row").length;
            const newRowIndex = totalRows + 1;
            const newRow = $('.sale-row')
                .first()
                .clone()
                .removeAttr('id')
                .removeAttr('style')
                .attr('data-index', newRowIndex);

            const deleteBtn = newRow
                .children('td')
                .last()
                .children('.delete-product');
            deleteBtn.removeAttr("disabled");

            const categorySelect = newRow
                .children("td")
                .eq(1)
                .children('.category-select');
            categorySelect.attr('data-index', newRowIndex);

            const productSelect = newRow
                .children("td")
                .eq(2)
                .children('.product-select');
            productSelect.attr('data-index', newRowIndex);

            $('#sales-table-body').append(newRow);
            resetRow(newRow);
        });

        $("#sales-table-body").on("click", ".delete-product", function (e) {
            e.preventDefault();
            const yes = confirm("are you sure you want to delete this item ?");
            if (!yes) return;

            const elem = $(this).parents('.sale-row');
            if (!elem) return;

            elem.remove();
        });

        // Lorsqu'un champ de quantité ou de prix unitaire change, mettez à jour le total et le résumé
        $(document).on('input', '.quantity, .unit-price, #ttva, #tremise', function () {
            var row = $(this).closest('tr');
            updateTotal(row);
            calculateSummary();
        });

        // Lorsque la sélection du produit change
        $(document).on('change', '.product-select', function () {
            const row = $(this).closest('tr');
            var price = $(this).find('option:selected').data('price'); // Obtenez le prix du produit sélectionné
            row.find('.unit-price').val(price); // Définissez le prix dans la zone de prix

            updateTotal(row);
            calculateSummary();
        });

        // Lorsqu'un champ de quantité ou de prix unitaire change, mettez à jour le total
        $(document).on('input', '.quantity, .unit-price', function () {
            var row = $(this).closest('tr');
            var quantity = parseFloat(row.find('.quantity').val());
            var unitPrice = parseFloat(row.find('.unit-price').val());
            var total = isNaN(quantity) || isNaN(unitPrice) ? 0 : (quantity * unitPrice);
            row.find('.total').val(total.toFixed(2)); // Mettre à jour le total
        });

        $(document).ready(function () {
            // Fonction pour mettre à jour l'image du produit
            function updateProductImage(selectElement) {
                var selectedOption = $(selectElement).find('option:selected');
                var imageUrl = productsImages[$(selectElement).val()];

                var index = $(selectElement).data('index');
                var imageElement = $(`.sale-row[data-index="${index}"] img.product-image`);

                if (imageUrl) {
                    imageElement.attr('src', "/storage/" + imageUrl + "?time=" + Math.random());
                } else {
                    imageElement.attr('src', ''); // Optionnel: Afficher une image par défaut ou vider l'image
                }
            }

            // Lorsqu'un produit est sélectionné, mettez à jour l'image
            $(document).on('change', '.product-select', function () {
                console.log(this);

                updateProductImage(this);
            });

            // Initialiser les images au chargement
            // $('.product-select').each(function() {
            //     updateProductImage(this);
            // });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Fonction pour mettre à jour les produits dans une ligne en fonction de la catégorie sélectionnée
            function updateProductsByCategory(index) {
                var selectedCategory = $(`.category-select[data-index="${index}"]`).val();
                var productSelect = $(`.product-select[data-index="${index}"]`);


                productSelect.find('option').each(function () {
                    var optionCategory = $(this).data('category');
                    if (selectedCategory === '' || optionCategory == selectedCategory) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });

                // Sélectionner le premier produit si possible
                if (productSelect.find('option:visible').length > 0) {
                    productSelect.val(productSelect.find('option:visible').first().val()).change();
                }
            }

            // Lorsqu'une catégorie est sélectionnée dans une ligne, mettez à jour les produits
            $(document).on('change', '.category-select', function () {
                var index = $(this).data('index');

                updateProductsByCategory(index);
            });

            // Fonction pour mettre à jour l'image du produit
            function updateProductImage(index) {
                var selectedOption = $(`.product-select[data-index="${index}"]`).find('option:selected');
                var imageUrl = selectedOption.data('image');
                var imageElement = $(`img.product-image[data-index="${index}"]`);

                if (imageUrl) {
                    imageElement.attr('src', 'storage/' + imageUrl);
                } else {
                    imageElement.attr('src', ''); // Optionnel: Afficher une image par défaut ou vider l'image
                }
            }

            // Lorsqu'un produit est sélectionné, mettez à jour l'image
            $(document).on('change', '.product-select', function () {
                var index = $(this).data('index');
                updateProductImage(index);
            });

            // Initialiser les produits et images pour chaque ligne au chargement
            $('.category-select').each(function () {
                var index = $(this).data('index');
                updateProductsByCategory(index);
            });
            // $('.product-select').each(function () {
            //     var index = $(this).data('index');
            //     updateProductImage(index);
            // });
        });


        const submitBtn = $("#saleForm button[type='submit']");
        const alertBox = $('<div class="alert alert-danger validation-errors fade show" role="alert">' +
            '<div class="error-messages"></div>' +
            '</div>').hide();

        $("#formContainer").prepend(alertBox);

        $("#saleForm").on('submit', function (e) {
            e.preventDefault();

            submitBtn.attr("disabled", "disabled").html("Saving...");
            alertBox.hide().find('.error-messages').html(''); // Clear previous errors

            $.ajax({
                type: 'POST',
                url: '{{ $route }}',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    submitBtn.removeAttr("disabled").html("Save");
                    // Handle successful form submission (e.g., redirect or show a success message)
                    location.href = "{{ route('sales.index') }}";
                },
                error: function (xhr) {
                    submitBtn.removeAttr("disabled").html("Save");

                    if (xhr.status === HTTP_STATUS.UNPROCESSABLE_CONTENT) {
                        // Laravel validation error
                        const errors = xhr.responseJSON.errors;
                        let errorHtml = '';

                        $.each(errors, function (key, value) {
                            errorHtml += '<p>' + value[0] + '</p>';
                        });

                        alertBox.find('.error-messages').html(errorHtml);
                        alertBox.show();

                        $("html, body").animate({
                            scrollTop: 0
                        }, 500)
                    } else {
                        alert("Sorry, an unexpected error occurred.");
                    }
                }
            });
        });
    </script>

@endsection
