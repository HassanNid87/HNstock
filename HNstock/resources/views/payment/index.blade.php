@extends('base')

@section('title', 'Liste des Paiements')

@section('content')
<div class="container-fluid">
    <button type="button" id="toggle-filter" class="">
        <i class="fa fa-fw fa-bars fas fa-filter"></i>
   </button>
   <br>
    <div class="row">
        <aside id="filters" class="col-md-2">
        <form method="get">
            <div class="form-group">
                <input type="text" name="Npayment" id="Npayment" class="form-control" placeholder="N° Réglément" value="{{ Request::input('Npayment') }}">
            </div>
            <br>
            <div class="form-group">
                <select name="client" id="client" class="form-control">
                    <option value="">Select Client</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}" {{ Request::input('client') == $client->id ? 'selected' : '' }}>
                            {{ $client->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <hr>
            <div class="form-group">
                <div class="form-check">
                    <input type="checkbox" name="mode_payment[]" value="espece" id="espece" class="form-check-input" {{ in_array('espece', Request::input('mode_payment', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="espece">Espèce</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" name="mode_payment[]" value="chéque" id="cheque" class="form-check-input" {{ in_array('chéque', Request::input('mode_payment', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="cheque">Chèque</label>
                </div>
            </div>
            <hr>
            <div class="form-group">
                <label for="start_date" class="form-label-sm">Start Date</label>
                <input type="date" name="start_date" id="start_date" class="form-control form-control-sm" value="{{ $startDate }}">
            </div>
            <div class="form-group">
                <label for="end_date" class="form-label-sm">End Date</label>
                <input type="date" name="end_date" id="end_date" class="form-control form-control-sm" value="{{ $endDate }}">
            </div>

            <hr>
            <div class="form-group">
                <input type="number" name="max_amount" id="max_amount" class="form-control" placeholder="Mt Max" value="{{ Request::input('max_amount') }}">
            </div>
            <div class="form-group">
                <input type="number" name="min_amount" id="min_amount" class="form-control" placeholder="Mt Min" value="{{ Request::input('min_amount') }}">
            </div>
            <div class="form-group my-2">
                <button type="submit" class="btn btn-primary" title="Filtrer">
                    <i class="fas fa-filter"></i>
                </button>
                <a class="btn btn-secondary" href="{{ route('payments.index') }}" title="Reset">
                    <i class="fas fa-redo"></i>
                </a>
            </div>
        </form>
    </aside>
    <main class="col-md-10">
    <h1>Liste des Paiements</h1>
    <a href="{{ route('payments.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i>
    </a>
        <table class="table mt-3">
        <thead>
            <tr>
                <th>Numéro de Paiement</th>
                <th>Montant</th>
                <th>Date</th>
                <th>Mode de Paiement</th>
                <th>Client</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($payments as $payment)
            <tr>
                <td>{{ $payment->Npayment ?? 'N/A' }}</td>
                <td>{{ $payment->montant ?? 'N/A' }}</td>
                <td>{{ $payment->date_payment ?? 'N/A' }}</td>
                <td>{{ $payment->mode_payment ?? 'N/A' }}</td>
                <td>{{ $payment->client ? $payment->client->name : 'N/A' }}</td>
                <td>
                    <a href="{{ route('payments.edit', $payment->id) }}" class="btn btn-warning btn-sm" title="Modifier">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="{{ route('payments.show', $payment->id) }}" class="btn btn-info btn-sm" title="Détails">
                        <i class="fas fa-info-circle"></i>
                    </a>
                    <form action="{{ route('payments.destroy', $payment->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" title="Supprimer">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $payments->links() }}
        </main>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#toggle-filter').on('click', function() {
            var filters = $('#filters');
            filters.slideToggle(); // Utilisation de slideToggle pour un effet de glissement
        });
    });
</script>
@endsection
