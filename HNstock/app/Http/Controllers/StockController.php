<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Stock;
use App\Models\SaleDetail;
use App\Models\Category;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {

        $stocks = Stock::with('product.category')->get(); // Charger aussi la catégorie
    $categories = Category::all(); // Récupérer toutes les catégories

    return view('stock.index', compact('stocks', 'categories'));
    }

    public function create()
    {
        $products = Product::all();
        return view('stock.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer',
        ]);

        Stock::create($request->all());

        return redirect()->route('stocks.index')->with('success', 'Stock created successfully');
    }

    public function edit(Stock $stock)
    {
        $products = Product::all();
        return view('stock.edit', compact('stock', 'products'));
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

    $categories = Category::all(); // Récupérer toutes les catégories
    // Utiliser les dates par défaut si elles ne sont pas fournies
    $startDate = $request->input('start_date', date('Y-m-d'));
    $endDate = $request->input('end_date', date('Y-m-d'));

    // Construire la requête pour récupérer les détails des ventes
    $query = SaleDetail::with(['sale', 'product.category']) // Charger également la catégorie
        ->join('sales', 'sale_details.sale_id', '=', 'sales.id') // Join with sales table
        ->select('sale_details.*') // Select only columns from sale_details
        ->whereBetween('sales.DateFact', [$startDate, $endDate]); // Filter based on sales.date

    $salesDetails = $query->get()->groupBy(function ($item) {
        return $item->sale->DateFact; // Grouper par date de vente
    });

    $stockOuts = [];

    foreach ($salesDetails as $date => $details) {
        foreach ($details->groupBy('product_id') as $productId => $productDetails) {
            $totalQuantity = $productDetails->sum('quantity');
            $stockOuts[] = [
                'date' => $date,
                'product' => $productDetails->first()->product,
                'category' => $productDetails->first()->product->category->name, // Ajouter la catégorie
                'quantity' => $totalQuantity,
            ];
        }
    }

    // Convert to a Collection and sort by date in descending order
    $stockOuts = collect($stockOuts)->sortByDesc('date');

    return view('stock.out', compact('stockOuts', 'categories'));
}

}
