<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentDetailRequest;
use App\Models\Payment;
use App\Models\PaymentDetail;
use App\Models\Sale;
use Illuminate\Http\Request;

class PaymentDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paymentDetails = PaymentDetail::with('payment', 'sale')->paginate(15);
        return view('payment_detail.index', compact('paymentDetails'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $paymentDetail = new PaymentDetail();

        // Récupérer toutes les ventes et paiements disponibles pour les options de sélection
        $payments = Payment::all();
        $sales = Sale::all();

        // Remplir les champs avec des valeurs par défaut
        $paymentDetail->fill([
            'NFact' => '',
            'DateFact' => now()->toDateString(),
            'mttc' => 0,
            'montant_restant' => 0,
            'montant_regle' => 0,
        ]);

        // Indiquer qu'il s'agit d'une création
        $isUpdate = false;

        // Retourner la vue avec les données nécessaires
        return view('payment_detail.form', compact('paymentDetail', 'isUpdate', 'payments', 'sales'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PaymentDetailRequest $request)
    {
        // Valider les données du formulaire
        $formFields = $request->validated();

        // Créer un nouveau détail de paiement avec les données validées
        PaymentDetail::create($formFields);

        // Rediriger l'utilisateur vers une page appropriée avec un message de succès
        return redirect()->route('payment_details.index')->with('success', 'Payment detail created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(PaymentDetail $paymentDetail)
    {
        return view('payment_detail.show', compact('paymentDetail'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaymentDetail $paymentDetail)
    {
        $payments = Payment::all();
        $sales = Sale::all();

        // Indiquer qu'il s'agit d'une édition
        $isUpdate = true;

        // Retourner la vue avec les données nécessaires
        return view('payment_detail.form', compact('paymentDetail', 'isUpdate', 'payments', 'sales'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PaymentDetail $paymentDetail)
    {
        // Valider les données du formulaire
        $validated = $request->validate([
            'payment_id' => 'required|exists:payments,id',
            'sale_id' => 'required|exists:sales,id',
            'NFact' => 'required|string',
            'DateFact' => 'required|date',
            'mttc' => 'required|numeric',
            'montant_restant' => 'required|numeric',
            'montant_regle' => 'required|numeric',
        ]);

        // Mettre à jour le détail de paiement avec les données validées
        $paymentDetail->update($validated);

        // Rediriger l'utilisateur avec un message de succès
        return redirect()->route('payment_details.index')->with('success', 'Payment detail updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentDetail $paymentDetail)
    {
        $paymentDetail->delete();
        return redirect()->route('payment_details.index')->with('success', 'Payment detail deleted successfully');
    }
}
