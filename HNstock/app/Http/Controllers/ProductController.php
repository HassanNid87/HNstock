<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::query()->with('category')->paginate(15);


        $productsQuery = Product::query();
        //$max = Product::query()->max('priceV');
        //$min = Product::query()->min('priceV');
        $categories = Category::with('products')->has('products')->get();
         /*->orderBy('created_at','desc')
         ->limit(15)
         ->get();*/


         $name =($request->input('name'));
         $max =($request->input('max'));
         $min =($request->input('min')) ?? 0;
         $categoriesIds = ($request->input('categories'));

         if (!empty($name)) {
             $productsQuery->where('name','like',"%{$name}%");
         }
         if (!empty($categoriesIds)) {
             $productsQuery->whereIn('category_id',$categoriesIds);
         }
         $productsQuery->where('priceV','>=',$min);

         if (!empty($max)) {
             $productsQuery->where('priceV','<=',$max);
         }


         $products = $productsQuery->get();
         $pricesV = $products->pluck('priceV')->all();

         $priceVOptions = new \stdClass();

         $priceVOptions-> maxPriceV = 0;
         $priceVOptions-> minPriceV = 0;

         if(!empty($pricesV)) {
             $priceVOptions-> maxPriceV = max($pricesV);
             $priceVOptions-> minPriceV = min($pricesV);
         }




         return view('product.index', compact(
            'products',
             'categories',
                'priceVOptions'
            ));


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $product = new Product();
        $categories = Category::all();
        $product->fill([

            'priceV' =>0,
            'priceA' =>0,
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
        if($request->hasFile(key:'image')) {
            $formFields['image'] = $request->file(key:'image')->store(path:'product', options:'public');
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
    //dd($request->input('cart'));

    if (!$cart) {
        return response()->json(['message' => 'Cart is empty'], 400);
    }

    // Logic to create invoice from cart data
    $invoice = new Invoice();
    $invoice->date = now();
    $invoice->save();

    foreach ($cart as $item) {
        $product = Product::find($item['id']);
        if ($product) {
            $invoiceItem = new InvoiceItem();
            $invoiceItem->invoice_id = $invoice->id;
            $invoiceItem->product_id = $product->id;
            $invoiceItem->quantity = $item['quantity'];
            $invoiceItem->price = $product->priceV;
            $invoiceItem->total = $product->priceV * $item['quantity'];
            $invoiceItem->save();
        }
    }

    return response()->json(['message' => 'Invoice created successfully']);
}
}
