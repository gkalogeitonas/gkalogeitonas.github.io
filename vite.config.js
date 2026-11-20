import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { bunny } from 'laravel-vite-plugin/fonts';
import tailwindcss from '@tailwindcss/vite';

// Inside ddev the dev server must be reachable on the project's https URL (see .ddev/config.yaml).
const ddevUrl = process.env.DDEV_PRIMARY_URL?.replace(/:\d+$/, '');
const watch = { ignored: ['**/storage/framework/views/**'] };

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
            // Downloaded at build time and served from our own domain: no third-party requests.
            fonts: [
                bunny('IBM Plex Sans', {
                    alias: 'plex',
                    weights: [400, 500, 600],
                    subsets: ['latin', 'latin-ext', 'greek'],
                    preload: [{ weight: 400, style: 'normal' }], // body text only
                }),
                bunny('JetBrains Mono', {
                    alias: 'jetbrains',
                    weights: [400, 700],
                    subsets: ['latin', 'latin-ext', 'greek'],
                    preload: false,
                }),
            ],
        }),
        tailwindcss(),
    ],
    server: ddevUrl
        ? {
              host: '0.0.0.0',
              port: 5173,
              strictPort: true,
              origin: `${ddevUrl}:5173`,
              cors: { origin: /https?:\/\/([A-Za-z0-9\-.]+)?(\.ddev\.site)(?::\d+)?$/ },
              watch,
          }
        : { watch },
});
