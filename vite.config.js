import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import { VitePWA } from 'vite-plugin-pwa';
import path from 'path';

export default defineConfig({
    plugins: [
        VitePWA({
            registerType: 'autoUpdate',
            injectRegister: 'script',
            manifest: {
                name: 'RKF Official',
                short_name: 'RKF Official',
                description: 'Relawan kang fuji',
                start_url: '/',
                display: 'standalone',
                background_color: '#ffffff',
                theme_color: '#000000',
                icons: [
                    {
                        src: '/images/logoRkf.png',
                        sizes: '192x192',
                        type: 'image/png',
                        purpose: "any maskable"
                    },
                ],
            },
        }),
        laravel({
            input: ['resources/scss/app.scss', 'resources/js/app.js'],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        // symlinks: false,
        alias: {
            '@': path.resolve(__dirname, 'resources/js'),
        },
    },
});
