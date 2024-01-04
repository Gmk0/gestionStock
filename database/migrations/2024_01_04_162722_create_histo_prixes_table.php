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
        Schema::create('histo_prixes', function (Blueprint $table) {
            $table->id();

            $table->float('prix_pqt')->nullable();
            $table->float('prix_unit')->nullable();
            $table->float('taux')->nullable();
            $table->boolean('activer')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('histo_prixes');
    }
};
