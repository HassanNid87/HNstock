@extends('base')
@section('title', 'Sales')
@section('content')

<style>
    .no-wrap {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

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

    .table td, .table th {
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

    .badge {
        padding: 5px;
        font-size: 12px;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar for filters -->
        <aside class="col-md-2">
            <h1>Filters</h1>
            <form method="get">
                <div class="form-group">
                    <input type="text" name="NFacture" id="NFacture" class="form-control" placeholder="N° Facture" value="{{ Request::input('NFacture') }}">
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
                    <br>
                    <input type="number" name="min_amount" id="min_amount" class="form-control" placeholder="Mt Min" value="{{ Request::input('min_amount') }}">
                </div>

                <div class="form-group my-2">
                    <button type="submit" class="btn btn-primary" title="Filtrer">
                        <i class="fas fa-filter"></i>
                    </button>
                    <a class="btn btn-secondary" href="{{ route('sales.index') }}" title="Reset">
                        <i class="fas fa-redo"></i>
                    </a>
                </div>
            </form>
        </aside>

        <!-- Display validation errors -->
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
                <a href="{{ route('sales.create') }}" class="btn btn-primary" title="Nouvelle Facture">
                    <i class="fas fa-file-alt"></i>
                </a>
            </div>

            <!-- Sales table -->
            <div class="card my-4">
                <div class="card-header bg-dark text-white text-center">
                    <h5>Sales Table</h5>
                </div>
                <div class="card-body p-0">
                    <table class="table table-bordered table-striped table-hover mb-0">
                        <thead class="table-dark" align="center">
                            <tr>
                                <th>NFact</th>
                                <th>DateFact</th>
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
                                    <td class="no-wrap">{{ $sale->DateFact }}</td>
                                    <td>
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
                                    <td>{{ number_format($sale->mht, 2) }} </td>
                                    <td>{{ number_format($sale->mtva, 2) }} </td>
                                    <td>{{ number_format($sale->mremise, 2) }} </td>
                                    <td style="color: #000000; font-family: Arial, sans-serif; font-weight: bold; font-size: 17px;">
                                        {{ number_format($sale->mttc, 2) }}
                                    </td>
                                    <td>
                                        <div class="btn-group gap-2">
                                            <!-- Details Button -->
                                            <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-sm btn-outline-info rounded" title="Details">
                                                <i class="fas fa-info-circle"></i>
                                            </a>
                                            <!-- Update Button -->
                                            <a href="{{ route('sales.edit', $sale) }}" class="btn btn-sm btn-outline-primary rounded" title="Update">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <!-- Delete Button -->
                                            <form method="POST" action="{{ route('sales.destroy', $sale) }}" onsubmit="return confirm('Are you sure you want to delete this sale?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger rounded" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                            <!-- Print Button -->
                                            <a href="{{ route('sales.invoice', $sale->id) }}" class="btn btn-sm btn-outline-primary rounded" title="Print">
                                                <i class="fas fa-print"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" align="center"><h6>No sales found.</h6></td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{ $sales->links() }}
                </div>
            </div>

            <!-- Pagination with filter preservation -->
            {{ $sales->appends(request()->except('page'))->links() }}

            <!-- Chart -->
            <div class="card my-4">
                <div class="card-header bg-dark text-white text-center">
                    <h5>Sales by Month</h5>
                </div>
                <div class="card-body">
                    <canvas id="salesChart" width="400" height="200"></canvas>
                </div>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
