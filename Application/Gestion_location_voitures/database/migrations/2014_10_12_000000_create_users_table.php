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
        Schema::create('users', function (Blueprint $table) {
            /**
             * Cle primaire
             */
            $table->id();

            /**
             * Colonne concernant l'utilisateur
             */
            $table->string('nom');
            $table->string('prenom');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('categorie', ['Administrateur', 'Gestionnaire', 'Client']);
            $table->decimal('montant_des_locations', 10,2)->default(0);

            /**
             * Date : Creation / Modification / Suppression
             */
            $table->timestamp('date_inscription');
            $table->timestamp('date_modification');
            $table->softDeletes('date_suppression');

            /**
             * Se rappeler de l'utilisateur
             */
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
