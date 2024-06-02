<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaleRequest;
use App\Models\Client;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Stock;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use PDF;



class SaleController extends Controller
{
    public function index(Request $request)
    {
          // Validation des entrées
    $request->validate([
        'start_date' => 'nullable|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
        'min_amount' => 'nullable|numeric',
        'max_amount' => 'nullable|numeric|gte:min_amount',
        'client' => 'nullable|string'
    ]);

    $query = Sale::query();

    if ($request->filled('client')) {
        $query->whereHas('client', function($q) use ($request) {
            $q->where('name', 'like', '%' . $request->client . '%');
        });
    }

    if ($request->filled('start_date')) {
        $startDate = date('Y-m-d', strtotime($request->start_date)) . ' 00:00:00';
        $query->where('DateFact', '>=', $startDate);
    }

    if ($request->filled('end_date')) {
        $endDate = date('Y-m-d', strtotime($request->end_date)) . ' 23:59:59';
        $query->where('DateFact', '<=', $endDate);
    }

    if ($request->filled('min_amount')) {
        $query->where('mttc', '>=', $request->min_amount);
    }

    if ($request->filled('max_amount')) {
        $query->where('mttc', '<=', $request->max_amount);
    }
// Graphique
            $salesByMonth = Sale::selectRaw('MONTH(DateFact) as month, SUM(mttc) as total')
                            ->groupBy('month')
                            ->orderBy('month')
                            ->get();
        $months = $salesByMonth->pluck('month');
        $totals = $salesByMonth->pluck('total');
        //dd($months, $totals);
        $sales = $query->with('client', 'details.product')->paginate(15)->appends($request->all());

// Convertir les mois en noms de mois
$monthNames = [
    1 => 'Jan',
    2 => 'Feb',
    3 => 'Mar',
    4 => 'Apr',
    5 => 'May',
    6 => 'Jun',
    7 => 'Jul',
    8 => 'Aug',
    9 => 'Sep',
    10 => 'Oct',
    11 => 'Nov',
    12 => 'Dec',
];

// Convertir les numéros de mois en noms de mois
$labels = $months->map(function($month) use ($monthNames) {
    return $monthNames[$month];
})->toArray();

// Passer les données à la vue
return view('sale.index', compact('sales', 'months', 'labels', 'totals'));
}


    public function create()
    {
        $sale = new Sale();
        $clients = Client::all();
        $products = Product::all();
        $sale->fill([
            'mht' => 0,
            'mtva' => 0,
            'mremise' => 0,
            'mttc' => 0,
            'NFact' => Sale::generateNextNFact(), // Génération du numéro de facture
        ]);
        $isUpdate = false;
        return view('sale.form', compact('sale', 'isUpdate', 'clients', 'products'));
    }

    // Générer automatiquement le numéro de facture
public static function generateNextNFact()
{
    $latestSale = Sale::latest()->first();
    $latestNFact = $latestSale ? $latestSale->NFact : 'FA0000';

    // Extraire la partie numérique et l'incrémenter
    $number = (int) substr($latestNFact, 2) + 1;

    // Formater le nouveau numéro avec des zéros initiaux
    return 'FA' . str_pad($number, 4, '0', STR_PAD_LEFT);
}

    public function store(SaleRequest $request)
{
    $validatedData = $request->validated();

    $sale = Sale::create($validatedData);

    foreach ($request->product_id as $key => $productId) {
        $product = Product::findOrFail($productId);

        // Check stock availability
        if ($product->stock->quantity < $request->quantity[$key]) {
            return redirect()->back()->with('error', 'Not enough stock available for product: ' . $product->name);
        }

        // Create sale detail
        $detail = [
            'product_id' => $productId,
            'quantity' => $request->quantity[$key],
            'unit_price' => $request->unit_price[$key],
            'total' => $request->quantity[$key] * $request->unit_price[$key],
        ];
        $sale->details()->create($detail);

        // Decrement the stock
        $product->stock->decrement('quantity', $request->quantity[$key]);
    }

    return redirect()->route('sales.index')->with('success', 'Sale created successfully');
}

    public function show(Sale $sale)
    {
       // Charger les détails de la vente avec les relations
    $sale->load('details.product');

    return view('sale.show', compact('sale'));
    }

    public function edit(Sale $sale)
    {
        $isUpdate = true;
        $clients = Client::all();
        $products = Product::all();
        return view('sale.form', compact('sale', 'isUpdate', 'clients', 'products'));
    }

    public function update(SaleRequest $request, Sale $sale)
    {
        $data = $request->validated();
        $data['DateFact'] = $data['DateFact'] ?? now()->toDateString();
        // NFact should not be updated, remove it if present
        unset($validatedData['NFact']);
        // Restore previous stock
        foreach ($sale->details as $detail) {
            $product = Product::findOrFail($detail->product_id);
            $product->stock->increment('quantity', $detail->quantity);
        }

        $sale->update($data);

        // Delete existing sale details
        $sale->details()->delete();

        // Create new sale details and adjust stock
        foreach ($request->product_id as $key => $productId) {
            $product = Product::findOrFail($productId);

            // Check stock availability
            if ($product->stock->quantity < $request->quantity[$key]) {
                return redirect()->back()->with('error', 'Not enough stock available for product: ' . $product->name);
            }

            $detail = [
                'product_id' => $productId,
                'quantity' => $request->quantity[$key],
                'unit_price' => $request->unit_price[$key],
                'total' => $request->quantity[$key] * $request->unit_price[$key],
            ];
            $sale->details()->create($detail);

            // Decrement the stock
            $product->stock->decrement('quantity', $request->quantity[$key]);
        }

        return redirect()->route('sales.index')->with('success', 'Sale updated successfully');
    }

    public function destroy(Sale $sale)
{
    // Restore previous stock
    foreach ($sale->details as $detail) {
        $product = Product::findOrFail($detail->product_id);
        $product->stock->increment('quantity', $detail->quantity);
    }

    $sale->delete();

    return redirect()->route('sales.index')->with('success', 'Sale deleted successfully');
}


public function generatePDF($id)
{
    $sale = Sale::findOrFail($id);
    $html = view('sale.invoice', compact('sale'))->render();

    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);

    // (Optionnel) Paramètres de mise en page
    $dompdf->setPaper('A4', 'portrait');

    // Rendu du PDF
    $dompdf->render();

    // Récupération des informations pour le nom du fichier
    $NFact = $sale->NFact;
    $DateFact = \DateTime::createFromFormat('Y-m-d', $sale->DateFact)->format('Ymd'); // Formater la date au format YYYYMMDD

    // Générer le nom du fichier
    $filename = "{$NFact}_{$DateFact}.pdf";

    // Envoi du PDF en réponse à la demande
    return $dompdf->stream($filename);
}




}
