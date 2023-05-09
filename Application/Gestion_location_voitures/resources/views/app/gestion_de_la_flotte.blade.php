<x-app-layout>

    {{-- Nommer la page dans la tabulation --}}
    <x-slot name="namepage">{{ __('gestion_de_la_flotte.Title') }}</x-slot>

    <div class="flex flex-col gap-5 py-12">

        {{-- On verifie la categorie du compte pour lui permettre l'acces a l'ajout d'un vehicule --}}
        @if (Auth::user()->categorie->value == \App\Enum\UserCategorieEnum::GESTION->value)

            {{-- Ajout d'un véhicule --}}
            <x-block-content>

                <div class="max-w-md mx-auto mb-5 bg-white shadow-xl card dark:bg-[#c6c6c6] dark:border-4 dark:border-[#ab0800]">
                    <div class="p-4 card-body">
                    <h2 class="mx-auto text-center card-title text-[#ab0800] text-3xl smax:text-2xl">{{ __('gestion_de_la_flotte.TitleCardAV') }}</h2>
                    </div>
                </div>

                <x-alert-error :messages="$errors->get('vehicule_image')" class="my-2" />
                <x-alert-success :messages="session('statutAddCar')" class="my-2" />

                <div class="overflow-hidden sm:rounded-lg">

                    <form action="{{ route('GdF.addCar') }}" method="POST" class="card lg:card-side bg-white dark:bg-[#c6c6c6] dark:border-4 dark:border-[#ab0800]" enctype="multipart/form-data">

                        @csrf

                        <div class="card-body">
                            <h2 class="mx-auto card-title dark:text-black">{{ __('gestion_de_la_flotte.TitleImage') }}</h2>
                            {{-- Image du véhicule --}}
                            <img id="image_preview" src=""alt="En attente d'un image..." class="max-w-xs mx-auto text-red-500 rounded-lg smax:m-3">
                            <input
                                id="vehicule_image"
                                type="file"
                                class="w-full file-input file-input-bordered file-input-error dark:bg-white"
                                name="vehicule_image">
                        </div>

                        <x-divider></x-divider>

                        <div class="card-body">

                            <h2 class="mx-auto text-center card-title dark:text-black">{{ __('gestion_de_la_flotte.TitleInfoV') }}</h2>

                            <div class="flex flex-col gap-2 mt-4">

                                <div class="flex flex-row justify-center smax:flex-wrap sm:justify-between sm:gap-5 smax:gap-3">

                                    {{-- Identifiant --}}
                                    <div>
                                        <x-input-label for="id" :value="__('gestion_de_la_flotte.LabelID')" />
                                        <x-text-input id="id" name="id" type="text" class="block w-full mt-1" />
                                    </div>

                                    {{-- Tarif journalier --}}
                                    <div>
                                        <x-input-label for="tarifj" :value="__('gestion_de_la_flotte.LabelTarifJ')" />
                                        <x-text-input id="tarifj" name="tarifj" type="text" class="block w-full mt-1" />
                                    </div>

                                </div>

                                <div class="flex flex-row justify-center smax:flex-wrap sm:justify-between sm:gap-5 smax:gap-3">

                                    {{-- Marque du véhicule --}}
                                    <div>
                                        <x-input-label for="marque" :value="__('gestion_de_la_flotte.LabelMarque')"/>
                                        <x-text-input id="marque" list="marqueList" type="text" name="marque"/>
                                        <datalist id="marqueList">
                                            @forelse ($marques as $marque)
                                                <option value="{{ $marque->libelle }}">
                                            @empty
                                                {{-- Aucune option --}}
                                            @endforelse
                                        </datalist>
                                    </div>

                                    {{-- Modèle du véhicule --}}
                                    <div>
                                        <x-input-label for="modele" :value="__('gestion_de_la_flotte.LabelModele')"/>
                                        <x-text-input id="modele" list="modeleList" type="text" name="modele"/>
                                        <datalist id="modeleList">
                                            @forelse ($modeles as $modele)
                                                <option value="{{ $modele->libelle }}">
                                            @empty
                                                {{-- Aucune option --}}
                                            @endforelse
                                        </datalist>
                                    </div>

                                </div>

                                <div class="flex flex-row smax:flex-wrap smax:justify-center sm:gap-5 smax:gap-3">

                                    {{-- Type du véhicule --}}
                                    <div class="w-full">
                                        <x-input-label for="type" :value="__('gestion_de_la_flotte.LabelType')"/>
                                        <select id="type" name="type" class="w-full mt-1 select select-bordered dark:bg-white dark:text-black">
                                            @foreach (\App\Enum\VehiculeTypeEnum::cases() as $type)
                                                <option value="{{ $type->value }}">{{ $type->value }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Statut du véhicule --}}
                                    <div class="w-full">
                                        <x-input-label for="statut" :value="__('gestion_de_la_flotte.LabelStatut')"/>
                                        <select id="statut" name="statut" class="w-full mt-1 select select-bordered dark:bg-white dark:text-black">

                                            @foreach (\App\Enum\VehiculeStatutEnum::cases() as $statut)
                                                @if ($statut->value != \App\Enum\VehiculeStatutEnum::LOUER->value)
                                                    <option value="{{ $statut->value }}">{{ $statut->value }}</option>
                                                @endif
                                            @endforeach

                                        </select>
                                    </div>

                                </div>

                                {{-- Radio Bouton pour choisir le type de transmission --}}
                                <div class="flex flex-row smax:justify-center smax:flex-wrap sm:gap-5 smax:gap-3">

                                    <div class="flex flex-row gap-3">
                                        <input id="Manuel" type="radio" name="transmission" class="radio dark:radio-error checked:bg-[#ab0800] checked:hover:bg-[#ab0800] checked:active:bg-[#ab0800] checked:focus:bg-[#ab0800] focus:bg-[#ab0800] focus:outline-none focus:ring-1 focus:ring-[#ab0800]" value="{{ App\Enum\VehiculeTransmissionEnum::MANUEL->value }}" checked />
                                        <x-input-label class="my-auto" for="Manuel" :value="__('gestion_de_la_flotte.LabelManuel')"/>
                                    </div>

                                    <div class="flex flex-row gap-3">
                                        <input id="Automatique" type="radio" name="transmission" class="radio dark:radio-error checked:bg-[#ab0800] checked:hover:bg-[#ab0800] checked:active:bg-[#ab0800] checked:focus:bg-[#ab0800] focus:bg-[#ab0800] focus:outline-none focus:ring-1 focus:ring-[#ab0800]" value="{{ App\Enum\VehiculeTransmissionEnum::AUTO->value }}" />
                                        <x-input-label class="my-auto" for="Automatique" :value="__('gestion_de_la_flotte.LabelAutomatique')"/>
                                    </div>

                                </div>

                                {{-- Bouton pour ajouter un vehicule --}}
                                <div class="modal-action">
                                    <x-primary-button>
                                        {{ __('gestion_de_la_flotte.btnAjouter') }}
                                    </x-primary-button>
                                </div>

                            </div>

                        </div>

                    </form>

                </div>

            </x-block-content>

        @endif

        {{-- Vue d'ensemble des vehicule --}}
        <x-block-content>

            <div class="max-w-md mx-auto mb-5 bg-white shadow-xl card dark:bg-[#c6c6c6] dark:border-4 dark:border-[#ab0800]">

                <div class="p-4 card-body">
                    <h2 class="mx-auto text-center card-title text-[#ab0800] text-3xl smax:text-2xl">{{ __('gestion_de_la_flotte.TitleCardVE') }}</h2>
                </div>

            </div>

            <x-alert-error :messages="session('statutErreur')" class="my-2" />
            <x-alert-success :messages="session('statutDeleteCar')" class="my-2" />
            <x-alert-success :messages="session('statutCar')" class="my-2" />

            <div class="overflow-hidden sm:rounded-lg">

                <div class="flex flex-row flex-wrap justify-between gap-5">
                    @forelse ($vehicules as $vehicule)
                        <div class="bg-white border-4 border-[#ab0800] shadow-xl card dark:bg-[#c6c6c6] w-96 mx-auto dark:text-black">

                            <figure class="flex flex-col px-10 pt-10">
                                <img src="{{ asset($vehicule->image) }}" alt="{{ $vehicule->id }}" class="rounded-xl" />
                                <h2 class="text-xl text-[#ab0800] font-bold">{{ $vehicule->id }}</h2>
                            </figure>

                            <div class="items-center pt-0 text-center card-body">

                                <div class="flex flex-col flex-wrap justify-between w-full">
                                    <div class="flex flex-row flex-wrap">
                                        <p class="text-start text-lg text-[#ab0800]">{{ $vehicule->marque->libelle }}</p>
                                        <p class="text-end text-lg text-[#ab0800]">{{ $vehicule->modele->libelle }}</p>
                                    </div>
                                    <div class="flex flex-row flex-wrap">
                                        <p class="text-start text-lg text-[#ab0800]">{{ $vehicule->type }}</p>
                                        <p class="text-end text-lg text-[#ab0800]">{{ $vehicule->tarif_journalier }} CHF/j</p>
                                    </div>
                                </div>

                                <div class="before:bg-[#ab0800] after:bg-[#ab0800] divider my-0"></div>

                                {{-- Statut du vehicule --}}
                                <div class="w-full card-actions">
                                    <x-input-label for="statutVE" :value="__('gestion_de_la_flotte.LabelStatut')"/>
                                    <select id="statutVE" name="statutVE" class="w-full mt-1 select select-bordered dark:disabled:bg-slate-400 dark:bg-white"
                                            {{ $vehicule->statut == \App\Enum\VehiculeStatutEnum::HORSU->value ? 'disabled' : '' }}
                                            {{ $vehicule->statut == \App\Enum\VehiculeStatutEnum::LOUER->value ? 'disabled' : '' }}>
                                        @foreach (\App\Enum\VehiculeStatutEnum::cases() as $statut)
                                            @switch($vehicule->statut)
                                                @case(\App\Enum\VehiculeStatutEnum::DISPO->value)
                                                    @if ($statut->value != \App\Enum\VehiculeStatutEnum::LOUER->value)
                                                        <option data-idvehicule="{{ $vehicule->id }}" value="{{ $statut->value }}" {{ $vehicule->statut == $statut->value ? 'selected' : '' }}>{{ $statut->value }}</option>
                                                    @endif
                                                    @break
                                                @case(\App\Enum\VehiculeStatutEnum::REVISION->value)
                                                    @if ($statut->value != \App\Enum\VehiculeStatutEnum::LOUER->value)
                                                        <option data-idvehicule="{{ $vehicule->id }}" value="{{ $statut->value }}" {{ $vehicule->statut == $statut->value ? 'selected' : '' }}>{{ $statut->value }}</option>
                                                    @endif
                                                    @break
                                                @case(\App\Enum\VehiculeStatutEnum::HORSU->value)
                                                    @if ($statut->value == \App\Enum\VehiculeStatutEnum::HORSU->value)
                                                        <option value="{{ $statut->value }}" selected disabled>{{ $statut->value }}</option>
                                                    @endif
                                                    @break
                                                @case(\App\Enum\VehiculeStatutEnum::LOUER->value)
                                                    @if ($statut->value == \App\Enum\VehiculeStatutEnum::LOUER->value)
                                                        <option value="{{ $statut->value }}" selected disabled>{{ $statut->value }}</option>
                                                    @endif
                                                    @break
                                                @default
                                            @endswitch
                                        @endforeach
                                    </select>

                                    {{-- Si le vehicule est hors d'usage, on peut le supprimer --}}
                                    @if ($vehicule->statut == \App\Enum\VehiculeStatutEnum::HORSU->value)
                                        {{-- Supprimer un véhicule --}}
                                        <form action="{{ route('GdF.deleteCar', ['id' => $vehicule->id]) }}" method="post" name="formDelete" class="mx-auto">
                                            @csrf
                                            <button type="submit" name="FormDelete" class="h-8 min-h-0 px-2 text-white bg-red-700 btn hover:bg-red-400">
                                                {{ __('gestion_de_la_flotte.btnSupprimer') }}
                                            </button>
                                        </form>
                                    @endif

                                </div>

                                {{-- Si le vehicule est louer, recuperer le client qui l'a louer --}}
                                @if ($vehicule->statut == \App\Enum\VehiculeStatutEnum::LOUER->value)
                                    @forelse ($locations as $location)
                                        @if ($location->vehicule_id == $vehicule->id)
                                            <div class="before:bg-[#ab0800] after:bg-[#ab0800] divider my-0"></div>
                                            <div class="flex flex-row my-auto">
                                                <div class="my-auto">
                                                    <h2 class="text-lg text-[#ab0800]">{{ $location->user->prenom }} {{ $location->user->nom }}</h2>
                                                </div>
                                                    <div class="before:bg-[#ab0800] after:bg-[#ab0800] divider my-0 divider-horizontal"></div>
                                                <div class="my-auto">
                                                    <h2 class="text-lg text-[#ab0800]">{{ __('gestion_de_la_flotte.DebutL') }}</h2>
                                                    <p>{{ date('d/m/y', strtotime($location->date_debut)) }}</p>
                                                    <h2 class="text-lg text-[#ab0800]">{{ __('gestion_de_la_flotte.FinL') }}</h2>
                                                    <p>{{ date('d/m/y', strtotime($location->date_fin)) }}</p>
                                                </div>
                                            </div>
                                        @endif
                                    @empty
                                        <div class="max-w-md mx-auto mb-5 bg-white shadow-xl card dark:bg-[#c6c6c6] dark:border-4 dark:border-[#ab0800]">
                                            <div class="p-4 card-body">
                                            <h2 class="mx-auto text-center card-title text-[#ab0800] text-3xl smax:text-2xl">{{ __('gestion_de_la_flotte.AucunClient') }}</h2>
                                            </div>
                                        </div>
                                    @endforelse
                                @endif

                            </div>

                        </div>

                    @empty
                        <div class="max-w-md mx-auto mb-5 bg-white shadow-xl card dark:bg-[#c6c6c6] dark:border-4 dark:border-[#ab0800]">
                            <div class="p-4 card-body">
                            <h2 class="mx-auto text-center card-title text-[#ab0800] text-3xl smax:text-2xl">{{ __('gestion_de_la_flotte.AucunVehicule') }}</h2>
                            </div>
                        </div>
                    @endforelse

                </div>

            </div>

        </x-block-content>

    </div>

    {{-- Integration JS pour la preview de l'image --}}
    <script type="module">
        $(document).ready(function () {

            // Pour avoir une "preview" de l'image choisis
            $("#vehicule_image").change(function () {
                    let reader = new FileReader();

                    reader.onload = (e) => {
                        $("#image_preview").attr("src", e.target.result);
                    };
                    reader.readAsDataURL(this.files[0]);
            });

            // Changer le statut du vehicule en ajax
            $('[id=statutVE]').change(function () {
                var id_vehicule = $(this).find(':selected').data('idvehicule');
                var statut = $(this).val();

                // AJAX en post pour mettre a jour le statut du vehicule
                $.post("{{ route('GdF.updateStatut') }}",
                    {
                        '_token': $('meta[name=csrf-token]').attr('content'),
                        id_vehicule: id_vehicule,
                        statut: statut
                    }, function (data) {
                        window.location.href = '{{ route('GdF') }}';
                    });
            })
        });
    </script>

</x-app-layout>
