<?php
namespace App\Enum;

enum UserCategorieEnum:string
{
    case ADMIN = 'administrateur';
    case GESTION = 'gestionnaire';
    case client = 'client';
}
