import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Plus Jakarta Sans', 'Noto Sans', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Menambahkan warna kustom dari CSS Anda
                'primary': '#00809d',
                'background': '#d4f6ff',
                'card': '#ffffff',
                'text': '#0c191d',
                'active-border': '#00809d',
                'inactive-border': '#cde4ea',
                'text-secondary': '#64748b',
                'border-color': '#e2e8f0',
                'secondary': '#f0f9ff',
                'accent': '#ffc107',
                'text-primary': '#1e293b',
            // ... warna lain
                'priority-high': {
                    'bg': '#FFD2CC',
                    'text': '#D93B30'
                },
                'priority-medium': {
                    'bg': '#FFF3C4',
                    'text': '#D4A418'
                },
                'priority-low': {
                    'bg': '#D1FADF',
                    'text': '#0D8B4D'
                },
            },
            backgroundImage: {
                'checkbox-tick': "url('data:image/svg+xml,%3csvg viewBox=%270 0 16 16%27 fill=%27white%27 xmlns=%27http://www.w3.org/2000/svg%27%3e%3cpath d=%27M12.207 4.793a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0l-2-2a1 1 0 011.414-1.414L6.5 9.086l4.293-4.293a1 1 0 011.414 0z%27/%3e%3c/svg%3e')",
                }
            },
        },

        plugins: [forms],

};


