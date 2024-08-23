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




public static function generateNextNReglement()
{
    $latestPayment = self::latest()->first();
    $latestNReglement = $latestPayment ? $latestPayment->Npayment : 'RG00000';

    // Extraire la partie numérique et l'incrémenter
    $number = (int) substr($latestNReglement, 2) + 1;

    // Formater le nouveau numéro avec des zéros initiaux
    $newNReglement = 'RG' . str_pad($number, 5, '0', STR_PAD_LEFT);

    // Vérifier les collisions
    while (self::where('Npayment', $newNReglement)->exists()) {
        $number++;
        $newNReglement = 'RG' . str_pad($number, 5, '0', STR_PAD_LEFT);
    }

    return $newNReglement;
}

}

