<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        @include('includes.head')
    </head>

    <body class="font-sans antialiased">

        <div class="min-h-screen bg-gray-100 dark:bg-[#363A43]">

            @include('layouts.navigation')

            <!-- Page Content -->
            <main>
                {{ $slot }}
                <div class="flex flex-row justify-center w-full py-6 lg:hidden">
                    <div class="w-full max-w-sm rounded-lg smax:max-w-xs bg-info dark:bg-sky-600">
                        <a href="{{ asset('pdf/Manuel_utilisateur.pdf') }}" class="w-full text-black btn glass dark:text-white">{{ __('manuelUtilisateur.LabelMU') }}</a>
                    </div>
                </div>
            </main>

            {{-- Accès manuel utilisateur --}}
            <div class="fixed bottom-0 right-0 m-5 rounded-lg bg-info dark:bg-sky-600 lgmax:hidden">
                <a href="{{ asset('pdf/Manuel_utilisateur.pdf') }}" class="text-black btn glass dark:text-white">{{ __('manuelUtilisateur.LabelMU') }}</a>
            </div>

        </div>

    </body>

</html>
