@foreach($sales as $sale)
    <div>{{ $sale->NFact }} - {{ $sale->client->name }} - {{ $sale->DateFact }}</div>
@endforeach

<!-- Ajouter la pagination si nécessaire -->
{{ $sales->links() }}
