<div class="row">

    <div class="col-md-3 col-sm-12">
        @include('dashboard.inc.summary.card', [
            'color' => 'primary',
            'icon' => 'cash',
            'value' => "MAD.". $summary['sales'],
            'title' => 'Total Sales',
        ])
    </div>

    <div class="col-md-3 col-sm-12">
        @include('dashboard.inc.summary.card', [
            'color' => 'danger',
            'icon' => 'dolly',
            'value' => $summary['orders'],
            'title' => 'Total Orders',
        ])
    </div>

    <div class="col-md-3 col-sm-12">
        @include('dashboard.inc.summary.card', [
            'color' => 'success',
            'icon' => 'tag',
            'value' => "MAD.".$summary['totalPurchases'],
            'title' => 'Total Purchases',
        ])
    </div>

    <div class="col-md-3 col-sm-12">
        @include('dashboard.inc.summary.card', [
            'color' => 'warning',
            'icon' => 'account',
            'value' => $summary['purchases'],
            'title' => 'Purcheses',
        ])
    </div>

</div>
