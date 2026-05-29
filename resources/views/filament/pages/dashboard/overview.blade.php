<style>
    .table-widget .fi-ta-header div:first-child h3 {
        padding-left: 0.5rem;
        color: #4984F6 !important;
        border-left: 2px solid #4984F6;
        font-size: 18px;
        font-style: normal;
        font-weight: 600;
        line-height: 24px;
    }
    .table-widget table thead tr span {

        color: #4984F6 !important;
    }
    .table-widget .fi-ta-ctn {
        min-height: 450px;
    }
    .chart-widget header h3 {
        padding-left: 0.5rem;
        color: #4984F6 !important;
        border-left: 2px solid #4984F6;
        font-size: 18px;
        font-style: normal;
        font-weight: 600;
        line-height: 24px;
    }
    .view-more-button {
        background-color: #ffffff !important;
        color: #91919A !important;
        cursor: pointer;
        border: none;
        box-shadow: none;
        padding-top: 0;
        padding-bottom: 0;
    }
    .view-more-button svg {
        color: #91919A !important;
    }
    .custom-select {
        background-image: url('data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' fill=\'none\' viewBox=\'0 0 24 24\' stroke=\'%234984F6\'%3E%3Cpath stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M6 9l6 6 6-6\'/%3E%3C/svg%3E') !important;
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 1.5rem 1.5rem;
    }
</style>
<x-filament-panels::page>
{{--    <div class="flex justify-between">--}}
{{--        <h1 class="fi-header-heading text-2xl font-bold tracking-tight text-gray-950 dark:text-white sm:text-3xl">--}}
{{--            Acquisition--}}
{{--        </h1>--}}
{{--        <a>Google Analytics ></a>--}}
{{--    </div>--}}

</x-filament-panels::page>
@if (session('loginSuccess'))
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            function closeAllMenus() {
                const menus = document.querySelectorAll('.fi-sidebar-nav .fi-icon-btn');

                menus.forEach((menu, index) => {
                    // Check periodically until aria-expanded attribute is available
                    function checkAndCloseMenu() {
                        if (index !== 0 && menu.hasAttribute('aria-expanded') && menu.getAttribute('aria-expanded') === 'true') {
                            menu.click();
                        }
                    }

                    // Use a small delay to ensure the attribute has loaded
                    setTimeout(checkAndCloseMenu, 300);
                });
            }

            // Initial call to close all expanded menus except the first
            closeAllMenus();
        });
    </script>
@endif
