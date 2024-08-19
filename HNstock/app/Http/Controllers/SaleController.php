<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaleRequest;
use App\Models\Client;
use App\Models\Category;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Http\Request;
use App\Models\CompanyInfo;
use Carbon\Carbon;
use Dompdf\Dompdf;


class SaleController extends Controller
{

    public function index(Request $request)
    {
        // Validation des entrées
        $clients = Client::all();
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'min_amount' => 'nullable|numeric',
            'max_amount' => 'nullable|numeric|gte:min_amount',
            'client' => 'nullable|string',
            'NFacture' => 'nullable|string',
            'status' => 'nullable|array',
            'status.*' => 'in:EnAttente,PartPayée,Réglée'
        ]);

        // Définir les dates par défaut
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->toDateString());

        // Construire la requête de base
        $query = Sale::query();

        if ($request->filled('NFacture')) {
            $query->where('NFact', 'like', '%' . $request->NFacture . '%');
        }

        if ($request->filled('client')) {
            $query->whereHas('client', function ($q) use ($request) {
                $q->where('id', $request->client); // Filtre par ID au lieu de nom
            });
        }

         // Filtrer par statut
    if ($request->filled('status')) {
        $query->whereIn('status', $request->status);
    }

        // Filtrer par date de début
        $query->where('DateFact', '>=', $startDate . ' 00:00:00');

        // Filtrer par date de fin
        $query->where('DateFact', '<=', $endDate . ' 23:59:59');

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

        $sales = $query->with('client', 'details.product')->paginate(15)->appends($request->all());

        // Convertir les numéros de mois en noms de mois
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
        $labels = $months->map(function ($month) use ($monthNames) {
            return $monthNames[$month];
        })->toArray();
        // Récupérer les ventes
        $sales = $query->with('client', 'details.product')->paginate(15)->appends($request->all());

        // Mettre à jour le statut des ventes
        foreach ($sales as $sale) {
            if ($sale->montant_restant == $sale->mttc) {
                $sale->status = 'EnAttente';
            } elseif ($sale->montant_restant > 0) {
                $sale->status = 'PartPayée';
            } else {
                $sale->status = 'Réglée';
            }
            $sale->save(); // Enregistre les modifications en base de données
        }

        // Passer les données à la vue
        return view('sale.index', compact('sales', 'months', 'labels', 'totals', 'clients', 'startDate', 'endDate'));
    }



    // Générer automatiquement le numéro de facture
    public static function generateNextNFact()
    {
        $latestSale = Sale::latest()->first();
        $latestNFact = $latestSale ? $latestSale->NFact : 'FA0000';

        // Extraire la partie numérique et l'incrémenter
        $number = (int)substr($latestNFact, 2) + 1;

        // Formater le nouveau numéro avec des zéros initiaux
        return 'FA' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    public function store(SaleRequest $request)
    {
        $validatedData = $request->validated();

        $sale = Sale::create($validatedData);

        $products = Product::whereIn('id', $request->product_id)->get();
        foreach ($products as $key => $product) {
            // Check stock availability
            if ($product->stock->quantity < $request->quantity[$key]) {
                return redirect()->back()->with('error', 'Not enough stock available for product: ' . $product->name);
            }

            // Create sale detail
            $detail = [
                'product_id' => $product->id,
                'quantity' => $request->quantity[$key],
                'unit_price' => $request->unit_price[$key],
                'total' => $request->quantity[$key] * $request->unit_price[$key],
            ];
            $sale->details()->create($detail);

            // Decrement the stock
            $product->stock->decrement('quantity', $request->quantity[$key]);
        }

            // Calculer le montant restant comme étant égal au montant TTC
        $sale->montant_restant = $sale->mttc;
        $sale->save();

         // Recalcul du solde du client
        $client = $sale->client;
        $client->debit = $client->sales->sum('mttc');
        $client->solde = $client->debit - $client->credit;
        $client->save();


        return response()->json(['status' => "ok"]);
    }

    public function show(Sale $sale)
    {
        // Charger les détails de la vente avec les relations
        $sale->load('details.product');
        //dd($sale->details);

        return view('sale.show', compact('sale'));
    }

    public function edit(Sale $sale, bool $isUpdate = true)
    {
        $clients = Client::all();
        $categories = Category::all(); // Récupération des catégories
        //dd($categories); // Debugging
        $products = Product::all();
        //dd($products);


        return view('sale.form', compact('sale', 'isUpdate', 'clients', 'categories', 'products'));
    }

    public function update(SaleRequest $request, Sale $sale)
    {
        $data = $request->validated();
        $data['DateFact'] = $data['DateFact'] ?? now()->toDateString();
        // NFact should not be updated, remove it if present
        unset($data['NFact']);
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
                // 'image' => $request->image[$key],
                'quantity' => $request->quantity[$key],
                'unit_price' => $request->unit_price[$key],
                'total' => $request->quantity[$key] * $request->unit_price[$key],
            ];
            $sale->details()->create($detail);

            // Decrement the stock
            $product->stock->decrement('quantity', $request->quantity[$key]);
        }

            // Recalcul du solde du client
            $client = $sale->client;
            $client->debit = $client->sales->sum('mttc');
            $client->solde = $client->debit - $client->credit;
            $client->save();


        $sale->save();

        return redirect()->route('sales.index')->with('success', 'Sale updated successfully');
    }

    public function destroy(Sale $sale)
    {
        // Restore previous stock
        foreach ($sale->details as $detail) {
            $product = Product::findOrFail($detail->product_id);
            $product->stock->increment('quantity', $detail->quantity);
        }
            // Recalcul du solde du client
            $client = $sale->client;
            $client->debit = $client->sales->sum('mttc');
            $client->solde = $client->debit - $client->credit;
            $client->save();

        $sale->delete();

        return redirect()->route('sales.index')->with('success', 'Sale deleted successfully');
    }


    public function generatePDF($id)
    {
        $sale = Sale::with('details.product')->findOrFail($id);
        $companyInfo = CompanyInfo::first(); // assuming you have only one record
        $html = view('sale.invoice', compact('sale', 'companyInfo'))->render();

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
            'montant_restant' => 0,
            'NFact' => Sale::generateNextNFact(), // Génération du numéro de facture
        ]);
        $sale->details = [
            new SaleDetail([
                'sale_id' => 0,
                'product_id' => 0,
                'quantity' => 1,
                'unit_price' => 0,
                'total' => 0,
            ])
        ];
        $categories = Category::all();

        $isUpdate = false;
        return view('sale.form', compact('sale', 'isUpdate', 'clients', 'products', 'categories'));
    }
}
