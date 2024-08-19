<?php

namespace App\Observers;

use App\Models\Payment;

class PaymentObserver
{
    /**
     * Handle the Payment "created" event.
     */

     public function saved(Payment $payment)
{
    $client = $payment->client;
    $client->credit = $client->payments->sum('montant');
    $client->solde = $client->debit - $client->credit;
    $client->save();
}
    public function created(Payment $payment): void
    {
        //
    }

    /**
     * Handle the Payment "updated" event.
     */
    public function updated(Payment $payment): void
    {
        //
    }

    /**
     * Handle the Payment "deleted" event.
     */
    public function deleted(Payment $payment): void
    {
        //
    }

    /**
     * Handle the Payment "restored" event.
     */
    public function restored(Payment $payment): void
    {
        //
    }

    /**
     * Handle the Payment "force deleted" event.
     */
    public function forceDeleted(Payment $payment): void
    {
        //
    }
}
