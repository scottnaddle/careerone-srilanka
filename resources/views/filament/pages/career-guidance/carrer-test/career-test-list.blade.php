<x-filament-panels::page>
<div>
    <div
        class="flex flex-col gap-4 md:gap-6 my-6 bg-white dark:bg-[#1E1E1E] rounded-xl shadow-custom-light shadow-custom-dark p-4">
        <x-filament::breadcrumbs :breadcrumbs="[
            '/admin/overview' => 'Admin',
            '' => 'Career Guidance',
            '/admin/career-tests' => 'Career Test',
        ]" />
        <p class="fi-header-heading text-2xl font-bold tracking-tight text-gray-950 dark:text-white sm:text-3xl">{{__('admin/career_test.career_test.title')}}</p>

        @if (session()->has('success'))
            <div
                class="alert alert-success text-green-600 dark:text-white font-semibold bg-green-200 px-4 py-2 rounded-xl">
                {{ session()->get('success') }}
            </div>
        @endif
        @if ($errors->any())
            {!! implode(
                '',
                $errors->all(
                    '<div class="alert alert-danger text-red-600 dark:text-red font-semibold bg-red-200 px-4 py-2 rounded-xl">:message</div>',
                ),
            ) !!}
        @endif
        @php
            $careerTestList = $this->getCareerTestTraineeResult();
            $results = $careerTestList['results'];
            $count = $careerTestList['count'];
            $careerTestTypes = $careerTestList['career_test_types'];
        @endphp
        {{-- <form method="get" action="{{ url()->current() }}" id="filter-form" method="GET">

            <div class="flex gap-4 flex-col md:flex-row">
                <div class="w-full flex gap-4">
                    <input type="date" name="period"
                        class="flex-grow px-4 py-2 border border-gray-300 rounded-lg text-[#706F81] font-medium"
                        value="{{ request()->query('period') }}" placeholder="Period">

                </div>
                <div class="w-fit"><button type="submit"
                        class="flex-1 px-4 py-2 bg-blue-500 text-white rounded-full">{{__('admin/career_test.career_test.search')}}</button></div>
            </div>

        </form> --}}
        {{-- <div class="flex flex-col gap-4 md:gap-6">
            @forelse($results as $result)
                <div class="flex flex-col gap-2 shadow-custom-light dark:shadow-custom-dark py-2 rounded-xl">
                    <div class="flex gap-2 items-center">
                        <p class="text-base md:text-base text-[#91919A] dark:text-white font-semibold">
                            {{ $result->name }}</p>
                        <span
                        class="bg-[#4984F6] text-white text-base font-medium px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 w-fit">{{ $result->careerTest->test_name }}</span>
                    </div>

                    @if ($result->type == 3 || $result->type == 4)
                        <div class="flex justify-between">
                            <p class="text-base md:text-base text-[#201F36] dark:text-white font-semibold">
                                {{ $result->careerTest->description }}</p>

                        </div>
                        <div class="flex justify-between">
                            <span
                                class="text-base md:text-base text-[#91919A] dark:text-white">{{ date('Y-m-d H:i:s', strtotime($result->created_at)) }}</span>
                            <a href="{{ route('admin.career-test.download-result', ['id' => $result->id]) }}"
                                target="_blank" class="text-primary text-base md:text-base flex items-center gap-1">View
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                </svg>
                            </a>
                        </div>
                    @elseif($result->type == 1 || $result->type == 2)
                        <a href="{{ route('admin.career-test.view-result', ['id' => $result->id]) }}"
                            target="_blank"
                            class="text-base md:text-base text-[#201F36] dark:text-white font-semibold">{{ $result->careerTest->description }}</a>
                        <div class="flex justify-between">
                            <span
                                class="text-base md:text-base text-[#91919A] dark:text-white">{{ date('Y-m-d H:i:s', strtotime($result->created_at)) }}</span>
                            <a href="{{ route('admin.career-test.view-result', ['id' => $result->id]) }}"
                                target="_blank"
                                class="text-primary text-base md:text-base flex items-center gap-1">Result
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 16 16" fill="none">
                                    <path
                                        d="M3.33337 7.99998H12.6667M12.6667 7.99998L8.00004 3.33331M12.6667 7.99998L8.00004 12.6666"
                                        stroke="#4984F6" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg></a>
                        </div>
                    @endif
                </div>
            @empty
                <div class="flex flex-col gap-4 justify-center items-center">
                    <img src="{{ asset('/images/empty-box.png') }}" class="opacity-50 h-32" alt="">
                    <p class="dark:text-white">You haven't had any Test!</p>
                </div>
            @endforelse
        </div>

        @if ($count > 0)
            <div class="flex justify-end mt-4">
                <div class="flex space-x-2">
                    {{ $results->links('vendor.pagination.custom-pagination-admin') }}
                </div>
            </div>
        @endif
    </div>

    <div id="delete-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-[#1E1E1E] dark:border dark:border-white px-4 py-8">
                <!-- Modal header -->
                <div class="flex items-center justify-between pb-4 border-b rounded-t">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white text-center">
                        {{ trans('system.delete_modal.title') }}
                    </h3>
                    <button type="button"
                        class="close-modal text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-base w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="delete-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="flex flex-col gap-4">
                    <svg class="mt-6 mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400 text-center">
                        {{ trans('system.delete_modal.content') }}</h3>
                    <div class="flex justify-center gap-4">
                        <a href=""
                            class="confirm-delete text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-base inline-flex items-center px-5 py-2.5 text-center">
                            {{ trans('system.delete_modal.yes') }}
                        </a>
                        <button data-modal-hide="delete-modal" type="button"
                            class="py-2.5 px-5 ms-3 text-base font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">{{ trans('system.delete_modal.no') }}</button>
                    </div>

                </div>
            </div>
        </div>
    </div> --}}
        <form method="get" action="{{ url()->current() }}">
            <!-- Date picker section -->
            <div class="flex gap-4 items-center mb-6">
                <!-- First Date Picker -->
                <div class="flex-1">
                    <input
                        type="date"
                        id="datePicker1"
                        value="{{ request()->query('startDate') }}"
                        name="startDate"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg text-[#91919A] focus:ring-2 focus:ring-blue-500"
                    />
                </div>
                <div class="flex-1">
                    <input
                        type="date"
                        id="datePicker2"
                        value="{{ request()->query('endDate') }}"
                        name="endDate"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg text-[#91919A] focus:ring-2 focus:ring-blue-500"
                    />
                </div>
                <div class="flex-3">
                    <button
                        type="submit"
                        class="w-full px-4 py-2 bg-blue-500 text-white rounded-full hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300 transition-colors">
                        {{ __('admin/company.search') }}
                    </button>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="flex items-center justify-between gap-4 mt-4">
                <label for="search-status" class="text-lg font-semibold text-[#706F81] flex justify-between items-center w-full">
                    @if (request()->query())
                        {{ __('admin/company.result') }}
                        <button type="button" class="flex items-center text-red-700 text-sm"
                                onclick="window.location.href = window.location.origin + window.location.pathname;"><svg
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg>
                            {{ trans('system.remove_filter') }}</button>
                    @endif
                </label>

            </div>
        </form>
    <livewire:carrer-test />
</div>
</div>
        </x-filament-panels::page>