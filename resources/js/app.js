// === Import Libraries ===
import './bootstrap';
import 'flowbite';
import Toastify from 'toastify-js';
import Datepicker from 'flowbite-datepicker/Datepicker';
import $ from "jquery";
// import { createApp } from 'vue';
// import Portfolio from './components/Portfolio.vue';
//
// const el = document.getElementById('app');
//
// if (el) {
//     const initialPortfolio = JSON.parse(el.dataset.portfolio);
//
//     createApp(Portfolio, {
//         initialPortfolio
//     }).mount(el);
// }


import Pusher from 'pusher-js';

// === Assign to Window ===
window.$ = $;
window.jQuery = $;
window.Toastify = Toastify;
window.Datepicker = Datepicker;
window.Pusher = new Pusher(import.meta.env.VITE_PUSHER_APP_KEY, {
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true
});

// === Toast Function ===
window.showToast = function (message, type, bgColor) {
    Toastify({
        text: message,
        gravity: 'top',
        position: 'right',
        backgroundColor: bgColor,
        duration: 3000
    }).showToast();
};

// === Document Ready ===
$(function () {
    // Scroll to Top
    const $toTopButton = $('#to-top-button');
    if ($toTopButton.length) {
        $(window).on('scroll', function () {
            $toTopButton.toggleClass('hidden', $(this).scrollTop() <= 500);
        });

        window.goToTop = function () {
            $('html, body').animate({ scrollTop: 0 }, 'smooth');
        };
    }

    // Menu Toggle
    $(".btn-toggle-close-menu").click(() => {
        $(".btn-toggle-menu").click();
    });

    // Dark Mode
    const themeToggleBtn = $('.theme-toggle');
    const darkIcon = $('.theme-toggle-dark-icon');
    const lightIcon = $('.theme-toggle-light-icon');

    function applyTheme() {
        const theme = localStorage.getItem('color-theme');
        if (theme === 'dark' || (!theme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            $('html').addClass('dark');
            lightIcon.removeClass('hidden');
        } else {
            $('html').removeClass('dark');
            darkIcon.removeClass('hidden');
        }
    }

    applyTheme();

    themeToggleBtn.on('click', () => {
        const isDark = $('html').hasClass('dark');
        $('html').toggleClass('dark');
        darkIcon.toggleClass('hidden');
        lightIcon.toggleClass('hidden');
        localStorage.setItem('color-theme', isDark ? 'light' : 'dark');
    });

    // Accessibility Options
    function toggleSetting(className, storageKey, selector) {
        const isActive = localStorage.getItem(storageKey);
        $('body').toggleClass(className, !!isActive);
        $(selector).prop('checked', !!isActive);
    }

    function setupToggle(selector, className, storageKey) {
        $(selector).on('change', function () {
            if ($(this).is(':checked')) {
                localStorage.setItem(storageKey, true);
            } else {
                localStorage.removeItem(storageKey);
            }
            $('body').toggleClass(className, $(this).is(':checked'));
        });
    }

    toggleSetting('contrast-150', 'contrast-theme', '.contrast-toggle');
    toggleSetting('invert', 'invert-color', '.invert-toggle');
    $('body').css('zoom', localStorage.getItem('zoomer') ? '120%' : '100%');
    $(".zoom-toggle").prop('checked', !!localStorage.getItem('zoomer'));

    setupToggle('.contrast-toggle', 'contrast-150', 'contrast-theme');
    setupToggle('.invert-toggle', 'invert', 'invert-color');
    $(".zoom-toggle").on('change', function () {
        const zoomed = $(this).is(':checked');
        localStorage.setItem('zoomer', zoomed ? true : '');
        $('body').css('zoom', zoomed ? '120%' : '100%');
    });
});
