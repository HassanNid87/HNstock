@extends('base')
@section('title', 'Sales')
@section('content')
<style>
    .no-wrap {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar for filters -->
        <aside class="col-md-2">
            <h1>Filters</h1>
            <form method="get">
                <div class="form-group">
                    <label for="client">Client Name</label>
                    <input type="text" name="client" id="client" class="form-control" placeholder="Client Name" value="{{ Request::input('client') }}">
                </div>
                <h3>Date</h3>
                <div class="form-group">
                    <label for="start_date">Start Date</label>
                    <input type="date" name="start_date" id="start_date" class="form-control" value="{{ Request::input('start_date') }}">
                </div>
                <div class="form-group">
                    <label for="end_date">End Date</label>
                    <input type="date" name="end_date" id="end_date" class="form-control" value="{{ Request::input('end_date') }}">
                </div>
                <h3>Amount</h3>
                <div class="form-group">
                    <label for="min_amount">Min Amount</label>
                    <input type="number" name="min_amount" id="min_amount" class="form-control" placeholder="Min Amount" value="{{ Request::input('min_amount') }}">
                </div>
                <div class="form-group">
                    <label for="max_amount">Max Amount</label>
                    <input type="number" name="max_amount" id="max_amount" class="form-control" placeholder="Max Amount" value="{{ Request::input('max_amount') }}">
                </div>
                <div class="form-group my-2">
                    <input type="submit" class="btn btn-primary" value="Filter">
                    <a type="reset" class="btn btn-secondary" href="{{ route('sales.index') }}">Reset</a>
                </div>
            </form>
        </aside>

        <!-- Affichage des erreurs de validation -->
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

        <!-- Main content for sales list -->
        <main class="col-md-10">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Sales List</h1>
                <a href="{{ route('sales.create') }}" class="btn btn-primary">Create</a>
            </div>

              <!-- Chart -->

          <table class="table">
                <thead align="center">
                    <tr>
                        <th>NFact</th>
                        <th>DateFacte</th>
                        <th>Client</th>
                        <th class="no-wrap">Montant HT</th>
                        <th class="no-wrap">M-Tva</th>
                        <th class="no-wrap">M-Remise</th>
                        <th class="no-wrap">Montant TTC</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody align="center">
                    @forelse ($sales as $sale)
                    <tr>
                        <td>{{ $sale->NFact }}</td>
                        <td class="no-wrap">{{ $sale->DateFact }}</td> <!-- Application de la classe no-wrap -->
                        <td align="center">
                            @if ($sale->client)
                                <a href="{{ route('clients.show', $sale->client_id) }}" class="btn btn-link">
                                    <span class="badge" style="background-color:#F97300;">
                                        {{ $sale->client->name }}
                                    </span>
                                </a>
                            @else
                                ----------
                            @endif
                        </td>
                        <td>{{ $sale->mht }}</td>
                        <td>{{ $sale->mtva }}</td>
                        <td>{{ $sale->mremise }}</td>
                        <td style="color: #000000;font-family: Arial, sans-serif; font-weight: bold;font-size: 17px;">{{ $sale->mttc }}</td>
                        <td>
                            <div class="btn-group gap-2">
                                <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-sm btn-outline-info rounded">Details</a>
                                <a href="{{ route('sales.edit', $sale) }}" class="btn btn-sm btn-outline-primary rounded">Update</a>
                                <form method="POST" action="{{ route('sales.destroy', $sale) }}" onsubmit="return confirm('Are you sure you want to delete this sale?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded">Delete</button>
                                </form>
                                <a href="{{ route('sales.invoice', $sale->id) }}" class="btn btn-sm btn-outline-primary rounded">Print</a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" align="center"><h6>No sales found.</h6></td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $sales->links() }}
        </main>
    </div>
</div>

<!-- Pagination avec conservation des filtres -->
{{ $sales->appends(request()->except('page'))->links() }}

<canvas id="salesChart" width="400" height="200"></canvas>

<script>
  // Get the data from the controller
  const months = @json($months);
    const totals = @json($totals);

    // Convert month numbers to month names
    const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
    const labels = months.map(month => monthNames[month - 1]);

    // Create the chart
    const ctx = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(ctx, {
        type: 'bar', // or 'line'
        data: {
            labels: labels,
            datasets: [{
                label: 'Sales by Month',
                data: totals,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection
