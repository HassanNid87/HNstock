@extends('base')
@section('title', ($isUpdate ? 'Update' : 'Create') . ' Sale')

@php
    $route = route('sales.store');
    if ($isUpdate) {
        $route = route('sales.update', $sale);
    }
@endphp

@section('content')
    <h1>@yield('title')</h1>

    <form action="{{ $route }}" method="POST" enctype="multipart/form-data">
        @csrf

        @if ($isUpdate)
            @method('PUT')
        @endif
        <!-- Champ NFact en lecture seule -->
        <div class="form-group">
            <label for="NFact" class="form-label">NFact</label>
            <input type="text" name="NFact" id="NFact" class="form-control" value="{{ old('NFact', $sale->NFact) }}"
                   readonly>
        </div>
        <div class="form-group">
            <label for="DateFact" class="form-label">DateFact</label>
            <input type="date" name="DateFact" id="DateFact" class="form-control"
                   value="{{ $sale->DateFact ?? date('Y-m-d') }}">
        </div>

        <div class="form-group">
            <label for="client_id" class="form-label">Client</label>
            <select name="client_id" id="client_id" class="form-select">
                <option value="">Please choose client</option>
                @foreach ($clients as $client)
                    <option @if (old('client_id', $sale->client_id) == $client->id) selected
                            @endif value="{{ $client->id }}">{{ $client->name }}</option>
                @endforeach
            </select>
        </div>
        <!-- table ligne facture -->
        <table class="table">
            <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total</th>
                <th>#</th>
            </tr>
            </thead>
            <tbody id="sales-table-body">
            @foreach($sale->details as $index => $detail)
                <tr class="sale-row">
                    <td>
                        <select name="product_id[]" class="form-select">
                            <option value="">Select Product</option>
                            @foreach($products as $product)
                                <option
                                    value="{{ $product->id }}" {{ $detail->product_id == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="number" name="quantity[]" class="form-control quantity"
                               value="{{ $detail->quantity }}">
                    </td>
                    <td>
                        <input type="number" name="unit_price[]" class="form-control unit-price"
                               value="{{ $detail->unit_price }}">
                    </td>
                    <td>
                        <input type="number" class="form-control total" name="total[]" value="{{ $detail->total }}"
                               readonly>
                    </td>
                    <td>
                        <button class="btn btn-danger btn-rounded delete-product" type="button">
                            <i class="uil uil-trash"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <!-- Bouton pour ajouter une nouvelle ligne -->
        <button type="button" id="add-sale-row" class="btn btn-primary">Add Sale Row</button>
        <!-- Bouton pour supprimer la dernière ligne -->
        {{--        <button type="button" id="remove-sale-row" class="btn btn-danger">Remove Sale Row</button>--}}

        <!-- Autres champs du formulaire -->

        <br>

        <div class="form-group">
            <label for="mht" class="form-label">Montant HT</label>
            <input type="number" name="mht" id="mht" class="form-control" value="{{ old('mht', $sale->mht) }}">
        </div>
        <div class="form-group">
            <label for="ttva" class="form-label">T-TVA</label>
            <input type="number" name="ttva" id="ttva" class="form-control" value="{{ old('ttva', $sale->ttva) }}">
        </div>

        <div class="form-group">
            <label for="mtva" class="form-label">M-TVA</label>
            <input type="number" name="mtva" id="mtva" class="form-control" value="{{ old('mtva', $sale->mtva) }}">
        </div>
        <div class="form-group">
            <label for="tremise" class="form-label">TRemise</label>
            <input type="number" name="tremise" id="tremise" class="form-control"
                   value="{{ old('tremise', $sale->tremise) }}">
        </div>

        <div class="form-group">
            <label for="mremise" class="form-label">Remise</label>
            <input type="number" name="mremise" id="mremise" class="form-control"
                   value="{{ old('mremise', $sale->mremise) }}">
        </div>

        <div class="form-group">
            <label for="mttc" class="form-label">Montant TTC</label>
            <input type="number" name="mttc" id="mttc" class="form-control" value="{{ old('mttc', $sale->mttc) }}">
        </div>

        <br>

        <div class="form-group">
            <input type="submit" class="btn btn-primary w-100" value="{{ $isUpdate ? 'Edit' : 'Create' }}">
        </div>
    </form>

    <script>

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
            var newRow = $('.sale-row').first().clone().removeAttr('id').removeAttr('style');
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

    </script>
@endsection
