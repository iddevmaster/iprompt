import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/css/login.css',
                'resources/css/app.css',
                'resources/css/form.css',
                'resources/css/home.css',
                'resources/css/table.css',
                'resources/js/app.js',
                'resources/js/bootstrap.js',
                'resources/js/form.js',
                'resources/js/home.js',
                'resources/js/table.js',
                'resources/js/login.js',
                'resources/css/imported.css',
                'resources/js/imported.js',
                'resources/css/profile.css',

            ],
            refresh: true,
        }),
    ],
});
