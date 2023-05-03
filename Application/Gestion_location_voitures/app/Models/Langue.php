<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Langue extends Model
{
    use HasFactory;

    /**
     * Nom de la table associee au model
     *
     * @var string
     */
    protected $table = 'langues';

    /**
     * Nom de de(s) collones lier a la table
     *
     * @var string
     */
    protected $fillable = [
        'libelle',
        'nom',
    ];
}
