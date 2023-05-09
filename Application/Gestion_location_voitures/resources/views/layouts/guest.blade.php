<!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        @include('includes.head')
    </head>

    <body class="font-sans antialiased text-gray-900">

        <div class="flex flex-col gap-5 items-center min-h-screen pt-6 bg-gray-100 sm:justify-center sm:pt-0 dark:bg-[#292424] dark:text-black">

            <div>

                <a href="{{ route('login') }}">
                    <x-application-logo class="text-gray-500 fill-current w-52 h-52" />
                </a>

                <div class="flex w-full">
                    <x-select_lang class="m-auto border-[#ab0800] select-bordered border-2"/>
                </div>

            </div>

            <div class="w-full bg-white dark:bg-[#c6c6c6] sm:max-w-md sm:rounded-lg">
                <div class="w-full px-6 py-4 overflow-hidden shadow-md dark:glass sm:rounded-lg">
                    {{ $slot }}
                </div>
            </div>


        </div>

    </body>

</html>
