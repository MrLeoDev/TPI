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
        Schema::create('modeles', function (Blueprint $table) {
            /**
             * Cle primaire
             */
            $table->id();

            /**
             * Colonne concernant l'utilisateur
             */
            $table->string('libelle')->unique();

            /**
             * Date : Creation / Modification / Suppression
             */
            $table->timestamp('date_inscription');
            $table->timestamp('date_modification');
            $table->softDeletes('date_suppression');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modeles');
    }
};
