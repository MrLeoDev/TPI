<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicule extends Model
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
    protected $table = 'vehicules';
    protected $primaryKey = 'id';

    /**
     * Annuler l'aut-increment
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'image',
        'type',
        'transmission',
        'statut',
        'tarif_journalier',
    ];

    /**
     * Recuperer le modele du vehicule
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function modele()
    {
        return $this->belongsTo(Modele::class, 'modele_id');
    }

    /**
     * Recuperer la marque du vehicule
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function marque()
    {
        return $this->belongsTo(Marque::class, 'marque_id');
    }
}
