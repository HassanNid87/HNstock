<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\cr;
use App\Models\product;
use FontLib\Table\Type\name;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

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



        return view('store.index', compact(
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(cr $cr)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(cr $cr)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, cr $cr)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(cr $cr)
    {
        //
    }
}
