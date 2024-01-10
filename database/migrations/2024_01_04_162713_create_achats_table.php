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
        Schema::create('achats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produit_id');
            $table->float('qte_pqt')->nullable();
            $table->float('montant')->nullable();
            $table->dateTime('date_paiement')->nullable();
            $table->enum('status',['Livre','en attente'])->default('en attente');
            $table->string('illustration')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('achats');
    }
};
