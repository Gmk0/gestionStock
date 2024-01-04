<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achat extends Model
{
    use HasFactory;


    protected $fillable=['produit_id', 'illustration', 'status', 'qte_pc', 'qte_pqt', 'date_paiement','montant', 'qte_pqt'];

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }

    protected $casts=[
        'date_paiement'=>'datetime',


        ];
}
