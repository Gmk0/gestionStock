<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;


    protected $fillable=
    ['nom', 'qte_pc', 'qte_pqt', 'illustration'];

    public function ventes()
    {
        return $this->hasMany(vente::class);
    }
    public function achat()
    {
        return $this->hasMany(Achat::class);
    }


}
