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
        Schema::create('locations', function (Blueprint $table) {
            /**
             * Cle primaire
             */
            $table->id();

            /**
             * Cle Etrangere
             */
            $table->string('vehicule_id');
            $table->unsignedBigInteger('client_id');

            /**
             * Colonne concernant l'utilisateur directement
             */
            $table->date('date_debut')->nullable();
            $table->date('date_fin')->nullable();

            /**
             * Date : Creation / Modification / Suppression
             */
            $table->timestamp('date_inscription');
            $table->timestamp('date_modification');
            $table->softDeletes('date_suppression');

            /**
             * Indication de la clé étrangère
             */
            $table->foreign('vehicule_id', 'FK_LOCATION_VEHICULE')->references('id')->on('vehicules')->onDelete('cascade');
            $table->foreign('client_id', 'FK_LOCATION_CLIENT')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
