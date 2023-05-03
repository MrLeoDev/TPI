<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Redefinir le nom des timestamps
     *
     * @var string
     */
    const CREATED_AT = 'date_inscription';
    const UPDATED_AT = 'date_modification';
    const DELETED_AT = 'date_suppression';

    /**
     * Nom de la table associee au model
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password',
        'categorie',
        'montant_des_locations',
    ];

    /**
     * Les attributs qui doivent être masqués pour la sérialisation.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
}
