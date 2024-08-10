<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
            'NFact',
            'DateFact',
            'nbrArt',
            'mht',
            'ttva',
            'mtva',
            'tremise',
            'mremise',
            'mttc',
            'client_id'



    ];

    public function Client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function details()
    {
        return $this->hasMany(SaleDetail::class);
    }

    // Optionnel : Déclaration de la méthode pour le total de la vente
    public function getTotalAttribute()
    {
        return $this->details->sum(function ($detail) {
            return $detail->unit_price * $detail->quantity;
        });
    }


    // Other model methods and relationships

    public static function boot()
    {
        parent::boot();

        static::creating(function ($sale) {
            $sale->NFact = $sale->generateNextNFact();
        });
    }

    public static function generateNextNFact()
    {
        $latestSale = self::latest()->first();
        $latestNFact = $latestSale ? $latestSale->NFact : 'FA00000';

        // Extraire la partie numérique et l'incrémenter
        $number = (int) substr($latestNFact, 2) + 1;

        // Formater le nouveau numéro avec des zéros initiaux
        $newNFact = 'FA' . str_pad($number, 5, '0', STR_PAD_LEFT);

        // Vérifier les collisions
        while (self::where('NFact', $newNFact)->exists()) {
            $number++;
            $newNFact = 'FA' . str_pad($number, 5, '0', STR_PAD_LEFT);
        }

        return $newNFact;
    }

}
