<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoPrix extends Model
{
    use HasFactory;



    protected $fillable=['prix_pqt', 'prix_unit', 'taux', 'activer'];

    public function Vente()
    {
        return $this->hasMany(Vente::class);
    }


}
