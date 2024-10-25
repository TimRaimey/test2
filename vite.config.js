import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/auth.js',
                'resources/js/home.js',
                'resources/js/history.js',
                'resources/css/app.css'
            ],
            refresh: true,
        }),
        vue(),
    ],
});
