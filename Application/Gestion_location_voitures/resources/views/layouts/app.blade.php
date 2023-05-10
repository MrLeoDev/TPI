<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        @include('includes.head')
    </head>

    <body class="font-sans antialiased">

        <div class="min-h-screen bg-gray-100 dark:bg-[#121212]">

            @include('layouts.navigation')

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>

        </div>

    </body>

</html>
