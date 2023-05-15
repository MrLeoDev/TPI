<?php

namespace App\Http\Controllers;

use App\Enum\UserCategorieEnum;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class CmcController extends Controller
{
    /**
     * On retourne la page Creation / Modification de comptes
     *
     * @return \Illuminate\Contracts\View\View returned
     */
    public function index()
    {
        // On recuperes tout les clients si on est admin ou gestionnaire
        if (in_array(Auth::user()->categorie->value, ['Gestionnaire', 'Administrateur']))
        {
            $clients = User::where('id','!=',Auth::user()->id)
                            ->orderByRaw("FIELD(categorie , 'Client', 'Gestionnaire', 'Administrateur') ASC")
                            ->get();
        }

        return view('app.creation_modification_comptes')
                ->with('clients', $clients ?? null);
    }

    /**
     * Ajouter un utilisateur
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse returned
     */
    public function addUser(Request $request)
    {
        $request->validate([
            'prenom'            => ['required', 'string', 'max:255'],
            'nom'               => ['required', 'string', 'max:255'],
            'email'             => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'          => ['required', 'confirmed', Password::defaults()],
            'categorie'         => ['required', Rule::in(UserCategorieEnum::ADMIN->value,UserCategorieEnum::GESTION->value,UserCategorieEnum::CLIENT->value)]
        ]);

        $user = new User();
        $user->email                = $request->email;
        $user->nom                  = $request->nom;
        $user->prenom               = $request->prenom;
        $user->password             = Hash::make($request->password);
        $user->categorie            = $request->categorie;
        $user->save();

        return back()->with('statutAddUser', trans('creation_modification_comptes.StatutaddUser'));
    }

    /**
     * Mise à jour des informations d'un utilisateur
     *
     * @param Request $request
     * @param [type] $id
     * @return \Illuminate\Http\RedirectResponse returned
     */
    public function updateUser(Request $request, $id)
    {
        // S'assure que la demande est faisable
        try {
            $user = User::findOrFail($id);
            $request->validate([
                'prenom'            => ['nullable', 'string', 'max:255'],
                'nom'               => ['nullable','string', 'max:255'],
                'email'             => ['nullable','string', 'email', 'max:255', Rule::unique('users')->ignore($id)],
                'password'          => ['nullable','confirmed',Password::defaults()],
                'categorie'         => ['nullable',Rule::in(UserCategorieEnum::ADMIN->value,UserCategorieEnum::GESTION->value,UserCategorieEnum::CLIENT->value)]
            ]);

        } catch (\Throwable $th)
        {
            return back()->with('statutErreur', trans('creation_modification_comptes.StatutError'));
        }

        $user->email                = $request->email ?? $user->email;
        $user->nom                  = $request->nom ?? $user->nom;
        $user->prenom               = $request->prenom ?? $user->prenom;
        $user->password             = Hash::make($request->password) ?? $user->password;
        $user->categorie            = $request->categorie ?? $user->categorie;
        // On recupere le nom de l'utilisateur
        $userName = $user->prenom . " " . $user->nom;

        $user->save();



        return back()->with('statutDeleteUpdate', trans('creation_modification_comptes.StatutupdateUser', ['nom' => $userName]));
    }

    /**
     * On renvoi les données necessaire pour l'affichage
     * des informations d'un utilisateur séléctionner
     *
     * @param [type] $id
     * @return \Illuminate\Http\JsonResponse returned
     */
    public function showUpdateUser($id)
    {
        $data = User::findOrFail($id);
        return response()->json($data);
    }

    /**
     * Mettre à jour le mot de passe du compte
     *
     * @param Request $request
     * @return
     */
    public function update(Request $request)
    {
        $request->validate([
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('statut', trans('creation_modification_comptes.StatutupdateMdp'));
    }

    /**
     *
     * Pouvoir supprimer un utilisateur
     *
     * @category Administrateur
     * @param [type] $id
     * @return \Illuminate\Http\RedirectResponse returned
     */
    public function delete($id)
    {
        // S'assure que la demande est faisable
        try {
            $user = User::findOrFail($id);
        } catch (\Throwable $th)
        {
            return back()->with('statutErreur', trans('creation_modification_comptes.StatutError'));
        }

        // On recupere le nom de l'utilisateur
        $userName = $user->prenom . " " . $user->nom;

        // On supprime l'utilisateur
        $user->delete();

        return back()->with('statutDeleteUpdate', trans('creation_modification_comptes.StatutdeleteUser', ['nom' => $userName]));
    }

    /**
     * Mettre à jour les informations personnelles de l'administrateur
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse returned
     */
    public function updateInfoPerso(Request $request)
    {
        $request->validate([
            'prenom'            => ['nullable', 'string', 'max:255'],
            'nom'               => ['nullable','string', 'max:255'],
            'email'             => ['nullable','string', 'email', 'max:255', Rule::unique('users')->ignore(Auth::user()->id)],
        ]);

        $user = User::findOrFail(Auth::user()->id);
        $user->email = $request->email ?? $user->email;
        $user->nom = $request->nom ?? $user->nom;
        $user->prenom = $request->prenom ?? $user->prenom;
        $user->save();

        return back()->with('statutInfoPerso', trans('creation_modification_comptes.StatutInfoPerso'));
    }

}
