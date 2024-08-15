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

        // Récupérer uniquement les ventes avec le statut 'Attente' ou 'Partiellement Payée' et les clients associés
        $sales = Sale::whereIn('status', ['EnAttente', 'PartPayée'])->with('client')->get();

        // Compter le nombre de paiements existants
        $paymentCount = Payment::count() + 1;

        // Formater le numéro de paiement
        $Npayment = 'Reg' . str_pad($paymentCount, 4, '0', STR_PAD_LEFT);

        return view('payment.create', compact('sales', 'clients', 'Npayment'));
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

        // Créer le paiement
        $payment = Payment::create($validated);

        // Montant total du paiement
        $totalAmount = $validated['montant'];

        // Récupérer les ventes sélectionnées
        $selectedSales = Sale::whereIn('id', $request->input('sales'))->get();

        // Boucle pour traiter chaque vente
        foreach ($selectedSales as $sale) {
            if ($totalAmount <= 0) {
                break; // Arrêter si le montant total est épuisé
            }

            // Calculer le montant à régler pour cette vente
            $amountToPay = min($sale->montant_restant, $totalAmount);

            // Mettre à jour le montant restant pour la vente
            $sale->montant_restant -= $amountToPay;

            // Mettre à jour le statut de la vente
            if ($sale->montant_restant <= 0) {
                $sale->status = 'Réglée'; // Facture complètement réglée
            } elseif ($sale->montant_restant < $sale->mttc) {
                $sale->status = 'PartPayée'; // Facture partiellement réglée
            } else {
                $sale->status = 'EnAttente'; // Facture encore en attente de paiement
            }
            $sale->save();

            // Créer un détail de paiement
            $payment->details()->create([
                'sale_id' => $sale->id,
                'NFact' => $sale->NFact,
                'DateFact' => $sale->DateFact,
                'mttc' => $sale->mttc,
                'montant_regle' => $amountToPay, // Enregistrer le montant réglé pour cette vente
            ]);

            // Réduire le montant total du paiement par le montant payé pour cette vente
            $totalAmount -= $amountToPay;
        }

         // Mise à jour du crédit du client
         $client = $payment->client;
         $client->credit += $payment->montant; // `amount` est le montant du paiement
         $client->solde = $client->debit - $client->credit; // Mise à jour du solde
         $client->save();

        return redirect()->route('payments.index')->with('success', 'Paiement ajouté avec succès.');
    }





    public function edit(Payment $payment)
    {
        // Récupérer tous les clients
        $clients = Client::all();

        // Récupérer les ventes associées au client du paiement en cours
        $sales = Sale::where('client_id', $payment->client_id)
                     ->where('status', 'pending')
                     ->get();

        // Récupérer les ventes associées à ce paiement
        $selectedSales = $payment->details->pluck('sale_id')->toArray();

        return view('payment.edit', compact('payment', 'clients', 'sales', 'selectedSales'));
    }


    public function update(Request $request, Payment $payment)
    {
        // Valider les données du formulaire
        $validated = $request->validate([
            'Npayment' => 'required|string',
            'montant' => 'required|numeric',
            'date_payment' => 'required|date',
            'mode_payment' => 'required|string',
            'client_id' => 'required|exists:clients,id',
            'sales' => 'nullable|array', // Les factures sélectionnées sont optionnelles lors de la mise à jour
        ]);

        // Mettre à jour les informations du paiement
        $payment->update($validated);

        // Supprimer les anciens détails de paiement
        $payment->details()->delete();

        $totalAmount = $validated['montant'];
        $selectedSales = Sale::whereIn('id', $request->input('sales', []))->get();

        foreach ($selectedSales as $sale) {
            if ($totalAmount <= 0) {
                break;
            }

            $amountToPay = min($sale->mttc, $totalAmount);
            $sale->montant_restant -= $amountToPay;
            $sale->status = $sale->montant_restant > 0 ? 'pending' : 'paid';
            $sale->save();

            $payment->details()->create([
                'sale_id' => $sale->id,
                'NFact' => $sale->NFact,
                'DateFact' => $sale->DateFact,
                'montant_restant' => $sale->montant_restant,
            ]);

            $totalAmount -= $amountToPay;
        }

        return redirect()->route('payments.index')->with('success', 'Paiement mis à jour avec succès.');
    }




   public function destroy(Payment $payment)
{
    $payment->details()->delete(); // Supprimer les détails associés
    $payment->delete();

    return redirect()->route('payments.index')->with('success', 'Paiement supprimé avec succès.');
}

    public function show(Payment $payment)
    {
        return view('payment.show', compact('payment'));
    }
}
