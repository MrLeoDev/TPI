<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
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
    protected $table = 'locations';

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'date_debut',
        'date_fin',
    ];

    /**
     * Recuperer le vehicule qui sera loue
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vehicule()
    {
        return $this->belongsTo(Vehicule::class, 'vehicule_id');
    }

    /**
     * Recuperer le client qui souhaite loue
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
}
