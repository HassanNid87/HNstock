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
            'quantity' => 0,
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
    public function update(ProductRequest $request, product $product)
    {
        $product->fill($request->validated())->save();
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }
        $product->update($data);

        // Update stock record
        $product->stock()->update([
            'quantity' => $request->input('quantity', $product->stock->quantity),
        ]);

        return to_route(route: 'products.index')->with('success', 'Product update successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(product $product)
    {
        $product->delete();
        return to_route(route: 'products.index')->with('success', 'Product deleted successfully');


    }
}