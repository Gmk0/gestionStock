<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vente extends Model
{
    use HasFactory;


    protected $fillable=['produit_id', 'benefice','qte_pc','montant', 'qte_pqt', 'histoPrix_id', 'date_vente'];

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }

    protected $casts=[
        'date_vente'=>'date',
        'montant'=>'floAt',
        'benefice'=>'float',
        ];

        public function histoPrix()
        {
            return $this->belongsTo(HistoPrix::class, 'histoPrix_id');
        }

}
