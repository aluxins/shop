import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';


export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/dropdown-menu.css',
                'resources/js/app.js',
                'resources/js/dropdown-menu.js',
                'node_modules/tinymce/tinymce.min.js',
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '$': 'jQuery'
        },
    },
    server: {
        host: '192.168.2.10'
    }
});
