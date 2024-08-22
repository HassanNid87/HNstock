<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Stock;
use App\Models\SaleDetail;
use App\Models\Category;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index(Request $request)
    {
        // Récupérer les valeurs des filtres
        $categoryFilter = $request->input('category');
        $nameFilter = $request->input('name');

        // Construire la requête
        $query = Stock::with('product.category');

        // Appliquer le filtre par catégorie
        if ($categoryFilter) {
            $query->whereHas('product.category', function($q) use ($categoryFilter) {
                $q->where('id', $categoryFilter);
            });
        }

        // Appliquer le filtre par nom
        if ($nameFilter) {
            $query->whereHas('product', function($q) use ($nameFilter) {
                $q->where('name', 'like', "%{$nameFilter}%")
                  ->orWhere('description', 'like', "%{$nameFilter}%")
                  ->orWhere('codebare', 'like', "%{$nameFilter}%"); // Assuming you might filter by codebar too
            });
        }

        // Exécuter la requête
        $stocks = $query->get();
        $categories = Category::all(); // Récupérer toutes les catégories

        // Retourner la vue avec les résultats filtrés
        return view('stock.index', compact('stocks', 'categories'));
    }


    public function create()
    {
        $categories = Category::all(); // Assurez-vous d'avoir une table Category
        $products = Product::all();

        return view('stock.create', compact('categories' , 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer',
        ]);

        // Rechercher un enregistrement de stock existant pour ce produit
        $stock = Stock::where('product_id', $request->product_id)->first();

        if ($stock) {
            // Si le stock existe déjà, mettre à jour la quantité existante
            $stock->quantity += $request->quantity;
            $stock->save();
        } else {
            // Sinon, créer un nouvel enregistrement de stock
            Stock::create($request->all());
        }

        return redirect()->route('stocks.index')->with('success', 'Stock updated successfully');
    }


    public function edit(Stock $stock)
    {
        $categories = Category::all(); // Assurez-vous d'avoir une table Category
        $products = Product::all();
        return view('stock.edit', compact('stock', 'categories', 'products'));
    }

    public function update(Request $request, Stock $stock)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer',
        ]);

        $stock->update($request->all());

        return redirect()->route('stocks.index')->with('success', 'Stock updated successfully');
    }

    public function destroy(Stock $stock)
    {
        $stock->delete();
        return redirect()->route('stocks.index')->with('success', 'Stock deleted successfully');
    }

    public function showStockOut(Request $request)
    {
        // Récupérer toutes les catégories pour le filtre
        $categories = Category::all();

        // Utiliser les dates par défaut si elles ne sont pas fournies
        $startDate = $request->input('start_date', date('Y-m-d'));
        $endDate = $request->input('end_date', date('Y-m-d'));

        // Construire la requête pour récupérer les détails des ventes avec les catégories
        $query = SaleDetail::with(['sale', 'product.category'])
            ->join('sales', 'sale_details.sale_id', '=', 'sales.id')
            ->select('sale_details.*')
            ->whereBetween('sales.DateFact', [$startDate, $endDate]);

        // Filtrer par catégorie si une catégorie est sélectionnée
        if ($request->has('category') && $request->input('category') != '') {
            $query->whereHas('product.category', function($q) use ($request) {
                $q->where('id', $request->input('category'));
            });
        }

        // Récupérer les détails des ventes
        $salesDetails = $query->get()->groupBy(function ($item) {
            return $item->sale ? $item->sale->DateFact : null;
        });

        // Initialiser le tableau des sorties de stock
        $stockOuts = [];

        // Calculer la quantité totale par produit et par date
        foreach ($salesDetails as $date => $details) {
            foreach ($details->groupBy('product_id') as $productId => $productDetails) {
                $totalQuantity = $productDetails->sum('quantity');
                $stockOuts[] = [
                    'date' => $date,
                    'product' => $productDetails->first()->product,
                    'category' => $productDetails->first()->product->category->name,
                    'quantity' => $totalQuantity,
                ];
            }
        }

        // Convertir en collection et trier par date décroissante
        $stockOuts = collect($stockOuts)->sortByDesc('date');

        // Retourner la vue avec les données
        return view('stock.out', compact('stockOuts', 'categories', 'startDate', 'endDate'));
    }



}
