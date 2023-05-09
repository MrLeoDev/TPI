<x-app-layout>

    <x-slot name="namepage">{{ __('tableau_de_bord.Title') }}</x-slot>

    <div class="flex flex-col gap-5 py-12">

        {{-- Gestion des vehicules louer --}}
        <x-block-content>

            <div class="max-w-md mx-auto mb-5 bg-white shadow-xl card dark:bg-[#c6c6c6] dark:border-4 dark:border-[#ab0800]">
                <div class="p-4 card-body">
                    <h2 class="mx-auto text-center card-title text-[#ab0800] text-3xl smax:text-2xl">Vue d'ensemble</h2>
                    <x-text-input id="currentDate" name="currentDate" type="date" class="block w-full mt-1" value="{{ date('Y-m-d', strtotime((session('currentDate') ?? now()))) }}" />
                    <h2 class="mx-auto text-center card-title text-[#ab0800] text-3xl smax:text-2xl">Date actuelle : {{ date('d/m/y', strtotime((session('currentDate') ?? now()))) }}</h2>
                </div>
            </div>

            <x-alert-error :messages="session('statutErreur')" class="my-2" />
            <x-alert-success :messages="session('statutCar')" class="my-2" />

            <div class="overflow-hidden sm:rounded-lg">
                <div class="flex flex-row flex-wrap justify-between gap-5">
                    @forelse ($vehicules as $vehicule)
                        @forelse ($locations as $location)
                            @if ($location->vehicule_id == $vehicule->id)
                                <div class="bg-white border-4 border-[#ab0800] shadow-xl card w-96 mx-auto dark:text-black {{ (session('currentDate') ?? now()) > $location->date_fin ? 'dark:bg-red-300 dark:bg-gradient-to-t' : 'dark:bg-[#c6c6c6]' }}">

                                    <figure class="flex flex-col px-10 pt-10">
                                        <img src="{{ asset($vehicule->image) }}" alt="{{ $vehicule->id }}" class="w-full mx-auto sm:max-w-xs rounded-xl" />
                                        <h2 class="text-xl text-[#ab0800] font-bold">{{ $vehicule->id }}</h2>
                                    </figure>

                                    <div class="items-center pt-0 text-center card-body">

                                        <div class="flex flex-col flex-wrap justify-between w-full">
                                            <div class="flex flex-row flex-wrap">
                                                <p class="text-start text-lg text-[#ab0800]">{{ $vehicule->marque->libelle }}</p>
                                                <p class="text-end text-lg text-[#ab0800]">{{ $vehicule->modele->libelle }}</p>
                                            </div>
                                        </div>

                                        <div class="before:bg-[#ab0800] after:bg-[#ab0800] divider my-0"></div>


                                        <div class="flex flex-row w-full my-auto">

                                            {{-- Statut du vehicule --}}
                                            <div>
                                                <x-input-label for="statutVE" :value="__('gestion_de_la_flotte.LabelStatut')"/>
                                                <select id="statutVE"
                                                        name="statutVE"
                                                        class="w-full mt-1 select select-bordered dark:disabled:bg-slate-400 dark:bg-white"
                                                        {{ Auth::user()->categorie->value != \App\Enum\UserCategorieEnum::GESTION->value ? 'disabled' : '' }}
                                                        {{ (session('currentDate') ?? now()) > $location->date_fin ? '' : 'disabled' }}>
                                                    @foreach (\App\Enum\VehiculeStatutEnum::cases() as $statut)
                                                            <option data-currentdate="{{ (session('currentDate') ?? now()) }}" data-idvehicule="{{ $vehicule->id }}" value="{{ $statut->value }}" {{ $vehicule->statut == $statut->value ? 'selected' : '' }}>{{ $statut->value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="before:bg-[#ab0800] after:bg-[#ab0800] divider divider-horizontal my-0"></div>


                                            <div class="flex flex-row my-auto">
                                                <div class="my-auto">
                                                    <h2 class="text-lg text-[#ab0800]">{{ __('gestion_de_la_flotte.FinL') }}</h2>
                                                    <p>{{ date('d/m/y', strtotime($location->date_fin)) }}</p>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div>
                            @endif
                        @empty
                            <div class="max-w-md mx-auto mb-5 bg-white shadow-xl card dark:bg-[#c6c6c6] dark:border-4 dark:border-[#ab0800]">
                                <div class="p-4 card-body">
                                    <h2 class="mx-auto text-center card-title text-[#ab0800] text-3xl smax:text-2xl">Aucun client n'a été trouver</h2>
                                </div>
                            </div>
                        @endforelse
                    @empty
                        <div class="max-w-md mx-auto mb-5 bg-white shadow-xl card dark:bg-[#c6c6c6] dark:border-4 dark:border-[#ab0800]">
                            <div class="p-4 card-body">
                                <h2 class="mx-auto text-center card-title text-[#ab0800] text-3xl smax:text-2xl">Pas de véhicule loué</h2>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

        </x-block-content>

        {{-- Resumer --}}
        <x-block-content>

            <div class="max-w-md mx-auto mb-5 bg-white shadow-xl card dark:bg-[#c6c6c6] dark:border-4 dark:border-[#ab0800]">
                <div class="p-4 card-body">
                <h2 class="mx-auto text-center card-title text-[#ab0800] text-3xl smax:text-2xl">Résumer</h2>
                </div>
            </div>

            <div class="mx-auto stats lgmax:stats-vertical dark:border-4 dark:border-[#ab0800] dark:bg-[#c6c6c6] rounded-2xl bg-white w-full">

                {{-- Nb de vehicules dans la flotte --}}
                <div class="stat">
                    <div class="stat-title lgmax:text-sm dark:text-black">Nombre de vehicules dans la flotte</div>
                    <div class="stat-value text-[#ab0800] justify-self-center lgmax:text-2xl">{{ $nbVoituresFlotte }}</div>
                </div>

                {{-- Nb de vehicules loues --}}
                <div class="border-[#ab0800] stat">
                    <div class="stat-title lgmax:text-sm dark:text-black">Nombre de vehicules loues</div>
                    <div class="stat-value text-[#ab0800] justify-self-center lgmax:text-2xl">{{ $nbVoituresLoues }}</div>
                </div>

                {{-- Pourcentage du nombre de vehicule pour de vehicule dans la flotte --}}
                <div class="border-[#ab0800] stat">
                    <div class="stat-title lgmax:text-sm dark:text-black">Rapport de vehicules loues %</div>
                    <div class="stat-value text-[#ab0800] justify-self-center lgmax:text-2xl">{{ $rapport }} %</div>
                </div>

            </div>

        </x-block-content>

    </div>

    {{-- Integration JS pour la preview de l'image --}}
    <script type="module">

        $(document).ready(function () {

            $('#currentDate').change(function () {

                // On récupère la date simulé
                var currentDate = $(this).val();

               // AJAX en post pour mettre a jour la date actuelle (Simulation)
               $.post("{{ route('TdB.changeCurrentDate') }}",
                    {
                        '_token': $('meta[name=csrf-token]').attr('content'),
                        currentDate: currentDate
                    }, function (data) {
                        window.location.href = '{{ route('TdB') }}';
                    });
            });

            // Changer le statut du vehicule en ajax
            $('[id=statutVE]').change(function () {
                var id_vehicule = $(this).find(':selected').data('idvehicule');
                var statut = $(this).val();

                // AJAX en post pour mettre a jour le statut du vehicule
                $.post("{{ route('TdB.updateStatut') }}",
                    {
                        '_token': $('meta[name=csrf-token]').attr('content'),
                        id_vehicule: id_vehicule,
                        statut: statut
                    }, function (data) {
                        window.location.href = '{{ route('TdB') }}';
                    });
            });

        });

    </script>

</x-app-layout>
