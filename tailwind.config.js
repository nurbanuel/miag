import defaultTheme from 'tailwindcss/defaultTheme';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Lacivert (Navy) - kurumsal kimlik, ana yapılar
                navy: {
                    50: '#f3f6fc',
                    100: '#e4eaf6',
                    500: '#2f5aa3',
                    600: '#234785',
                    700: '#1a3568',
                    800: '#122650',
                    900: '#0b1a3a',
                    950: '#060f24',
                },
                // Turkuaz (Turquoise) - araştırma, veri, gözlemevi
                turquoise: {
                    50: '#f0fbf9',
                    100: '#dcf5f2',
                    300: '#7ad8d1',
                    400: '#3fc0b8',
                    500: '#17a29b',
                    600: '#128884',
                    700: '#0d6e6c',
                    900: '#0a3f42',
                },
                // Bordo (Maroon) - politika, katılım, eylem butonları
                bordo: {
                    50: '#fbf1f3',
                    100: '#f6e3e8',
                    400: '#bf4966',
                    500: '#a3274a',
                    600: '#871f3d',
                    700: '#6e1832',
                    800: '#551227',
                    900: '#3c0d1c',
                },
            },
        },
    },
    plugins: [typography],
};
