import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path'
import { svelte } from '@sveltejs/vite-plugin-svelte';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        svelte({
            prebundleSvelteLibraries: true,
        }),
    ],
    
    resolve: {
        alias: {
            'images': path.resolve(__dirname, 'public/images')
        }
    }
});
