@extends('base')
@section('title', ($isUpdate ? 'Update' : 'Create') . ' Sale')

@php
    $route = route('sales.store');
    if ($isUpdate) {
        $route = route('sales.update', $sale);
    }
@endphp
@section('content')
<div class="card m-3 p-3">
    <div class="card-header bg-primary text-white">
        <h1>@yield('title')</h1>
    </div>

    <form action="{{ $route }}" method="POST" enctype="multipart/form-data">
        @csrf

        @if ($isUpdate)
            @method('PUT')
        @endif

        <!-- Champ NFact en lecture seule -->
        <div class="form-group">
            <label for="NFact" class="form-label">NFact</label>
            <input type="text" name="NFact" id="NFact" class="form-control" value="{{ old('NFact', $sale->NFact) }}" readonly>

        </div>
        <div class="form-group">
            <label for="DateFact" class="form-label">DateFact</label>
            <input type="date" name="DateFact" id="DateFact" class="form-control" value="{{ $sale->DateFact ?? date('Y-m-d') }}">
        </div>

        <div class="form-group">
            <label for="client_id" class="form-label">Client</label>
            <select name="client_id" id="client_id" class="form-select">
                <option value="">Please choose client</option>
                @foreach ($clients as $client)
                    <option @if (old('client_id', $sale->client_id) == $client->id) selected @endif value="{{ $client->id }}">{{ $client->name }}</option>
                @endforeach
            </select>
        </div>

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
                @foreach($sale->details as $index => $detail)
                <tr class="sale-row">
                    <td>
                        <input type="text" name="barcode[]" class="form-control barcode" value="{{ $detail->barcode }}" placeholder="Enter Barcode">
                    </td>
                    <td>
                        <select name="category_id[]" class="form-select category-select" data-index="{{ $index }}">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option @if($detail->product && $detail->product->category_id == $category->id) selected @endif value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select name="product_id[]" class="form-select product-select" data-index="{{ $index }}">
                            <option value="">Select Product</option>
                            @foreach($products as $product)
                                <option @selected($detail->product_id == $product->id) data-price="{{ $product->priceV }}" data-category="{{ $product->category_id }}" value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>

                    </td>
                    <td>
                        <img src="{{ $detail->product ? 'storage/' . $detail->product->image : '' }}" class="product-image" data-index="{{ $index }}" style="max-width: 100px;">
                    </td>
                    <td>
                        <input type="number" name="quantity[]" class="form-control quantity" value="{{ $detail->quantity }}">
                    </td>
                    <td>
                        <input type="number" name="unit_price[]" class="form-control unit-price" step="0.01" value="{{ $detail->unit_price }}">
                    </td>
                    <td>
                        <input type="number" class="form-control total" name="total[]" value="{{ $detail->total }}" step="0.01" readonly>
                    </td>
                    <td>
                        <button @disabled($index === 0) class="btn btn-danger btn-rounded delete-product" type="button">
                            <i class="uil uil-trash"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>


        </table>

        <!-- Bouton pour ajouter une nouvelle ligne -->
        <button type="button" id="add-sale-row" class="btn btn-primary">
            <i class="fas fa-plus"></i>
        </button>

        <br>

        <div class="form-group row">
            <label for="mht" class="form-label col-sm-3 col-form-label m-1 p-1">Montant HT</label>
            <div class="col-sm-3 d-flex justify-content-end m-1 p-1">
                <input type="number" name="mht" id="mht" class="form-control" value="{{ old('mht', $sale->mht) }}" step="0.01">
                <!-- Button to toggle visibility -->
                <button type="button" id="toggle-amounts" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i>
                </button>
            </div>

        </div>



        <!-- Sections to hide/show -->
        <div id="additional-amounts" style="display: none;">
            <div class="form-group row">
                <label for="ttva" class="form-label col-sm-3 col-form-label m-1 p-1">T-TVA</label>
                <div class="col-sm-3 d-flex justify-content-end m-1 p-1">
                    <input type="number" name="ttva" id="ttva" class="form-control" value="{{ old('ttva', $sale->ttva) }}" step="0.01">
                </div>
            </div>
            <div class="form-group row">
                <label for="mtva" class="form-label col-sm-3 col-form-label m-1 p-1">M-TVA</label>
                <div class="col-sm-3 d-flex justify-content-end m-1 p-1">
                    <input type="number" name="mtva" id="mtva" class="form-control" value="{{ old('mtva', $sale->mtva) }}" step="0.01">
                </div>
            </div>
            <div class="form-group row">
                <label for="tremise" class="form-label col-sm-3 col-form-label m-1 p-1">TRemise</label>
                <div class="col-sm-3 d-flex justify-content-end m-1 p-1">
                    <input type="number" name="tremise" id="tremise" class="form-control" value="{{ old('tremise', $sale->tremise) }}" step="0.01">
                </div>
            </div>
            <div class="form-group row">
                <label for="mremise" class="form-label col-sm-3 col-form-label m-1 p-1">Remise</label>
                <div class="col-sm-3 d-flex justify-content-end m-1 p-1">
                    <input type="number" name="mremise" id="mremise" class="form-control" value="{{ old('mremise', $sale->mremise) }}" step="0.01">
                </div>
            </div>
            <div class="form-group row">
                <label for="mttc" class="form-label col-sm-3 col-form-label m-1 p-1">Montant TTC</label>
                <div class="col-sm-3 d-flex justify-content-end m-1 p-1">
                    <input type="number" name="mttc" id="mttc" class="form-control" value="{{ old('mttc', $sale->mttc) }}" step="0.01">
                </div>
            </div>
        </div>


        <br>
        <br>

        <div class="form-group">
            <a href="{{ route('sales.index') }}" class="btn btn-secondary" title="Liste Factures">
                <i class="fas fa-list"></i>
            </a>
            <input type="submit" class="btn btn-primary w-10" value="{{ $isUpdate ? 'Edit' : 'Create' }}">
        </div>
    </form>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleButton = document.getElementById('toggle-amounts');
        const additionalAmounts = document.getElementById('additional-amounts');

        toggleButton.addEventListener('click', function () {
            if (additionalAmounts.style.display === 'none') {
                additionalAmounts.style.display = 'block';
                toggleButton.innerHTML = '<i class="fas fa-minus"></i> '; // Change the button text
            } else {
                additionalAmounts.style.display = 'none';
                toggleButton.innerHTML = '<i class="fas fa-plus"></i> '; // Change the button text
            }
        });
    });


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
            $(row).find('.quantity').val(0);
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
        }

        // Ajouter une nouvelle ligne de vente
        $('#add-sale-row').click(function () {
            const newRow = $('.sale-row').first().clone().removeAttr('id').removeAttr('style');
            const deleteBtn = newRow
                .children('td')
                .last()
                .children('.delete-product');
            deleteBtn.removeAttr("disabled");

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
            var price = $(this).find('option:selected').data('price'); // Obtenez le prix du produit sélectionné
            console.log(price);
            $(this).closest('tr').find('.unit-price').val(price); // Définissez le prix dans la zone de prix
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
        var imageUrl = selectedOption.data('image');
        var index = $(selectElement).data('index');
        var imageElement = $(`img.product-image[data-index="${index}"]`);

        if (imageUrl) {
            imageElement.attr('src', 'storage/' + imageUrl);
        } else {
            imageElement.attr('src', ''); // Optionnel: Afficher une image par défaut ou vider l'image
        }
    }

    // Lorsqu'un produit est sélectionné, mettez à jour l'image
    $(document).on('change', '.product-select', function () {
        updateProductImage(this);
    });

    // Initialiser les images au chargement
    $('.product-select').each(function () {
        updateProductImage(this);
    });
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
        $('.product-select').each(function () {
            var index = $(this).data('index');
            updateProductImage(index);
        });
    });
</script>


@endsection
