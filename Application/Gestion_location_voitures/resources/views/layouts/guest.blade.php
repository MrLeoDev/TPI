<!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        @include('includes.head')
    </head>

    <body class="font-sans antialiased text-gray-900">

        <div class="flex flex-col gap-5 items-center min-h-screen pt-6 bg-gray-100 sm:justify-center sm:pt-0 dark:bg-[#363A43] dark:text-black">

            <div>

                <a href="{{ route('login') }}">
                    <x-application-logo class="text-gray-500 fill-current w-52 h-52" />
                </a>

                <div class="flex w-full">
                    <x-select_lang class="m-auto border-[#ab0800] select-bordered border-2"/>
                </div>

            </div>

            <div class="w-full bg-white dark:bg-[#c6c6c6] sm:max-w-md sm:rounded-lg border-4 border-[#ab0800]">
                <div class="w-full px-6 py-4 overflow-hidden shadow-md dark:glass sm:rounded-lg">
                    {{ $slot }}
                </div>
            </div>

            {{-- Accès manuel utilisateur --}}
            <div class="absolute bottom-0 right-0 m-5 rounded-lg smax:rounded-full bg-info dark:bg-sky-600">
                <a href="{{ asset('pdf/Manuel_utilisateur.pdf') }}" class="text-black btn smax:hidden glass dark:text-white">{{ __('manuelUtilisateur.LabelMU') }}</a>
                <a href="{{ asset('pdf/Manuel_utilisateur.pdf') }}" class="w-16 h-16 text-black btn btn-circle glass sm:hidden"><img src="{{ asset('img/icons/manual-icon.svg') }}" alt="Icon ManuelUtilisateur" class="m-auto w-9"></a>
            </div>

        </div>

    </body>

</html>
