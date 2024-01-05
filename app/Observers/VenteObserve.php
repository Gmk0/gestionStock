<?php

namespace App\Observers;

use App\Models\Produit;
use App\Models\vente;

class VenteObserve
{
    /**
     * Handle the vente "created" event.e
     */
    public function created(vente $vente): void
    {

        $produit = Produit::find($vente->produit_id);


        if (!empty($vente->qte_pqt)) {


            $produit->qte_pqt -= $vente->qte_pqt;
            $produit->qte_pc -= $vente->qte_pc;

        }

        $produit->update();
        //
    }

    /**
     * Handle the vente "updated" event.
     */
    public function updated(vente $vente): void
    {
        //
    }

    /**
     * Handle the vente "deleted" event.
     */
    public function deleted(vente $vente): void
    {
        //

        $produit = Produit::find($vente->produit_id);

        $produit->qte_pqt += $vente->qte_pqt;
        $produit->qte_pc += $vente->qte_pc;

        $produit->update();
    }

    /**
     * Handle the vente "restored" event.
     */
    public function restored(vente $vente): void
    {
        //
    }

    /**
     * Handle the vente "force deleted" event.
     */
    public function forceDeleted(vente $vente): void
    {
        //
    }
}
