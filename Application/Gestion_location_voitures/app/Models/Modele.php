<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modele extends Model
{
    use HasFactory;

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
    protected $table = 'modeles';

    /**
     * Nom de de(s) collones lier a la table
     *
     * @var string
     */
    protected $fillable = [
        'libelle',
    ];
}
