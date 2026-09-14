/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
        './app/Support/Admin/**/*.php',
        './app/DataTables/**/*.php',
        './app/View/Components/**/*.php',
    ],
    theme: {
        extend: {
            colors: {
                primary: '#7539FF',
                surface: '#F7F8F9',
                ink: '#051321',
            },
            fontFamily: {
                sans: ['PP Mori', 'Roboto Flex', 'ui-sans-serif', 'system-ui', 'sans-serif'],
            },
        },
    },
    plugins: [],
};
