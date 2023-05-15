{{-- PAGE : CRÉATION / MODIFICATION DES COMPTES --}}
<x-app-layout>

    {{-- Nommer la page dans la tabulation --}}
    <x-slot name="namepage">{{ __('creation_modification_comptes.Title') }}</x-slot>

    {{-- S'assurer de la structure de la page --}}
    <div class="flex flex-col gap-5 pt-12 lg:py-12">

        {{-- On retrouve la catégorie des utilisateurs --}}
        {{-- S'il s'agit d'un client, la valeur du montant des locations également --}}
        <x-block-content class="{{ Auth::user()->categorie->value == 'Client' ? 'mx-auto' : '' }}">

            <div class="overflow-hidden shadow-xl rounded-2xl">

                {{-- Condition Blade : S'agit d'un gestionnaire ou d'un administrateur --}}
                @if (in_array(Auth::user()->categorie->value, ['Gestionnaire', 'Administrateur']))

                    {{-- La catégorie --}}
                    <div class="bg-white stat dark:border-4 dark:border-[#ab0800] dark:bg-[#c6c6c6] rounded-2xl">
                        <div class="stat-title lgmax:text-sm dark:text-black">{{ __('creation_modification_comptes.LabelCategorie') }}</div>
                        <div class="stat-value text-[#ab0800] lgmax:text-2xl">{{ Auth::user()->categorie->value }}</div>
                    </div>

                @else

                    {{-- Condition Blade : Sinon, on afficher la catégorie et le montant des locations --}}
                    <div class="stats dark:border-4 dark:border-[#ab0800] dark:bg-[#c6c6c6] rounded-2xl bg-white">

                        {{-- La catégorie --}}
                        <div class="stat">
                            <div class="stat-title lgmax:text-sm dark:text-black">{{ __('creation_modification_comptes.LabelCategorie') }}</div>
                            <div class="stat-value text-[#ab0800] justify-self-end lgmax:text-2xl">{{ Auth::user()->categorie->value }}</div>
                        </div>

                        {{-- Montant des locations --}}
                        <div class="border-[#ab0800] stat">
                            <div class="stat-title lgmax:text-sm dark:text-black">{{ __('creation_modification_comptes.LabelMotantDesLocations') }}</div>
                            <div class="stat-value text-[#ab0800] lgmax:text-2xl">{{ Auth::user()->montant_des_locations }} CHF</div>
                        </div>

                    </div>

                @endif

            </div>

        </x-block-content>

        {{-- On affiche un résumer des utilisateurs --}}
        {{-- Condition Blade : S'il s'agit d'un gestionnaire ou d'un administrateur --}}
        @if (in_array(Auth::user()->categorie->value, ['Gestionnaire', 'Administrateur']))

            <x-block-content>

                {{-- Condition Blade : S'il s'agit d'un administrateur --}}
                @if (Auth::user()->categorie->value == \App\Enum\UserCategorieEnum::ADMIN->value)

                    {{-- Boutton -> Modal : Ajouter un compte --}}
                    <div class="flex items-center justify-center my-4">
                        <label for="modalAjouter" class="inline-flex items-center px-4 py-2 bg-[#ab0800] border border-transparent rounded-md font-semibold text-xs text-white dark:text-white uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-red-500 focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            {{ __('creation_modification_comptes.btnAjoutCompte') }}
                        </label>
                    </div>

                    {{-- Alert d'erreur ou de réussite --}}
                    <x-alert-error :messages="session('ErreurAddUser')" class="my-2" />
                    <x-alert-success :messages="session('statutAddUser')" class="my-2" />

                @endif

                {{-- Affichage en GRID dans les cartes d'utilisateurs  --}}
                <div class="grid grid-flow-row gap-5 p-5 overflow-auto bg-white shadow-2xl dark:bg-[#c6c6c6] lgmax:max-h-60 lg:grid-flow-col lg:grid-rows-2 dark:border-4 dark:border-[#ab0800] rounded-2xl">

                    {{-- Alert d'erreur ou de réussite --}}
                    <x-alert-error :messages="session('statutErreur')" class="mt-2" />
                    <x-alert-success :messages="session('statutDeleteUpdate')" class="mt-2" />

                    {{-- Condition Blade : Permet de boucler les utilisateurs existants --}}
                    @foreach ($clients as $client)

                        <div class="border-4 min-w-max stats border-[#ab0800] smax:stats-vertical dark:bg-white">

                            {{-- Condition Blade : S'il s'agit d'un gestionnaire --}}
                            @if (Auth::user()->categorie->value == 'Gestionnaire')

                                {{-- Condition Balde : Si dans les utilisateurs se trouve un gestionnaire et/ou un administrateur --}}
                                @if (in_array($client->categorie->value, ['Gestionnaire', 'Administrateur']))

                                    {{-- La catégorie et le Prénom / Nom --}}
                                    <div class="stat">
                                        <div class="stat-title dark:text-black">{{ $client->categorie->value }}</div>
                                        <div class="stat-value text-[#ab0800] text-xl">{{ $client->prenom }} {{ $client->nom }}</div>
                                    </div>

                                @else

                                    {{-- La catégorie et le Prénom / Nom --}}
                                    <div class="stat">
                                        <div class="stat-title dark:text-black">{{ $client->categorie->value }}</div>
                                        <div class="stat-value text-[#ab0800] text-xl">{{ $client->prenom }} {{ $client->nom }}</div>
                                    </div>

                                    {{-- Montant des locations --}}
                                    <div class="border-[#ab0800] stat">
                                        <div class="stat-title dark:text-black">{{ __('creation_modification_comptes.LabelMotantDesLocations') }}</div>
                                        <div class="stat-value text-[#ab0800] text-xl justify-self-end">{{ $client->montant_des_locations }} CHF</div>
                                    </div>

                                @endif

                            @endif

                            {{-- S'il s'agit d'un administrateur on s'assure qu'il accede a ses fonctionalites --}}
                            {{-- Condition Blade : S'il s'agit d'un administrateur --}}
                            @if (Auth::user()->categorie->value == 'Administrateur')

                                {{-- On affiche les cartes de modification et de suppresion des utilisateurs --}}
                                <div class="stat">

                                    <div class="stat-title dark:text-black">{{ $client->categorie->value }}</div>
                                    <div class="stat-value text-[#ab0800] text-xl">{{ $client->prenom }} {{ $client->nom }}</div>

                                    <div class="flex flex-row gap-2 mt-3 rounded-xl">

                                            {{-- Modifier --}}
                                            <a href="javascript:void(0)" id="showUserToUpdate" data-url="{{ route('CMC.showUpdateUser',['id' => $client->id]) }}">

                                                <button class="h-8 min-h-0 px-2 text-black btn hover:bg-gray-400 bg-[#c6c6c6]">
                                                    {{ __('creation_modification_comptes.btnModifier') }}
                                                </button>

                                            </a>

                                            {{-- Supprimer un utilisateur --}}
                                            <form action="{{ route('CMC.delete', ['id' => $client->id]) }}" method="post" name="formDelete">
                                                @csrf
                                                <button type="submit" name="FormDelete" class="h-8 min-h-0 px-2 text-white bg-red-700 btn hover:bg-red-400">
                                                    {{ __('creation_modification_comptes.btnSupprimer') }}
                                                </button>
                                            </form>

                                    </div>

                                </div>
                            @endif

                        </div>

                    @endforeach

                </div>

            </x-block-content>

        @endif


        {{-- Information personnelles / Mise a jour du mot de passe --}}
        <x-block-content>

            <div class="overflow-hidden sm:rounded-lg">

                <div class="card lg:card-side bg-white dark:bg-[#c6c6c6] dark:border-4 dark:border-[#ab0800]">

                    <div class="card-body">

                        <div>
                            <h2 class="card-title dark:text-black">{{ __('creation_modification_comptes.LabelInformationPerso') }}</h2>
                            <x-alert-error :messages="$errors->get('prenom')" class="mt-2" />
                            <x-alert-success :messages="session('statutInfoPerso')" class="mt-2" />
                        </div>

                        {{-- Condition Blade : S'il s'agit d'un administrateur --}}
                        @if (Auth::user()->categorie->value == 'Administrateur')

                            {{-- Formulaire pour modifier ses informations personnelles --}}
                            <form action="{{ route('CMC.updateInfoPerso') }}" method="POST" class="flex flex-col justify-between gap-4">

                                {{-- TOKEN BLADE --}}
                                @csrf

                                {{-- Prenom --}}
                                <div>
                                    <x-input-label for="prenom" :value="__('creation_modification_comptes.LabelPrenom')" :obligatoire=true />
                                    <x-text-input id="prenom" name="prenom" type="text" class="block w-full mt-1" value="{{ Auth::user()->prenom }}" />
                                    <x-input-error :messages="$errors->get('prenom')" class="mt-2" />
                                </div>

                                {{-- Nom --}}
                                <div>
                                    <x-input-label for="nom" :value="__('creation_modification_comptes.LabelNom')" :obligatoire=true />
                                    <x-text-input id="nom" name="nom" type="text" class="block w-full mt-1" value="{{ Auth::user()->nom }}" />
                                    <x-input-error :messages="$errors->get('nom')" class="mt-2" />
                                </div>

                                {{-- Email --}}
                                <div>
                                    <x-input-label for="email" :value="__('creation_modification_comptes.LabelEmail')" :obligatoire=true />
                                    <x-text-input id="email" name="email" type="email" class="block w-full mt-1" value="{{ Auth::user()->email }}" />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>

                                {{-- Boutton : Mettre à jour --}}
                                <div class="flex items-center justify-end mt-4">
                                    <x-primary-button>
                                        {{ __('creation_modification_comptes.btnUpdate') }}
                                    </x-primary-button>
                                </div>

                            </form>

                        @else

                            {{-- Affichage des informations personnelles --}}
                            <div class="flex flex-col justify-between gap-4">
                                <div>
                                    <h3 class="dark:text-black">{{ __('creation_modification_comptes.LabelPrenom') }}</h3>
                                    <h1 class="text-[#ab0800] text-2xl smax:text-xl lg:text-3xl font-bold">{{ Auth::user()->prenom }}</h1>
                                </div>

                                <div>
                                    <h3 class="dark:text-black">{{ __('creation_modification_comptes.LabelNom') }}</h3>
                                    <h1 class="text-[#ab0800] text-2xl smax:text-xl lg:text-3xl font-bold">{{ Auth::user()->nom }}</h1>
                                </div>

                                <div>
                                    <h3 class="dark:text-black">{{ __('creation_modification_comptes.LabelEmail') }}</h3>
                                    <h1 class="text-[#ab0800] text-2xl smax:text-xl lg:text-3xl font-bold">{{ Auth::user()->email }}</h1>
                                </div>
                            </div>

                        @endif

                    </div>

                    {{-- Bar de séparation --}}
                    <x-divider></x-divider>

                    <div class="card-body">

                        <div>
                            <h2 class="card-title dark:text-black">{{ __('creation_modification_comptes.LabelMajMdp') }}</h2>
                            <p class="text-red-300 dark:text-red-600">{{ __('creation_modification_comptes.LabelMajMdpDescription') }}</p>
                            <x-alert-error :messages="$errors->get('password')" class="mt-2" />
                            <x-alert-success :messages="session('statut')" class="mt-2" />
                        </div>

                        {{-- Formulaire pour mettre à jour son mot de passe --}}
                        <form method="POST" action="{{ route('CMC.update') }}">

                             {{-- TOKEN BLADE --}}
                            @csrf

                            <!-- Mot de passe -->
                            <div class="">
                                <x-input-label for="password" :value="__('creation_modification_comptes.LabelNewMdp')" :obligatoire=true />
                                <x-text-input id="password" name="password" type="password" class="block w-full mt-1" autocomplete="new-password" />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <!-- Confirmation du mot de passe -->
                            <div class="mt-4">
                                <x-input-label for="password_confirmation" :value="__('creation_modification_comptes.LabelConfirmMdp')" :obligatoire=true />
                                <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="block w-full mt-1" autocomplete="new-password" />
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>

                            {{-- Boutton : Mettre à jour --}}
                            <div class="flex items-center justify-end mt-4">
                                <x-primary-button name="FormUpdate">
                                    {{ __('creation_modification_comptes.btnUpdate') }}
                                </x-primary-button>
                            </div>

                        </form>

                    </div>
                </div>

            </div>

        </x-block-content>

    </div>

    <!-- Modal pour ajouter un compte -->
    <input type="checkbox" id="modalAjouter" class="modal-toggle" />
    <div class="modal">

        <div class="modal-box dark:bg-slate-400">

            <h2 class="card-title dark:text-black">{{ __('creation_modification_comptes.TitleA') }}</h2>
            <p class="text-red-300 dark:text-red-600">{{ __('creation_modification_comptes.DescriptionA') }}</p>

            {{-- Formulaire pour ajouter un utilisateur --}}
            <form action="{{ route('CMC.addUser') }}" method="POST" class="flex flex-col gap-5 mt-4">

                {{-- TOKEN BLADE --}}
                @csrf

                <div class="flex flex-row justify-between gap-5">
                    {{-- Prenom --}}
                    <div>
                        <x-input-label for="prenom" :value="__('creation_modification_comptes.LabelPrenom')" :obligatoire=true />
                        <x-text-input id="prenom" name="prenom" type="text" class="block w-full mt-1" :value="old('prenom')" required autofocus />
                        <x-input-error :messages="$errors->get('prenom')" class="mt-2" />
                    </div>

                    {{-- Nom --}}
                    <div>
                        <x-input-label for="nom" :value="__('creation_modification_comptes.LabelNom')" :obligatoire=true />
                        <x-text-input id="nom" name="nom" type="text" class="block w-full mt-1" :value="old('nom')" required />
                        <x-input-error :messages="$errors->get('nom')" class="mt-2" />
                    </div>
                </div>

                {{-- Email --}}
                <div>
                    <x-input-label for="email" :value="__('creation_modification_comptes.LabelEmail')" :obligatoire=true />
                    <x-text-input id="email" name="email" type="email" class="block w-full mt-1" :value="old('email')" required />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>


                <div class="flex flex-row justify-between gap-5">
                    <!-- Mot de passe -->
                    <div>
                        <x-input-label for="password" :value="__('creation_modification_comptes.LabelNewMdp')" :obligatoire=true />
                        <x-text-input id="password" name="password" type="password" class="block w-full mt-1" autocomplete="new-password" :value="old('password')" required />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirmation du mot de passe -->
                    <div>
                        <x-input-label for="password_confirmation" :value="__('creation_modification_comptes.LabelConfirmMdp')" :obligatoire=true />
                        <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="block w-full mt-1" autocomplete="new-password" required />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>
                </div>

                {{-- Choisir la catégorie du compte --}}
                <div>
                    <x-input-label for="categorie" :value="__('creation_modification_comptes.LabelCategorie')" :obligatoire=true />
                    <select id="categorie" name="categorie" class="w-full mt-1 select select-bordered dark:bg-white dark:text-black">
                        <option id="ChooseDisabled" disabled selected>{{ __('creation_modification_comptes.SelectDisabled') }}</option>
                        @foreach (\App\Enum\UserCategorieEnum::cases() as $categorie)
                            <option value="{{ $categorie->value }}">{{ $categorie->value }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('categorie')" class="mt-2" />
                </div>

                {{-- Bouton pour revenir ou ajouter un utilisateur --}}
                <div class="modal-action">
                    <label for="modalAjouter" class="btn">{{ __('creation_modification_comptes.btnRetour') }}</label>
                    <x-primary-button>
                        {{ __('creation_modification_comptes.btnAjouter') }}
                    </x-primary-button>
                </div>

            </form>

        </div>

    </div>

    <!-- Modal pour modifer un compte -->
    <input type="checkbox" id="modalModifier" class="modal-toggle" />
    <div class="modal">

        <div class="modal-box dark:bg-slate-400">

            <h2 id="TitleModifier" class="card-title dark:text-black"></h2>
            <p class="text-red-300 dark:text-red-600">{{ __('creation_modification_comptes.DescriptionM') }}</p>

            {{-- Formulaire pour modifier un utilisateur --}}
            <form id="formUpdate" method="POST" class="flex flex-col gap-5 mt-4">

                {{-- TOKEN BLADE --}}
                @csrf

                <div class="flex flex-row justify-between gap-5">
                    {{-- Prenom --}}
                    <div>
                        <x-input-label for="Uprenom" :value="__('creation_modification_comptes.LabelPrenom')"/>
                        <x-text-input id="Uprenom" name="prenom" type="text" class="block w-full mt-1" required autofocus />
                        <x-input-error :messages="$errors->get('prenom')" class="mt-2" />
                    </div>

                    {{-- Nom --}}
                    <div>
                        <x-input-label for="Unom" :value="__('creation_modification_comptes.LabelNom')"/>
                        <x-text-input id="Unom" name="nom" type="text" class="block w-full mt-1" />
                        <x-input-error :messages="$errors->get('nom')" class="mt-2" />
                    </div>
                </div>

                {{-- Email --}}
                <div>
                    <x-input-label for="Uemail" :value="__('creation_modification_comptes.LabelEmail')"/>
                    <x-text-input id="Uemail" name="email" type="email" class="block w-full mt-1" required />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>


                <div class="flex flex-row justify-between gap-5">
                    <!-- Mot de passe -->
                    <div>
                        <x-input-label for="Upassword" :value="__('creation_modification_comptes.LabelNewMdp')" />
                        <x-text-input id="Upassword" name="password" type="password" class="block w-full mt-1" autocomplete="new-password" />
                    </div>

                    <!-- Confirmation du mot de passe -->
                    <div>
                        <x-input-label for="Upassword_confirmation" :value="__('creation_modification_comptes.LabelConfirmMdp')" />
                        <x-text-input id="Upassword_confirmation" name="password_confirmation" type="password" class="block w-full mt-1" autocomplete="new-password" />
                    </div>
                </div>

                {{-- Modifier la categorie du compte --}}
                <div>
                    <x-input-label for="Ucategorie" :value="__('creation_modification_comptes.LabelCategorie')"/>
                    <select id="Ucategorie" name="categorie" class="w-full mt-1 select select-bordered dark:bg-white dark:text-black">
                        @foreach (\App\Enum\UserCategorieEnum::cases() as $categorie)
                            <option value="{{ $categorie->value }}">{{ $categorie->value }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('categorie')" class="mt-2"  />
                </div>

                {{-- Bouton pour revenir ou modifier le compte --}}
                <div class="modal-action">
                    <label for="modalModifier" class="btn">{{ __('creation_modification_comptes.btnRetour') }}</label>
                    <x-primary-button>
                        {{ __('creation_modification_comptes.btnModifier') }}
                    </x-primary-button>
                </div>

            </form>

        </div>

    </div>

    {{-- Integration du code JS pour l'utilisation de AJAX via MODAL --}}
    <script type="module">

        // On attend que le DOM soit prêt pour le JS
        $(document).ready(function () {

            /* Quand on clique sur Modifier */
            $('body').on('click', '#showUserToUpdate', function () {
                var userURL = $(this).data('url');

                // AJAX par méthode GET par une route LARAVEL
                $.get(userURL, function (data)
                {
                    // Ouvrir le modal "DaisyUi"
                    $('#modalModifier').prop("checked", true);

                    // Title Modifier
                    $('#TitleModifier').text("{{ __('creation_modification_comptes.TitleM') }}" + data.prenom + " " + data.nom);

                    // Forms Modifier
                    $('#formUpdate').attr('action', "{{ route('CMC.updateUser','')}}"+"/" + data.id)
                    $('#Uprenom').attr('value',data.prenom);
                    $('#Uprenom').attr('placeholder',data.prenom);
                    $('#Unom').attr('value',data.nom);
                    $('#Unom').attr('placeholder',data.nom);
                    $('#Uemail').attr('value',data.email);
                    $('#Uemail').attr('placeholder',data.email);
                    $("#Ucategorie").val(data.categorie).change();
                })
            });

            // Fermer le modal en reload pour forcer l'AJAX d'intervenir
            if (window.performance.getEntriesByType("navigation")[0].type == 'reload')
            {
                $('#modalModifier').prop("checked", false);
            }

        });
    </script>

</x-app-layout>
