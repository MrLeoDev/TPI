<?php
namespace App\Enum;

enum VehiculeStatutEnum:string
{
    case DISPO = 'Disponible';
    case REVISION = 'En révision';
    case HORSU = 'Hors d’usage';
    case LOUER = 'Loué';
}
