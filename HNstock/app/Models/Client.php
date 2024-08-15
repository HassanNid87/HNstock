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


      // Calcul du débit total basé sur les ventes
      public function getTotalDebitAttribute()
      {
          return $this->sales->sum('mttc');  // Assurez-vous que 'montant' est le nom de la colonne pour les montants des ventes
      }

      // Calcul du crédit total basé sur les paiements
      public function getTotalCreditAttribute()
      {
          return $this->payments->sum('montant');  // Assurez-vous que 'montant' est le nom de la colonne pour les montants des paiements
      }

      // Calcul du solde = Débit - Crédit
      public function getSoldeAttribute()
      {
          return $this->total_debit - $this->total_credit;
      }
}
