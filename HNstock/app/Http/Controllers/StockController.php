<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Stock;
use App\Models\SaleDetail;
use Illuminate\Http\Request;


class StockController extends Controller
{
    public function index()
    {
        $stocks = Stock::with('product')->get();
        return view('stock.index', compact('stocks'));
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

    public function showStockOut()
    {
        $salesDetails = SaleDetail::with(['sale', 'product'])
            ->get()
            ->groupBy(function ($item) {
                return $item->sale->DateFact; // Grouper par date de vente
            });

        $stockOuts = [];

        foreach ($salesDetails as $date => $details) {
            foreach ($details->groupBy('product_id') as $productId => $productDetails) {
                $totalQuantity = $productDetails->sum('quantity');
                $stockOuts[] = [
                    'date' => $date,
                    'product' => $productDetails->first()->product,
                    'quantity' => $totalQuantity,
                ];
            }
        }
        // Convert to a Collection and sort by date in descending order
        $stockOuts = collect($stockOuts)->sortByDesc('date');

        return view('stock.out', compact('stockOuts'));
    }


}
