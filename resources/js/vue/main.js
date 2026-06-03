import { createApp } from 'vue';
import Portfolio from './components/Portfolio.vue';
import axios from 'axios';
import Toast from 'vue-toastification';
import 'vue-toastification/dist/index.css';
import { i18nVue } from 'laravel-vue-i18n';

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

export function initializeVueApps() {
    const el = document.getElementById('app');
    const currentLang = el?.dataset?.lang || 'en';
    if (el) {
        try {
            const initialPortfolio = JSON.parse(el.dataset.portfolio || '{}');
            const app = createApp(Portfolio, {
                initialPortfolio
            });

            // Cung cấp axios cho toàn bộ app
            app.config.globalProperties.$axios = axios;
            app.use(Toast, {
                timeout: 3000,
                closeOnClick: false,
                pauseOnFocusLoss: true,
                pauseOnHover: true,
                draggable: true,
                draggablePercent: 0.6,
                showCloseButtonOnHover: false,
                hideProgressBar: false,
                closeButton: 'button',
                icon: true,
                rtl: false
            });
            app.use(i18nVue, {
                lang: currentLang,
                resolve: async (lang) => {
                    const langs = import.meta.glob('../../../lang/**/*.json');
                    return await langs[`../../../lang/${lang}/portfolio.json`]?.() || {};
                },
            });
            app.mount(el);
        } catch (error) {
            console.error('Failed to initialize Vue app:', error);
        }
    }
}

// Gọi khởi tạo
if (import.meta.hot) {
    import.meta.hot.accept();
}

initializeVueApps();
