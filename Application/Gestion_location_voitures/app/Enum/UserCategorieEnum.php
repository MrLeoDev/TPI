<?php
namespace App\Enum;

enum UserCategorieEnum:string
{
    case ADMIN = 'Administrateur';
    case GESTION = 'Gestionnaire';
    case CLIENT = 'Client';
}
