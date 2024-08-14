<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'Npayment',
        'montant',
        'date_payment',
        'mode_payment',
        'client_id', // Assurez-vous que client_id est inclus
    ];
    protected $casts = [
        'date_payment' => 'date', // Cast date_payment en date
    ];





public function client()
{
    return $this->belongsTo(Client::class);
}


public function details()
{
    return $this->hasMany(PaymentDetail::class);
}

}

