<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_id',
        'sale_id',
        'NFact',
        'DateFact',
        'mttc',
        'montant_restant',
        'montant_regle'

    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}

