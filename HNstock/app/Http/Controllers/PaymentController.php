<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Sale;
use App\Models\Client;
use Illuminate\Http\Request;


class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('client')->paginate(15);
        return view('payment.index', compact('payments'));
    }

    public function create()
    {
        // Récupérer tous les clients
    $clients = Client::all();

    // Récupérer uniquement les ventes avec le statut 'pending' et les clients associés
    $sales = Sale::where('status', 'pending')->with('client')->get();

    // Compter le nombre de paiements existants
    $paymentCount = Payment::count() + 1;

    // Formater le numéro de paiement
    $Npayment = 'Reg' . str_pad($paymentCount, 4, '0', STR_PAD_LEFT);
        return view('payment.create', compact( 'sales', 'clients', 'Npayment'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'Npayment' => 'required|string',
            'montant' => 'required|numeric',
            'date_payment' => 'required|date',
            'mode_payment' => 'required|string',
            'client_id' => 'required|exists:clients,id',
            'sales' => 'required|array', // Les factures sélectionnées doivent être fournies
        ]);

        $payment = Payment::create($validated);

        $totalAmount = $validated['montant'];
        $selectedSales = Sale::whereIn('id', $request->input('sales'))->get();

        foreach ($selectedSales as $sale) {
            if ($totalAmount <= 0) {
                break;
            }

            $amountToPay = min($sale->mttc, $totalAmount);
            $sale->montant_restant -= $amountToPay;
            $sale->status = $sale->montant_restant > 0 ? 'pending' : 'paid';
            $sale->save();

            $totalAmount -= $amountToPay;
        }

        return redirect()->route('payments.index')->with('success', 'Paiement ajouté avec succès.');
    }



    public function edit(Payment $payment)
    {

        $clients = Client::all();
        $sales = Sale::where('client_id', $payment->client_id)
                     ->where('status', 'pending')
                     ->get();

        // Récupérer les ventes associées à ce paiement
        $selectedSales = $payment->sales()->pluck('sale_id')->toArray();

        return view('payment.edit', compact('payment', 'clients', 'sales', 'selectedSales'));
    }
    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'NPayment' => 'required|string',
            'montant' => 'required|numeric',
            'date_payment' => 'required|date',
            'mode_payment' => 'required|string',
            'client_id' => 'required|exists:clients,id',
        ]);

        $payment->update($validated);

        return redirect()->route('payments.index')->with('success', 'Paiement mis à jour avec succès.');
    }



    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect()->route('payments.index')->with('success', 'Paiement supprimé avec succès.');
    }

    public function show(Payment $payment)
    {
        return view('payment.show', compact('payment'));
    }
}
