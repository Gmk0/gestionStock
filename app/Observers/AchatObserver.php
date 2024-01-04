<?php

namespace App\Observers;

use App\Models\Achat;
use App\Models\Produit;

class AchatObserver
{
    /**
     * Handle the Achat "created" event.
     */
    public function created(Achat $achat): void
    {
        //

        $produit=Produit::find($achat->produit_id);

        $produit->qte_pqt += $achat->qte_pqt;
        $produit->qte_pc += $achat->qte_pqt *12;

        $produit->update();
    }

    /**
     * Handle the Achat "updated" event.
     */
    public function updated(Achat $achat): void
    {
        //
    }

    /**
     * Handle the Achat "deleted" event.
     */
    public function deleted(Achat $achat): void
    {
        //

        $produit = Produit::find($achat->produit_id);

        $produit->qte_pqt -= $achat->qte_pqt;
        $produit->qte_pc -= $achat->qte_pqt * 12;

        $produit->update();
    }

    /**
     * Handle the Achat "restored" event.
     */
    public function restored(Achat $achat): void
    {
        //
    }

    /**
     * Handle the Achat "force deleted" event.
     */
    public function forceDeleted(Achat $achat): void
    {
        //
    }
}
