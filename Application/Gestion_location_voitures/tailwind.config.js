const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    darkMode: 'media',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {

            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },

            screens: {
                'lgmax': {'max': '1023px'},
                // => @media (max-width: 1023px) { ... }

                'smax': {'max': '639px'},
                // => @media (max-width: 639px) { ... }
            }
        },
    },

    plugins: [require('@tailwindcss/forms'), require("daisyui"), require('flowbite/plugin')],
};
