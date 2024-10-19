import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
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
                'clear-custom-bg-100': '#E0F2F1',
                'clear-custom-bg-200': '#D0EBEA',
                'clear-custom-bg-300': '#FFFFFF',
                'clear-custom-primary-100': '#26A69A',
                'clear-custom-primary-200': '#408d86',
                'clear-custom-primary-300': '#cdfaf6',
                'clear-custom-accent-100': '#80CBC4',
                'clear-custom-accent-200': '#43A49B',
                'clear-custom-text':'#728f9e',
                // modo obscuro
                'dark-custom-bg-100':'#0D1F2D',
                'dark-custom-bg-200':'#1d2e3d',
                'dark-custom-bg-300':'#354656',
                'dark-custom-primary-100': '#0D6E6E',
                'dark-custom-primary-200': '#4a9d9c',
                'dark-custom-primary-300': '#afffff',
                'dark-custom-accent-100': '#FF3D3D',
                'dark-custom-accent-200': '#ffe0c8',
                'dark-custom-text-100': '#FFFFFF',
                'dark-custom-text-200': '#e0e0e0',
                
            },
            height: {
                '128': '28rem',
            },
            
        },
    },
    plugins: [forms, typography],
};
