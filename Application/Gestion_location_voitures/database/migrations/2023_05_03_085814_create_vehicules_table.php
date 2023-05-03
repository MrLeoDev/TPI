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
        Schema::create('vehicules', function (Blueprint $table) {
            /**
             * Cle primaire
             */
            $table->id();

            /**
             * Cle Etrangere
             */
            $table->unsignedBigInteger('modele_id');
            $table->unsignedBigInteger('marque_id');

            /**
             * Colonne concernant l'utilisateur
             */
            $table->string('image');
            $table->enum('type', ['Berline', 'Break', 'SUV', 'Monospace']);
            $table->enum('transmission', ['Manuel', 'Automatique']);
            $table->enum('statut', ['Disponible', 'En révision', 'Hors_d_usage', 'Loué']);
            $table->decimal('tarif_journalier', 10,2)->default(0);

            /**
             * Date : Creation / Modification / Suppression
             */
            $table->timestamp('date_inscription');
            $table->timestamp('date_modification');
            $table->softDeletes('date_suppression');

            /**
             * Indication de la clé étrangère
             */
            $table->foreign('modele_id', 'FK_VEHICULE_MODELE')->references('id')->on('modeles')->onDelete('cascade');
            $table->foreign('marque_id', 'FK_VEHICULE_MARQUE')->references('id')->on('marques')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicules');
    }
};
