<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'tel',
        'email',
        'photo',
        'adresse', // Ajouter adresse
        'solde',   // Ajouter solde
    ];
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }


    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
