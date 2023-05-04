<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Categorie
{
    /**
     * Vérification des droits d'accès
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ... $categories): Response
    {
        // On parcours les categories donnees en argument
        foreach($categories as $categorie)
        {
            // On s'assure si l'utilisateur a bien la categorie demandé
            if(Auth::user()->categorie->value == $categorie)
            {
                return $next($request);
            }
        }
        return redirect()->route('CMC');
    }
}
