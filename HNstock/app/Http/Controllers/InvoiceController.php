<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\CompanyInfo;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function show($id)
    {
            // Récupérer la facture
        $sale = Sale::findOrFail($id);

        // Récupérer les informations de la société
        $companyInfo = CompanyInfo::first();

        // Passer les données à la vue
        return view('invoices.show', compact('sale', 'companyInfo'));
    }

    public function download($id)
    {
        // Récupérer les informations de la vente
        $sale = Sale::with('details.product')->findOrFail($id);

        // Récupérer les informations de la société
        $companyInfo = CompanyInfo::first();

        // Générer le PDF
        $pdf = Pdf::loadView('invoices.pdf', compact('sale', 'companyInfo'));

        // Télécharger le PDF
        return $pdf->download('facture-' . $sale->NFact . '.pdf');
    }
}
