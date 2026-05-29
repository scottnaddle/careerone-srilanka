<x-filament-panels::page>
<div>
    <style>
        table thead tr th span {
            color: blue;
        }

        #search-time {
            background-color: #F9FBFF;
            color: #4984F6;
            border: none;

        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <div class="p-6 space-y-6 bg-white mt-4 rounded-xl">
        <div class="flex items-center">


              <x-filament::breadcrumbs :breadcrumbs="[
                '/admin/overview' =>  'Admin',
                '#' =>  'Job Support',
                '/admin/jobs' => 'Job List',
            ]" />
        </div>
        <h1 class="fi-header-heading text-2xl font-bold tracking-tight text-gray-950 dark:text-white sm:text-3xl">
            Job List
        </h1>

        <div>
            {{ $this->table }}
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const statusDropdown = document.getElementById('search-time');
            statusDropdown.addEventListener('change', function() {
                let params = new URLSearchParams(window.location.search);
                params.set('status', statusDropdown.value);
                let url = `${window.location.origin}${window.location.pathname}?${params.toString()}`;
                window.location.href = url;
            });
        });
        document.addEventListener('DOMContentLoaded', function() {

            const form = document.getElementById('filter-form');

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                let formData = new FormData(form);
                let params = new URLSearchParams();
                formData.forEach((value, key) => {
                    if (value !== null && value.trim() !== '') {
                        params.append(key, value);
                    }
                });

                let url = `${window.location.origin}${window.location.pathname}?${params.toString()}`;
                window.location.href = url;
            });
        });
    </script>
</div>
</x-filament-panels::page>
