// import { defineConfig } from 'vite';
// import laravel, { refreshPaths } from 'laravel-vite-plugin';
// import viteCompression from 'vite-plugin-compression';
// export default defineConfig({
//     plugins: [
//         laravel({
//             input: ['resources/css/app.css', 'resources/css/filament/admin/theme.css', 'resources/js/app.js', "resources/js/grapesjs-builder.js"],
//             refresh: [
//                 ...refreshPaths,
//                 'app/Livewire/**',
//             ],
//         }),
//         viteCompression({
//             verbose: true,
//             disable: false,
//             threshold: 10240, // nén nếu >10KB
//             algorithm: 'gzip',
//             ext: '.gz',
//         }),
//     ],
//     build: {
//         rollupOptions: {
//             output: {
//                 entryFileNames: 'assets/app.js', // Custom JS filename
//                 chunkFileNames: 'assets/[name].js', // JS chunks (if any)
//                 assetFileNames: (assetInfo) => {
//                     // Check if the asset is a CSS file
//                     if (assetInfo.name.endsWith('.css')) {
//                         return 'assets/app.css'; // Custom CSS filename
//                     }
//                     // Default naming pattern for other assets
//                     return 'assets/[name].[ext]';
//                 },
//             },
//         },
//     },
// });
import { defineConfig } from 'vite';
import laravel, { refreshPaths } from 'laravel-vite-plugin';
import viteCompression from 'vite-plugin-compression';
import vue from '@vitejs/plugin-vue';
import { nodePolyfills } from 'vite-plugin-node-polyfills';
import i18n from 'laravel-vue-i18n/vite';
export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/filament/admin/theme.css',
                'resources/js/app.js',
                'resources/js/vue/main.js',
                // 'resources/js/grapesjs-builder.js'
            ],
            refresh: [
                ...refreshPaths,
                'app/Livewire/**',
            ],
        }),
        vue(),
        i18n(),
        nodePolyfills({
            include: ['crypto', 'stream', 'buffer'],
            globals: { Buffer: true }
        }),
        viteCompression({
            verbose: true,
            disable: false,
            threshold: 10240,
            algorithm: 'gzip',
            ext: '.gz',
        }),
    ],
    resolve: {
        alias: {
            // Add these aliases to handle Node.js modules in browser
            crypto: 'crypto-browserify',
            stream: 'stream-browserify',
            buffer: 'buffer/',
            util: 'util/',
        },
    },
    define: {
        // Define global variables needed by some packages
        global: 'window',
        'process.env': {},
    },
    build: {
        commonjsOptions: {
            transformMixedEsModules: true,     // Xử lý mix ES và CommonJS
        },
        rollupOptions: {
            output: {
                entryFileNames: 'assets/[name].js',
                chunkFileNames: 'assets/[name].[hash].js',
                assetFileNames: (assetInfo) => {
                    if (assetInfo.name.endsWith('.css')) {
                        return 'assets/[name].[hash].css';
                    }
                    return 'assets/[name].[hash].[ext]';
                },
                manualChunks: {
                    // Tách riêng Vue và các thư viện lớn
                    'vue': ['vue', '@vue/runtime-core'],
                    'vendor': ['axios', 'lodash'],
                },
            },
        },
    },
    optimizeDeps: {
        include: ['crypto-browserify', 'stream-browserify', 'buffer'],
    }
});
