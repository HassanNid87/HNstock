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
        'montant_restant'

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

