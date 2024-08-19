<?php

namespace App\Observers;

use App\Models\Sale;

class SaleObserver
{
    /**
     * Handle the Sale "created" event.
     */

     public function saved(Sale $sale)
{
    $client = $sale->client;
    $client->debit = $client->sales->sum('mttc');
    $client->solde = $client->debit - $client->credit;
    $client->save();
}


    public function created(Sale $sale): void
    {
        //
    }

    /**
     * Handle the Sale "updated" event.
     */
    public function updated(Sale $sale): void
    {
        //
    }

    /**
     * Handle the Sale "deleted" event.
     */
    public function deleted(Sale $sale): void
    {
        //
    }

    /**
     * Handle the Sale "restored" event.
     */
    public function restored(Sale $sale): void
    {
        //
    }

    /**
     * Handle the Sale "force deleted" event.
     */
    public function forceDeleted(Sale $sale): void
    {
        //
    }
}
