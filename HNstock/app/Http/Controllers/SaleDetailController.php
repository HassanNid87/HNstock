<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaleDetailRequest;
use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Http\Request;

class SaleDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Logique pour afficher une liste de détails de vente
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Créer une instance de SaleDetail pour le formulaire de création
        $saleDetail = new SaleDetail();

        // Récupérer toutes les ventes disponibles pour les options de sélection
        $sales = Sale::all();

        // Remplir les champs avec des valeurs par défaut
        $saleDetail->fill([
            'unit_price' => 0,
            'total' => 0,
            'quantity' => 0,
        ]);

        // Indiquer qu'il s'agit d'une création
        $isUpdate = false;

        // Retourner la vue avec les données nécessaires
        return view('sale.form', compact('saleDetail', 'isUpdate', 'sales'));


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaleDetailRequest $request)
    {
        // Valider les données du formulaire
        $formFields = $request->validated();

        // Créer un nouveau détail de vente avec les données validées
        SaleDetail::create($formFields);

        // Rediriger l'utilisateur vers une page appropriée avec un message de succès
        return redirect()->route('sales.index')->with('success', 'Sale detail created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(SaleDetail $saleDetail)
    {
        // Afficher les détails d'une vente spécifique
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SaleDetail $saleDetail)
    {
        // Logique pour afficher le formulaire d'édition
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SaleDetail $saleDetail)
    {
        // Logique pour mettre à jour les détails de la vente
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SaleDetail $saleDetail)
    {
        // Logique pour supprimer les détails de la vente
    }
}
