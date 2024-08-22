<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Stock;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function __construct(
        protected SaleController $saleController
    ) {

    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'code' => 'nullable|string',
            'name' => 'nullable|string',
            'description' => 'nullable|string',
            'min' => 'nullable|numeric',
            'max' => 'nullable|numeric',
            'categories' => 'nullable|array',
            'tab' => 'nullable|string', // Pour déterminer l'onglet actif
        ]);

        // Récupération des catégories avec des produits
        $categories = Category::with('products')->has('products')->get();

        // Initialisation de la requête de produits
        $productsQuery = Product::with('category');

        // Récupération des filtres depuis la requête
        $code = $request->input('code');
        $min = $request->input('min') ?? 0;
        $max = $request->input('max');
        $categoriesIds = $request->input('categories');
        $tab = $request->input('tab', 'list'); // Onglet par défaut

        // Filtre par nom, description ou code barre
        if (!empty($code)) {
            $productsQuery->where(function($query) use ($code) {
                $query->where('name', 'like', "%{$code}%")
                      ->orWhere('description', 'like', "%{$code}%")
                      ->orWhere('codebare', 'like', "%{$code}%");
            });
        }

        // Filtre par catégorie
        if (!empty($categoriesIds)) {
            $productsQuery->whereIn('category_id', $categoriesIds);
        }

        // Filtre par prix minimum
        $productsQuery->where('priceV', '>=', $min);

        // Filtre par prix maximum
        if (!empty($max)) {
            $productsQuery->where('priceV', '<=', $max);
        }

        // Exécution de la requête et récupération des produits
        $products = $productsQuery->paginate(15);

        // Calcul des options de prix
        $pricesV = $products->pluck('priceV')->all();
        $priceVOptions = new \stdClass();
        $priceVOptions->maxPriceV = $pricesV ? max($pricesV) : 0;
        $priceVOptions->minPriceV = $pricesV ? min($pricesV) : 0;

        // Retourne la vue avec les variables nécessaires
        return view('product.index', compact('products', 'categories', 'priceVOptions', 'tab'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $product = new Product();
        $categories = Category::all();
        $product->fill([

            'priceV' => 0,
            'priceA' => 0,
        ]);
        $isUpdate = false;
        return view('product.form', compact('product', 'isUpdate', 'categories'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $formFields = $request->validated();
        if ($request->hasFile(key: 'image')) {
            $formFields['image'] = $request->file(key: 'image')->store(path: 'product', options: 'public');
        }

        $product = product::create($formFields);

        // Create initial stock record
        Stock::create([
            'product_id' => $product->id,
            'quantity' => $request->input('quantity', 0),
        ]);
        return to_route(route: 'products.index')->with('success', 'Product create successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(product $product)
    {
        $isUpdate = true;
        $categories = Category::all();
        return view('product.form', compact('product', 'isUpdate', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        // Met à jour les champs du produit avec les données validées du formulaire
        $product->fill($request->validated())->save();

        // Initialiser la variable $data
        $data = [];

        // Vérifie si un fichier d'image est présent dans la requête
        if ($request->hasFile('image')) {
            // Enregistre l'image et ajoute son chemin dans $data
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        // Met à jour le produit avec les données (y compris le chemin de l'image si présent)
        if (!empty($data)) {
            $product->update($data);
        }

        // Met à jour l'enregistrement du stock
        $product->stock()->update([
            'quantity' => $request->input('quantity', $product->stock->quantity),
        ]);

        // Redirige vers la liste des produits avec un message de succès
        return to_route('products.index')->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(product $product)
    {
        $product->delete();
        return to_route(route: 'products.index')->with('success', 'Product deleted successfully');
    }


    public function createInvoice(Request $request)
    {
        $cart = $request->input('cart');
        if (!$cart || blank($cart)) {
            return view("shared.error", [
                'title' => "Cart is empty",
                'details' => "Sorry we can't handle this request since the cart is empty, please make sure to select on product at least"
            ]);
        }

        $cart = collect($cart);
        $productsIds = collect($cart)->keys();
        $products = Product::whereIn("id" , $productsIds)->get();

        $sale = new Sale();
        $sale->fill([
            'mht' => 0,
            'mtva' => 0,
            'mremise' => 0,
            'mttc' => 0,
            'NFact' => Sale::generateNextNFact(), // Génération du numéro de facture
            'date' => now()
        ]);

        foreach ($products as $value) {
            $quantity = $cart->get($value->id)['quantity'];
            $sale->details[] = new SaleDetail([
                'sale_id' => 0,
                'product_id' => $value->id,
                'quantity' => $quantity,
                'unit_price' => $value->priceV,
                'total' => $quantity * $value->priceV,
                'product' => $value,
                'barcode' => "--"
            ]);
        }

        return $this->saleController->edit($sale , false);
    }


// ProductController.php
public function findByBarcode($barcode)
{
    $product = Product::where('barcode', $barcode)->first();

    if ($product) {
        return response()->json([
            'category_id' => $product->category_id,
            'product_id' => $product->id,
            'image' => $product->image,
            'price' => $product->priceV,
            'name' => $product->name
        ]);
    }

    return response()->json(['error' => 'Product not found'], 404);
}



}
