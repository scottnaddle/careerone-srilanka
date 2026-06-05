// vite.config.js
import { defineConfig } from "file:///C:/UniServerZ/vhosts/sri-lanka/career-srilanka/node_modules/vite/dist/node/index.js";
import laravel, { refreshPaths } from "file:///C:/UniServerZ/vhosts/sri-lanka/career-srilanka/node_modules/laravel-vite-plugin/dist/index.js";
import viteCompression from "file:///C:/UniServerZ/vhosts/sri-lanka/career-srilanka/node_modules/vite-plugin-compression/dist/index.mjs";
import vue from "file:///C:/UniServerZ/vhosts/sri-lanka/career-srilanka/node_modules/@vitejs/plugin-vue/dist/index.js";
import { nodePolyfills } from "file:///C:/UniServerZ/vhosts/sri-lanka/career-srilanka/node_modules/vite-plugin-node-polyfills/dist/index.js";
import i18n from "file:///C:/UniServerZ/vhosts/sri-lanka/career-srilanka/node_modules/laravel-vue-i18n/dist/vite.mjs";
var vite_config_default = defineConfig({
  plugins: [
    laravel({
      input: [
        "resources/css/app.css",
        "resources/css/filament/admin/theme.css",
        "resources/js/app.js",
        "resources/js/vue/main.js"
        // 'resources/js/grapesjs-builder.js'
      ],
      refresh: [
        ...refreshPaths,
        "app/Livewire/**"
      ]
    }),
    vue(),
    i18n(),
    nodePolyfills({
      include: ["crypto", "stream", "buffer"],
      globals: { Buffer: true }
    }),
    viteCompression({
      verbose: true,
      disable: false,
      threshold: 10240,
      algorithm: "gzip",
      ext: ".gz"
    })
  ],
  resolve: {
    alias: {
      // Add these aliases to handle Node.js modules in browser
      crypto: "crypto-browserify",
      stream: "stream-browserify",
      buffer: "buffer/",
      util: "util/"
    }
  },
  define: {
    // Define global variables needed by some packages
    global: "window",
    "process.env": {}
  },
  build: {
    commonjsOptions: {
      transformMixedEsModules: true
      // Xử lý mix ES và CommonJS
    },
    rollupOptions: {
      output: {
        entryFileNames: "assets/[name].js",
        chunkFileNames: "assets/[name].[hash].js",
        assetFileNames: (assetInfo) => {
          if (assetInfo.name.endsWith(".css")) {
            return "assets/[name].[hash].css";
          }
          return "assets/[name].[hash].[ext]";
        },
        manualChunks: {
          // Tách riêng Vue và các thư viện lớn
          "vue": ["vue", "@vue/runtime-core"],
          "vendor": ["axios", "lodash"]
        }
      }
    }
  },
  optimizeDeps: {
    include: ["crypto-browserify", "stream-browserify", "buffer"]
  }
});
export {
  vite_config_default as default
};
//# sourceMappingURL=data:application/json;base64,ewogICJ2ZXJzaW9uIjogMywKICAic291cmNlcyI6IFsidml0ZS5jb25maWcuanMiXSwKICAic291cmNlc0NvbnRlbnQiOiBbImNvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9kaXJuYW1lID0gXCJDOlxcXFxVbmlTZXJ2ZXJaXFxcXHZob3N0c1xcXFxzcmktbGFua2FcXFxcY2FyZWVyLXNyaWxhbmthXCI7Y29uc3QgX192aXRlX2luamVjdGVkX29yaWdpbmFsX2ZpbGVuYW1lID0gXCJDOlxcXFxVbmlTZXJ2ZXJaXFxcXHZob3N0c1xcXFxzcmktbGFua2FcXFxcY2FyZWVyLXNyaWxhbmthXFxcXHZpdGUuY29uZmlnLmpzXCI7Y29uc3QgX192aXRlX2luamVjdGVkX29yaWdpbmFsX2ltcG9ydF9tZXRhX3VybCA9IFwiZmlsZTovLy9DOi9VbmlTZXJ2ZXJaL3Zob3N0cy9zcmktbGFua2EvY2FyZWVyLXNyaWxhbmthL3ZpdGUuY29uZmlnLmpzXCI7Ly8gaW1wb3J0IHsgZGVmaW5lQ29uZmlnIH0gZnJvbSAndml0ZSc7XG4vLyBpbXBvcnQgbGFyYXZlbCwgeyByZWZyZXNoUGF0aHMgfSBmcm9tICdsYXJhdmVsLXZpdGUtcGx1Z2luJztcbi8vIGltcG9ydCB2aXRlQ29tcHJlc3Npb24gZnJvbSAndml0ZS1wbHVnaW4tY29tcHJlc3Npb24nO1xuLy8gZXhwb3J0IGRlZmF1bHQgZGVmaW5lQ29uZmlnKHtcbi8vICAgICBwbHVnaW5zOiBbXG4vLyAgICAgICAgIGxhcmF2ZWwoe1xuLy8gICAgICAgICAgICAgaW5wdXQ6IFsncmVzb3VyY2VzL2Nzcy9hcHAuY3NzJywgJ3Jlc291cmNlcy9jc3MvZmlsYW1lbnQvYWRtaW4vdGhlbWUuY3NzJywgJ3Jlc291cmNlcy9qcy9hcHAuanMnLCBcInJlc291cmNlcy9qcy9ncmFwZXNqcy1idWlsZGVyLmpzXCJdLFxuLy8gICAgICAgICAgICAgcmVmcmVzaDogW1xuLy8gICAgICAgICAgICAgICAgIC4uLnJlZnJlc2hQYXRocyxcbi8vICAgICAgICAgICAgICAgICAnYXBwL0xpdmV3aXJlLyoqJyxcbi8vICAgICAgICAgICAgIF0sXG4vLyAgICAgICAgIH0pLFxuLy8gICAgICAgICB2aXRlQ29tcHJlc3Npb24oe1xuLy8gICAgICAgICAgICAgdmVyYm9zZTogdHJ1ZSxcbi8vICAgICAgICAgICAgIGRpc2FibGU6IGZhbHNlLFxuLy8gICAgICAgICAgICAgdGhyZXNob2xkOiAxMDI0MCwgLy8gblx1MDBFOW4gblx1MUVCRnUgPjEwS0Jcbi8vICAgICAgICAgICAgIGFsZ29yaXRobTogJ2d6aXAnLFxuLy8gICAgICAgICAgICAgZXh0OiAnLmd6Jyxcbi8vICAgICAgICAgfSksXG4vLyAgICAgXSxcbi8vICAgICBidWlsZDoge1xuLy8gICAgICAgICByb2xsdXBPcHRpb25zOiB7XG4vLyAgICAgICAgICAgICBvdXRwdXQ6IHtcbi8vICAgICAgICAgICAgICAgICBlbnRyeUZpbGVOYW1lczogJ2Fzc2V0cy9hcHAuanMnLCAvLyBDdXN0b20gSlMgZmlsZW5hbWVcbi8vICAgICAgICAgICAgICAgICBjaHVua0ZpbGVOYW1lczogJ2Fzc2V0cy9bbmFtZV0uanMnLCAvLyBKUyBjaHVua3MgKGlmIGFueSlcbi8vICAgICAgICAgICAgICAgICBhc3NldEZpbGVOYW1lczogKGFzc2V0SW5mbykgPT4ge1xuLy8gICAgICAgICAgICAgICAgICAgICAvLyBDaGVjayBpZiB0aGUgYXNzZXQgaXMgYSBDU1MgZmlsZVxuLy8gICAgICAgICAgICAgICAgICAgICBpZiAoYXNzZXRJbmZvLm5hbWUuZW5kc1dpdGgoJy5jc3MnKSkge1xuLy8gICAgICAgICAgICAgICAgICAgICAgICAgcmV0dXJuICdhc3NldHMvYXBwLmNzcyc7IC8vIEN1c3RvbSBDU1MgZmlsZW5hbWVcbi8vICAgICAgICAgICAgICAgICAgICAgfVxuLy8gICAgICAgICAgICAgICAgICAgICAvLyBEZWZhdWx0IG5hbWluZyBwYXR0ZXJuIGZvciBvdGhlciBhc3NldHNcbi8vICAgICAgICAgICAgICAgICAgICAgcmV0dXJuICdhc3NldHMvW25hbWVdLltleHRdJztcbi8vICAgICAgICAgICAgICAgICB9LFxuLy8gICAgICAgICAgICAgfSxcbi8vICAgICAgICAgfSxcbi8vICAgICB9LFxuLy8gfSk7XG5pbXBvcnQgeyBkZWZpbmVDb25maWcgfSBmcm9tICd2aXRlJztcbmltcG9ydCBsYXJhdmVsLCB7IHJlZnJlc2hQYXRocyB9IGZyb20gJ2xhcmF2ZWwtdml0ZS1wbHVnaW4nO1xuaW1wb3J0IHZpdGVDb21wcmVzc2lvbiBmcm9tICd2aXRlLXBsdWdpbi1jb21wcmVzc2lvbic7XG5pbXBvcnQgdnVlIGZyb20gJ0B2aXRlanMvcGx1Z2luLXZ1ZSc7XG5pbXBvcnQgeyBub2RlUG9seWZpbGxzIH0gZnJvbSAndml0ZS1wbHVnaW4tbm9kZS1wb2x5ZmlsbHMnO1xuaW1wb3J0IGkxOG4gZnJvbSAnbGFyYXZlbC12dWUtaTE4bi92aXRlJztcbmV4cG9ydCBkZWZhdWx0IGRlZmluZUNvbmZpZyh7XG4gICAgcGx1Z2luczogW1xuICAgICAgICBsYXJhdmVsKHtcbiAgICAgICAgICAgIGlucHV0OiBbXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9jc3MvYXBwLmNzcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9jc3MvZmlsYW1lbnQvYWRtaW4vdGhlbWUuY3NzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2pzL2FwcC5qcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9qcy92dWUvbWFpbi5qcycsXG4gICAgICAgICAgICAgICAgLy8gJ3Jlc291cmNlcy9qcy9ncmFwZXNqcy1idWlsZGVyLmpzJ1xuICAgICAgICAgICAgXSxcbiAgICAgICAgICAgIHJlZnJlc2g6IFtcbiAgICAgICAgICAgICAgICAuLi5yZWZyZXNoUGF0aHMsXG4gICAgICAgICAgICAgICAgJ2FwcC9MaXZld2lyZS8qKicsXG4gICAgICAgICAgICBdLFxuICAgICAgICB9KSxcbiAgICAgICAgdnVlKCksXG4gICAgICAgIGkxOG4oKSxcbiAgICAgICAgbm9kZVBvbHlmaWxscyh7XG4gICAgICAgICAgICBpbmNsdWRlOiBbJ2NyeXB0bycsICdzdHJlYW0nLCAnYnVmZmVyJ10sXG4gICAgICAgICAgICBnbG9iYWxzOiB7IEJ1ZmZlcjogdHJ1ZSB9XG4gICAgICAgIH0pLFxuICAgICAgICB2aXRlQ29tcHJlc3Npb24oe1xuICAgICAgICAgICAgdmVyYm9zZTogdHJ1ZSxcbiAgICAgICAgICAgIGRpc2FibGU6IGZhbHNlLFxuICAgICAgICAgICAgdGhyZXNob2xkOiAxMDI0MCxcbiAgICAgICAgICAgIGFsZ29yaXRobTogJ2d6aXAnLFxuICAgICAgICAgICAgZXh0OiAnLmd6JyxcbiAgICAgICAgfSksXG4gICAgXSxcbiAgICByZXNvbHZlOiB7XG4gICAgICAgIGFsaWFzOiB7XG4gICAgICAgICAgICAvLyBBZGQgdGhlc2UgYWxpYXNlcyB0byBoYW5kbGUgTm9kZS5qcyBtb2R1bGVzIGluIGJyb3dzZXJcbiAgICAgICAgICAgIGNyeXB0bzogJ2NyeXB0by1icm93c2VyaWZ5JyxcbiAgICAgICAgICAgIHN0cmVhbTogJ3N0cmVhbS1icm93c2VyaWZ5JyxcbiAgICAgICAgICAgIGJ1ZmZlcjogJ2J1ZmZlci8nLFxuICAgICAgICAgICAgdXRpbDogJ3V0aWwvJyxcbiAgICAgICAgfSxcbiAgICB9LFxuICAgIGRlZmluZToge1xuICAgICAgICAvLyBEZWZpbmUgZ2xvYmFsIHZhcmlhYmxlcyBuZWVkZWQgYnkgc29tZSBwYWNrYWdlc1xuICAgICAgICBnbG9iYWw6ICd3aW5kb3cnLFxuICAgICAgICAncHJvY2Vzcy5lbnYnOiB7fSxcbiAgICB9LFxuICAgIGJ1aWxkOiB7XG4gICAgICAgIGNvbW1vbmpzT3B0aW9uczoge1xuICAgICAgICAgICAgdHJhbnNmb3JtTWl4ZWRFc01vZHVsZXM6IHRydWUsICAgICAvLyBYXHUxRUVEIGxcdTAwRkQgbWl4IEVTIHZcdTAwRTAgQ29tbW9uSlNcbiAgICAgICAgfSxcbiAgICAgICAgcm9sbHVwT3B0aW9uczoge1xuICAgICAgICAgICAgb3V0cHV0OiB7XG4gICAgICAgICAgICAgICAgZW50cnlGaWxlTmFtZXM6ICdhc3NldHMvW25hbWVdLmpzJyxcbiAgICAgICAgICAgICAgICBjaHVua0ZpbGVOYW1lczogJ2Fzc2V0cy9bbmFtZV0uW2hhc2hdLmpzJyxcbiAgICAgICAgICAgICAgICBhc3NldEZpbGVOYW1lczogKGFzc2V0SW5mbykgPT4ge1xuICAgICAgICAgICAgICAgICAgICBpZiAoYXNzZXRJbmZvLm5hbWUuZW5kc1dpdGgoJy5jc3MnKSkge1xuICAgICAgICAgICAgICAgICAgICAgICAgcmV0dXJuICdhc3NldHMvW25hbWVdLltoYXNoXS5jc3MnO1xuICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgIHJldHVybiAnYXNzZXRzL1tuYW1lXS5baGFzaF0uW2V4dF0nO1xuICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgICAgbWFudWFsQ2h1bmtzOiB7XG4gICAgICAgICAgICAgICAgICAgIC8vIFRcdTAwRTFjaCByaVx1MDBFQW5nIFZ1ZSB2XHUwMEUwIGNcdTAwRTFjIHRoXHUwMUIwIHZpXHUxRUM3biBsXHUxRURCblxuICAgICAgICAgICAgICAgICAgICAndnVlJzogWyd2dWUnLCAnQHZ1ZS9ydW50aW1lLWNvcmUnXSxcbiAgICAgICAgICAgICAgICAgICAgJ3ZlbmRvcic6IFsnYXhpb3MnLCAnbG9kYXNoJ10sXG4gICAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgIH0sXG4gICAgICAgIH0sXG4gICAgfSxcbiAgICBvcHRpbWl6ZURlcHM6IHtcbiAgICAgICAgaW5jbHVkZTogWydjcnlwdG8tYnJvd3NlcmlmeScsICdzdHJlYW0tYnJvd3NlcmlmeScsICdidWZmZXInXSxcbiAgICB9XG59KTtcbiJdLAogICJtYXBwaW5ncyI6ICI7QUFxQ0EsU0FBUyxvQkFBb0I7QUFDN0IsT0FBTyxXQUFXLG9CQUFvQjtBQUN0QyxPQUFPLHFCQUFxQjtBQUM1QixPQUFPLFNBQVM7QUFDaEIsU0FBUyxxQkFBcUI7QUFDOUIsT0FBTyxVQUFVO0FBQ2pCLElBQU8sc0JBQVEsYUFBYTtBQUFBLEVBQ3hCLFNBQVM7QUFBQSxJQUNMLFFBQVE7QUFBQSxNQUNKLE9BQU87QUFBQSxRQUNIO0FBQUEsUUFDQTtBQUFBLFFBQ0E7QUFBQSxRQUNBO0FBQUE7QUFBQSxNQUVKO0FBQUEsTUFDQSxTQUFTO0FBQUEsUUFDTCxHQUFHO0FBQUEsUUFDSDtBQUFBLE1BQ0o7QUFBQSxJQUNKLENBQUM7QUFBQSxJQUNELElBQUk7QUFBQSxJQUNKLEtBQUs7QUFBQSxJQUNMLGNBQWM7QUFBQSxNQUNWLFNBQVMsQ0FBQyxVQUFVLFVBQVUsUUFBUTtBQUFBLE1BQ3RDLFNBQVMsRUFBRSxRQUFRLEtBQUs7QUFBQSxJQUM1QixDQUFDO0FBQUEsSUFDRCxnQkFBZ0I7QUFBQSxNQUNaLFNBQVM7QUFBQSxNQUNULFNBQVM7QUFBQSxNQUNULFdBQVc7QUFBQSxNQUNYLFdBQVc7QUFBQSxNQUNYLEtBQUs7QUFBQSxJQUNULENBQUM7QUFBQSxFQUNMO0FBQUEsRUFDQSxTQUFTO0FBQUEsSUFDTCxPQUFPO0FBQUE7QUFBQSxNQUVILFFBQVE7QUFBQSxNQUNSLFFBQVE7QUFBQSxNQUNSLFFBQVE7QUFBQSxNQUNSLE1BQU07QUFBQSxJQUNWO0FBQUEsRUFDSjtBQUFBLEVBQ0EsUUFBUTtBQUFBO0FBQUEsSUFFSixRQUFRO0FBQUEsSUFDUixlQUFlLENBQUM7QUFBQSxFQUNwQjtBQUFBLEVBQ0EsT0FBTztBQUFBLElBQ0gsaUJBQWlCO0FBQUEsTUFDYix5QkFBeUI7QUFBQTtBQUFBLElBQzdCO0FBQUEsSUFDQSxlQUFlO0FBQUEsTUFDWCxRQUFRO0FBQUEsUUFDSixnQkFBZ0I7QUFBQSxRQUNoQixnQkFBZ0I7QUFBQSxRQUNoQixnQkFBZ0IsQ0FBQyxjQUFjO0FBQzNCLGNBQUksVUFBVSxLQUFLLFNBQVMsTUFBTSxHQUFHO0FBQ2pDLG1CQUFPO0FBQUEsVUFDWDtBQUNBLGlCQUFPO0FBQUEsUUFDWDtBQUFBLFFBQ0EsY0FBYztBQUFBO0FBQUEsVUFFVixPQUFPLENBQUMsT0FBTyxtQkFBbUI7QUFBQSxVQUNsQyxVQUFVLENBQUMsU0FBUyxRQUFRO0FBQUEsUUFDaEM7QUFBQSxNQUNKO0FBQUEsSUFDSjtBQUFBLEVBQ0o7QUFBQSxFQUNBLGNBQWM7QUFBQSxJQUNWLFNBQVMsQ0FBQyxxQkFBcUIscUJBQXFCLFFBQVE7QUFBQSxFQUNoRTtBQUNKLENBQUM7IiwKICAibmFtZXMiOiBbXQp9Cg==
