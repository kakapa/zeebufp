import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    DEFAULT: '#88314f',      // text-primary, bg-primary
                    600: '#a13a5d',          // text-primary-600, etc.
                    500: '#88314f',          // text-primary-500
                    300: '#88314f',          // text-primary-300
                },
            },
        },
    },

    plugins: [forms],
};
