import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {
        host: 'webportal.test',
        https: false,
        port: 5173,
        hmr: {
            host: 'webportal.test',
            protocol: 'ws'
        },
    },
});
