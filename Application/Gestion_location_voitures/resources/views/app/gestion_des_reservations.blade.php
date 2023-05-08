<x-app-layout>

    <x-slot name="namepage">{{ __('gestion_des_reservations.Title') }}</x-slot>

    <div class="flex flex-row gap-5 py-12">

        {{-- Reste jusqu'à ce que l'espcae manque --}}
        <aside class="sticky top-0 max-w-xs pt-5 mx-auto h-max lgmax:hidden sm:mx-5">

            @if (Auth::user()->categorie->value == \App\Enum\UserCategorieEnum::GESTION->value)

                <div class="shadow-xl card w-52 bg-white dark:bg-[#c6c6c6] border-4 border-[#ab0800] mb-3">

                    <div class="p-4 card-body">

                        <h2 class="mx-auto card-title">CLIENTS</h2>

                        <div class="flex flex-col gap-3">

                            {{-- Clients --}}
                            <div class="w-full">
                                <select id="client_selected" name="client_selected" class="w-full mt-1 select select-bordered dark:bg-white dark:text-black" required>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->prenom }} {{ $client->nom }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                    </div>

                </div>

            @endif

            <div class="shadow-xl card w-52 bg-white dark:bg-[#c6c6c6] border-4 border-[#ab0800]">
                <div class="p-4 card-body">
                    <h2 class="mx-auto card-title">FILTRE</h2>

                    <form action="{{ route('GdR') }}" method="GET">

                        <div class="flex flex-col gap-3">

                            {{-- Type du véhicule --}}
                            <div class="w-full">
                                <x-input-label for="type" :value="__('gestion_de_la_flotte.LabelType')"/>
                                <select id="type" name="type" class="w-full mt-1 select select-bordered dark:bg-white dark:text-black">
                                    {{-- <option value="0" selected>Tous</option> --}}
                                    <option value="0" selected>Tous</option>
                                    @foreach (\App\Enum\VehiculeTypeEnum::cases() as $type)
                                        <option value="{{ $type->value }}" {{ old('type') == $type->value ? 'selected' : '' }}>{{ $type->value }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Statut du véhicule --}}
                            <div class="w-full">
                                <x-input-label for="transmission" :value="'Transmission'"/>
                                <select id="transmission" name="transmission" class="w-full mt-1 select select-bordered dark:bg-white dark:text-black">
                                    <option value="0">Les deux</option>
                                    @foreach (\App\Enum\VehiculeTransmissionEnum::cases() as $transmission)
                                        <option value="{{ $transmission->value }}" {{ old('transmission') == $transmission->value ? 'selected' : '' }}>{{ $transmission->value }}</option>
                                    @endforeach

                                </select>
                            </div>

                        </div>

                        <div class="justify-center mt-3 card-actions">
                            <x-primary-button>
                                RECHERCHER
                            </x-primary-button>
                        </div>

                    </form>

                </div>
            </div>
        </aside>

        <x-block-content class="mx-auto">

            <div class="max-w-md mx-auto mb-5 bg-white shadow-xl card dark:bg-[#c6c6c6] dark:border-4 dark:border-[#ab0800]">
                <div class="p-4 card-body">
                    <h2 class="mx-auto text-center card-title text-[#ab0800] text-3xl smax:text-2xl">Véhicules disponibles</h2>

                    @if (Auth::user()->categorie->value == \App\Enum\UserCategorieEnum::GESTION->value)

                        <div class="shadow-xl card w-52 bg-white dark:bg-[#c6c6c6] border-4 border-[#ab0800] mb-3 lg:hidden mx-auto">

                            <div class="p-4 card-body">

                                <h2 class="mx-auto card-title">CLIENTS</h2>

                                <div class="flex flex-col gap-3">

                                    {{-- Clients --}}
                                    <div class="w-full">
                                        <select id="client_selected" name="client_selected" class="w-full mt-1 select select-bordered dark:bg-white dark:text-black" required>
                                            @foreach ($clients as $client)
                                                <option value="{{ $client->id }}">{{ $client->prenom }} {{ $client->nom }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>

                            </div>

                        </div>

                    @endif

                    <div class="shadow-xl card bg-white border-4 border-[#ab0800] lg:hidden">
                        <div class="card-body">

                            <h2 class="mx-auto card-title">FILTRE</h2>

                            <form action="{{ route('GdR') }}" method="GET">

                                <div class="flex flex-col gap-3 sm:flex-row">

                                    {{-- Type du véhicule --}}
                                    <div class="w-full">
                                        <x-input-label for="type" :value="__('gestion_de_la_flotte.LabelType')"/>
                                        <select id="type" name="type" class="w-full mt-1 select select-bordered dark:bg-white dark:text-black">
                                            <option value="0" selected>Tous</option>
                                            @foreach (\App\Enum\VehiculeTypeEnum::cases() as $type)
                                                <option value="{{ $type->value }}" {{ old('type') == $type->value ? 'selected' : '' }}>{{ $type->value }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Statut du véhicule --}}
                                    <div class="w-full">
                                        <x-input-label for="transmission" :value="'Transmission'"/>
                                        <select id="transmission" name="transmission" class="w-full mt-1 select select-bordered dark:bg-white dark:text-black">
                                            <option value="0">Les deux</option>
                                            @foreach (\App\Enum\VehiculeTransmissionEnum::cases() as $transmission)
                                                <option value="{{ $transmission->value }}" {{ old('transmission') == $transmission->value ? 'selected' : '' }}>{{ $transmission->value }}</option>
                                            @endforeach

                                        </select>
                                    </div>

                                </div>

                                <div class="justify-center mt-3 card-actions">
                                    <x-primary-button>
                                        RECHERCHER
                                    </x-primary-button>
                                </div>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

            <div class="flex flex-row flex-wrap justify-between gap-5 overflow-hidden sm:rounded-lg smax:max-w-xs">
                @forelse ($vehicules as $key => $vehicule)
                    <div class="mx-auto shadow-xl smax:max-w-xs card lg:card-side bg-white border-4 border-[#ab0800]">

                        <div class="card-body lg:pr-0 lgmax:pb-0">
                            <img src="{{ asset($vehicule->image) }}" alt="{{ $vehicule->id }}" class="mx-auto sm:max-w-xs rounded-xl" />
                            <div class="flex flex-col flex-wrap w-full">
                                <div class="flex flex-row flex-wrap gap-3 text-3xl font-bold text-red-600">
                                    <p class="text-end">{{ $vehicule->marque->libelle }}</p>
                                    <p class="text-start">{{ $vehicule->modele->libelle }}</p>
                                </div>
                                <div class="mx-auto text-3xl font-bold text-red-600">
                                    <p class="text-center">{{ $vehicule->type }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="before:bg-[#ab0800] after:bg-[#ab0800] divider lg:divider-horizontal mr-1 ml-1"></div>

                        <div class="lg:pl-0 lgmax:pt-0 card-body">

                            <form id="formReservation" action="{{ route('GdR.bookCar') }}" method="POST" class="flex flex-col justify-between h-full lgmax:gap-2">
                                @csrf
                                {{-- Durée de la location --}}
                                <div>
                                    <h2 class="mx-auto text-lg text-center">Durée de la location</h2>
                                    <div class="flex flex-row justify-center gap-3">
                                        <x-text-input id="DureeLocation" name="duree_location"
                                                        type="number" min="1" class="block w-20"
                                                        value="0"
                                                        data-key="{{ $key + 1 }}" data-tarifj="{{ $vehicule->tarif_journalier }}" required />
                                        <label for="DureeLocation" class="my-auto">Jours</label>
                                    </div>
                                </div>

                                {{-- Montant de la location --}}
                                <div>
                                    <h2 class="mx-auto text-lg text-center">Montant de la location</h2>
                                    <h2 id="montant{{ $key + 1 }}" class="mx-auto text-lg text-center">0 CHF</h2>
                                </div>

                                {{-- Tarif journalière --}}
                                <div>
                                    <h2 class="mx-auto text-lg text-center">Tarif journalière</h2>
                                    <h2 id="tarifJ" class="mx-auto text-lg text-center">{{ $vehicule->tarif_journalier }} CHF</h2>
                                </div>

                                {{-- Uniquement si on est gestionnaire, la valeur se met à jour selon la selction du client --}}
                                @if (Auth::user()->categorie->value == \App\Enum\UserCategorieEnum::GESTION->value)
                                    <input id="client_id" type="hidden" name="client_id" value="">
                                @endif

                                <input type="hidden" name="vehicule_id" value="{{ $vehicule->id }}">

                                <div class="justify-center card-actions">
                                    <x-primary-button>
                                        RESERVER
                                    </x-primary-button>
                                </div>

                            </form>


                        </div>
                    </div>
                @empty
                    {{-- Aucun vehicule disponible --}}
                    <div class="max-w-md mx-auto mb-5 bg-white shadow-xl card dark:bg-[#c6c6c6] dark:border-4 dark:border-[#ab0800]">
                        <div class="p-4 card-body">
                            <h2 class="mx-auto text-center card-title text-[#ab0800] text-3xl smax:text-2xl">Il n'y a plus de vehicule disponible!</h2>
                        </div>
                    </div>
                @endforelse

            </div>

        </x-block-content>

    </div>

    <script type="module">
        $(document).ready(function () {

            // Au premier chargement de la page
            $('#client_id').attr('value', $('#client_selected').val());

            // Mettre a jour la valeur de l'input client fantome si gestionnaire
            $('[id=client_selected]').change(function(){
                $('#client_id').attr('value', $(this).val());
            });

            // Mettre à jours le montant de la location
            $("input[type=number]").change(function(){
                // On récupère la valeur
                var duree = parseFloat($(this).val());
                var tarifj = parseFloat($(this).data('tarifj'));
                var key = $(this).data('key');
                var montant = 0;

                // Gerer le résultat du montant
                if (isNaN(duree*tarifj) || duree < 0)
                {
                    montant = 0;
                }
                else
                {
                    if (duree >= 7)
                    {
                        if (duree >= 30)
                        {
                            montant = ((duree*tarifj) - ((duree * tarifj) * (20/100)));
                        }
                        else
                        {
                            montant = ((duree*tarifj) - ((duree * tarifj) * (10/100)));
                        }
                    }
                    else
                    {
                        montant = duree * tarifj;
                    }
                }

                // Appliquer le résultat
                $('#montant' + key).text(montant + " CHF");
            });
        });
    </script>
</x-app-layout>
