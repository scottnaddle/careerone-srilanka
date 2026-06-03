/** @type {import('tailwindcss').Config} */
import preset from './vendor/filament/support/tailwind.config.preset'
module.exports = {
    // important: true,
    darkMode: 'class',
    presets: [preset],
    mode: 'jit',
    content: [
        "./resources/views/*.blade.php",
        "./resources/views/**/*.blade.php",
        "./resources/views/**/**/*.blade.php",
        "./resources/views/**/**/**/*.blade.php",
        // './app/Filament/**/*.php',
        './resources/views/filament/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
        './resources/views/vendor/**/**/**/*.blade.php',
        './resources/views/admin/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
    ],
    safelist: [
        "animate-pulse",
        "contrast-150",
        "invert",
        'w-2xl',
    ],
    theme: {
        screens: {
            xs: '480px',
            sm: '640px',
            md: '768px',
            lg: '1024px',
            xl: '1280px'
        },
        extend: {
            spacing: {
                '15': '3.75rem',
            },
            colors: {
                primary: `var(--primary)`,
                'main-bg': `#f8f9fb`,

                'primary-1': `var(--primary-1)`,
                'primary-2': `var(--primary-2)`,
                'primary-3': `var(--primary-3)`,
                'primary-4': `var(--primary-4)`,
                'primary-5': `var(--primary-5)`,
                'primary-6': `var(--primary-6)`,
                'primary-7': `var(--primary-7)`,
                'primary-8': `var(--primary-8)`,

                'grey-0': `var(--grey-0)`,
                'grey-1': `var(--grey-1)`,
                'grey-2': `var(--grey-2)`,
                'grey-3': `var(--grey-3)`,
                'grey-4': `var(--grey-4)`,
                'grey-5': `var(--grey-5)`,
                'grey-6': `var(--grey-6)`,
                'grey-7': `var(--grey-7)`,
                'grey-8': `var(--grey-8)`,
                'grey-10': `var(--grey-10)`,

                'hsl-80': `hsl(0, 0%, 80%)`,

                'green-1': `var(--green-1)`,
                'green-2': `var(--green-2)`,
                'green-3': `var(--green-3)`,
                'green-4': `var(--green-4)`,
                'green-5': `var(--green-5)`,
                'green-6': `var(--green-6)`,

                'red-1': `var(--red-1)`,
                'red-2': `var(--red-2)`,
                'red-3': `var(--red-3)`,
                'red-4': `var(--red-4)`,
                'red-5': `var(--red-5)`,
                'red-6': `var(--red-6)`,

                'yellow-1': `var(--yellow-1)`,
                'yellow-2': `var(--yellow-2)`,
                'yellow-3': `var(--yellow-3)`,

                dark: `var(--dark)`,
                'text-secondary': `var(--text-secondary)`,
            },
            padding: {
                '29': '29px',
                '16': '64px',
                '10': '40px'
            },
            boxShadow: {
                'custom-light' : '7px 7px 10.2px 0px rgba(232, 232, 232, 0.25)',
                'custom-dark' : '7px 7px 10.2px 0px rgba(46, 27, 27, 0.25)',
            }
        },
    },
    plugins: [
        require('flowbite/plugin')({
            charts: true
        })
    ],

}
