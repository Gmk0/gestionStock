<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ventes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produit_id');
            $table->float('qte_pc')->nullable();
            $table->float('qte_pqt')->nullable();
            $table->float('montant')->nullable();
            $table->foreignId('histoPrix_id')->nullable();
            $table->dateTime('date_vente')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventes');
    }
};
