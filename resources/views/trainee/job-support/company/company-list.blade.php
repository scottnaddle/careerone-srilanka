@extends('homepage.layouts.master')
@section('title', 'Trainee - Company list')

@section('content')
    <style>
        .parent {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            padding: 10px;
        }

        .child1,
        .child3 {
            flex: 0 0 auto;
            white-space: nowrap;
        }

        .child2 {
            flex: 1;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            padding: 0 10px;
        }
    </style>

    <div class="py-6">
        <x-breadcrumb :items="[
            ['label' => trans('trainee.menu.home'), 'url' => route('homepage')],
            ['label' => trans('trainee.menu.job_support.root'), 'url' => '#'],
            ['label' => trans('trainee.menu.job_support.company_list'), 'url' => route('trainee.job-support.company.company-list')],
        ]" />
    </div>
    <div class="flex flex-col gap-5 bg-white dark:bg-[#1E1E1E] rounded-xl px-4 py-5 mb-6">
        <form action="{{ url()->current() }}" method="GET" class="flex flex-col gap-6 ">
            <div class="flex flex-row gap-4">
                <div class="relative w-full">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="text" name="title" id="search" value="{{ request('title') }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white"
                        placeholder="Company name" />

                </div>
                <button type="submit"
                    class="px-6 lg:px-12 py-2 font-medium text-white bg-primary rounded-full hover:bg-blue-800  shadow-xs">
                    {{ trans('trainee.job_support.company.search') }}
                </button>
            </div>

        </form>
        <div class="flex flex-col-reverse md:flex-row justify-between items-center gap-4">
            @if (
                (request()->has('bookmark') && request()->query('bookmark') != 'all') ||
                    (request()->has('title') && request()->query('title') != '') ||
                    (request()->has('sector') && request()->query('sector') != 'all') ||
                    (request()->has('district') && request()->query('district') != 'all') ||(request()->has('province') && request()->query('province') != 'all'))
                <p class="text-[#706F81] text-lg font-semibold dark:text-white">{{ $companies->count() }} Results</p>
            @else
                <p></p>
            @endif
            <div class="flex flex-wrap w-full md:flex-row items-center gap-4 justify-end md:justify-end">
                <button value="all" name="district-modal" id="district-modal" type="button"
                    data-modal-target="default-modal"
                    class="flex justify-around space-x-1 bg-[#F8F8F8] font-semibold border border-[#EDEDED] text-[#706F81] text-sm rounded-xl focus:border-primary p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 w-fit">
                    <span>
                        @php
                            $locationText = trans('trainee.job_support.ojt_list.filter.location');

                            if (optional($divisionalFilter)->id) {
                                $locationText = "{$provinceFilter->name}/{$districtsFilter->name}/{$divisionalFilter->ds_name}";
                            } elseif (optional($districtsFilter)->id) {
                                $locationText = "{$provinceFilter->name}/{$districtsFilter->name}";
                            } elseif (optional($provinceFilter)->id) {
                                $locationText = $provinceFilter->name;
                            }
                        @endphp

                        {{ $locationText }}
                    </span>
                    <svg width="20" height="20" viewBox="0 0 16 16" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 6L8 10L12 6" stroke="#91919A" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </button>
                <button value="all" name="sector" id="sector-modal-open" type="button"
                    data-modal-target="default-modal"
                    class="flex justify-around space-x-1 bg-[#F8F8F8] font-semibold border border-[#EDEDED] text-[#706F81] text-sm rounded-xl focus:border-primary p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 w-fit">
                    <span>
                        @php
                            $sectorText = trans('trainee.job_support.ojt_list.filter.sector_nvq');

                            if (optional($subsectorFilter)->id) {
                                $sectorText = "{$sectorsFilter->name}/{$subsectorFilter->name}";
                            } elseif (optional($sectorsFilter)->id) {
                                $sectorText = $sectorsFilter->name;
                            }
                        @endphp
                        {{ $sectorText }}
                    </span>
                    <svg width="20" height="20" viewBox="0 0 16 16" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 6L8 10L12 6" stroke="#91919A" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </button>

                <select id="company_information" name="company_information"
                    class="w-auto md:w-auto bg-[#F8F8F8] font-semibold border border-[#EDEDED] text-[#706F81] text-sm rounded-xl focus:border-primary block p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 w-fit">
                    <option value="all">{{trans('trainee.job_support.company.company_details.company_information')}}
                    </option>
                    @foreach ($companyInformations as $companyInformation)
                        <option value="{{ $companyInformation->code_id }}" @selected(request()->input('company_information') == $companyInformation->code_id)>
                            {{ $companyInformation->code_name }}</option>
                    @endforeach
                </select>
                <select id="bookmark" name="bookmark"
                    class="w-auto md:w-auto bg-[#F8F8F8] font-semibold border border-[#EDEDED] text-[#706F81] text-sm rounded-xl focus:border-primary block p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 w-fit">
                    <option value="all">{{ trans('trainee.job_support.company.filter.bookmark.root') }}</option>
                    <option value="mark" @selected(request()->input('bookmark') == 'mark')>
                        {{ trans('trainee.job_support.company.filter.bookmark.mark') }}</option>
                    <option value="unmark" @selected(request()->input('bookmark') == 'unmark')>
                        {{ trans('trainee.job_support.company.filter.bookmark.unmark') }}</option>
                </select>
            </div>
        </div>
        <div class="relative overflow-x-auto">
            <table class="w-full text-left rtl:text-right table-auto">
                <thead class="bg-[#F5F7FA] dark:bg-[#282828] dark:text-white text-center shadow-md">
                    <tr>
                        <th scope="col"
                            class="px-4 py-3 text-primary dark:text-white font-semibold text-base whitespace-nowrap">
                            {{ trans('trainee.job_support.company.table.label.company_name') }}
                        </th>
                        <th scope="col"
                            class="px-4 py-3 text-primary dark:text-white font-semibold text-base whitespace-nowrap">
                            {{ trans('trainee.job_support.company.table.label.office_type') }}
                        </th>
                        <th scope="col"
                            class="px-4 py-3 text-primary dark:text-white font-semibold text-base whitespace-nowrap">
                            {{ trans('cgo.job_support.company_list.filter.company_information') }}
                        </th>
                        <th scope="col"
                            class="px-4 py-3 text-primary dark:text-white font-semibold text-base whitespace-nowrap">
                            {{ trans('trainee.job_support.company.table.label.district') }}
                        </th>
                        <th scope="col"
                            class="px-4 py-3 text-primary dark:text-white font-semibold text-base whitespace-nowrap">
                            {{ trans('trainee.job_support.company.table.label.job_vacancy') }}
                        </th>
                        <th scope="col"
                            class="px-4 py-3 text-primary dark:text-white font-semibold text-base whitespace-nowrap">
                            {{ trans('trainee.job_support.company.table.label.bookmark') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($companies as $item)
                        <tr
                            class="bg-white dark:bg-[#1E1E1E] border-b border-[#F8F8F8] dark:border-gray-700 text-center hover:bg-blue-100 dark:hover:bg-gray-700">
                            <td scope="row" class="px-4 py-6 font-semibold text-sm  w-1/3 text-left">
                                <a href="{{ route('trainee.job-support.company.detail', ['id' => $item->id, 'slug' => $item->slug]) }}"
                                    class="text-[#201F36] dark:text-white hover:text-primary dark:hover:text-primary">{{ $item->name }}</a>
                            </td>
                            <td class="px-4 py-6 text-sm text-[#201F36] dark:text-white">
                                {{ getCodeNameByCodeId('office_type', $item->office_type) }}
                            </td>
                            <td class="px-4 py-6 text-sm text-[#201F36] dark:text-white">
                                {{getCodeNameByCodeId('company_information', $item->company_information) ?? 'No information'}}
                            </td>
                            <td class="px-4 py-6 text-sm text-[#201F36] dark:text-white">
                                {{ $item->getDistrict() }}
                            </td>
                            <td class="px-4 py-6 text-sm text-[#201F36] dark:text-white">
                                {{ $item->jobRecruitings()->count() }}
                            </td>
                            <td
                                class="px-4 py-6 text-sm text-[#201F36] dark:text-white flex flex-col justify-center items-center">
                                <span id="number_of_bookmark_{{ $item->id }}">{{ $item->bookmarks->count() }}</span>
                                <button onclick="handleKeepTrainee(this)" id="mark-company"
                                    data-company-id="{{ $item->id }}" class="" title="Bookmark company"
                                    data-trainee-id="{{ Auth::guard(activeGuard())->user()->id }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21"
                                        viewBox="0 0 15 18"
                                        class="{{ $item->isMarkByTrainee(Auth::guard(activeGuard())->user()->id) ? 'fill-primary' : '' }} size-6"
                                        fill="none">
                                        <path
                                            d="M1.6665 5.5C1.6665 4.09987 1.6665 3.3998 1.93899 2.86502C2.17867 2.39462 2.56112 2.01217 3.03153 1.77248C3.56631 1.5 4.26637 1.5 5.6665 1.5H9.33317C10.7333 1.5 11.4334 1.5 11.9681 1.77248C12.4386 2.01217 12.821 2.39462 13.0607 2.86502C13.3332 3.3998 13.3332 4.09987 13.3332 5.5V16.5L7.49984 13.1667L1.6665 16.5V5.5Z"
                                            stroke="#4984F6" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="flex flex-col gap-4 justify-center items-center p-4">
                                    <img src="{{ asset('/images/empty-box.png') }}" class="opacity-50 h-32" alt="Empty">
                                    <p class="dark:text-white">{{ __('system.messages.no_results') }}</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
        <div class="mt-6">
            {{ $companies->onEachSide(1)->links() }}
        </div>
    </div>
    <div id="default-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-4xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-[#1E1E1E] dark:border-white">
                <!-- Modal header -->
                <div
                    class="flex items-center justify-between p-4 md:p-5 rounded-t-lg bg-primary dark:bg-[#383838] px-6 py-4">
                    <h3 class="text-xl md:text-2xl lg:text-3xl font-semibold text-white" id="title-modal"></h3>
                    <button id="btn-close" type="button"
                        class="text-white bg-transparent hover:text-gray-900 rounded-lg text-sm w-12 h-12 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"
                            fill="none">
                            <path d="M22.6654 9.33301L9.33203 22.6663M9.33203 9.33301L22.6654 22.6663" stroke="white"
                                stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="px-12 py-4 flex flex-col gap-6">
                    <div class="flex flex-col items-start border-b pb-4">
                        <div class="mb-4 border-b border-gray-200 dark:border-gray-700 w-full">
                            <ul class="flex flex-wrap -mb-px text-sm text-center font-semibold" id="default-styled-tab"
                                data-tabs-toggle="#default-styled-tab-content"
                                data-tabs-active-classes="text-[#4984F6] hover:text-[#4984F6] dark:text-[#4984F6] dark:hover:text-[#4984F6] border-[#4984F6] dark:border-[#4984F6]"
                                data-tabs-inactive-classes="dark:border-transparent text-gray-500 hover:text-gray-600 dark:text-gray-400 border-gray-100 hover:border-gray-300 dark:border-gray-700 dark:hover:text-gray-300"
                                role="tablist">
                                <li class="me-2" role="presentation">
                                    <button class="inline-block p-4 border-b-2 rounded-t-lg" id="tab-1"
                                        data-tabs-target="#data-tab-1" type="button" role="tab"
                                        aria-controls="tab-1" aria-selected="false"></button>
                                </li>
                                <li class="me-2" role="presentation">
                                    <button
                                        class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                                        id="tab-2" data-tabs-target="#data-tab-2" type="button" role="tab"
                                        aria-controls="tab-2" aria-selected="false"></button>
                                </li>
                                <li class="me-2" role="presentation">
                                    <button class="inline-block p-4 border-b-2 rounded-t-lg" id="tab-3"
                                        data-tabs-target="#data-tab-3" type="button" role="tab"
                                        aria-controls="tab-3" aria-selected="false">Another Tab</button>
                                </li>
                            </ul>
                        </div>
                        <div id="default-styled-tab-content" class="w-full">
                            <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800 space-y-2 " id="data-tab-1"
                                role="tabpanel" aria-labelledby="profile-tab">

                            </div>
                            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="data-tab-2"
                                role="tabpanel" aria-labelledby="dashboard-tab">

                            </div>
                            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="data-tab-3"
                                role="tabpanel" aria-labelledby="dashboard-tab">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end px-2 py-4 pt-8 gap-2 md:gap-6 md:px-12">
                    <button id="btn-cancel" type="button"
                        class="text-[#9F9FAA] bg-[#EDEDED] hover:bg-gray-500 hover:text-white focus:outline-none font-medium rounded-full text-sm sm:w-auto px-5 py-2.5 text-center close-upload-modal">Cancel</button>
                    <button id="btn-save" type="button"
                        class="py-2.5 px-4 text-white bg-primary hover:bg-blue-800 text-sm font-medium rounded-full block">Select</button>
                </div>
            </div>
        </div>
    </div>
    <div id="sector-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-4xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-[#1E1E1E] dark:border-white">
                <!-- Modal header -->
                <div
                    class="flex items-center justify-between p-4 md:p-5 rounded-t-lg bg-primary dark:bg-[#383838] px-6 py-4">
                    <h3 class="text-xl md:text-2xl lg:text-3xl font-semibold text-white" id="title-modal"></h3>
                    <button id="sector-btn-close" type="button"
                        class="text-white bg-transparent hover:text-gray-900 rounded-lg text-sm w-12 h-12 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"
                            fill="none">
                            <path d="M22.6654 9.33301L9.33203 22.6663M9.33203 9.33301L22.6654 22.6663" stroke="white"
                                stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="px-12 py-4 flex flex-col gap-6">
                    <div class="flex flex-col items-start border-b pb-4">
                        <div class="mb-4 border-b border-gray-200 dark:border-gray-700 w-full">
                            <ul class="flex flex-wrap -mb-px text-sm text-center font-semibold" id="default-styled-tab"
                                data-tabs-toggle="#default-styled-tab-content"
                                data-tabs-active-classes="text-[#4984F6] hover:text-[#4984F6] dark:text-[#4984F6] dark:hover:text-[#4984F6] border-[#4984F6] dark:border-[#4984F6]"
                                data-tabs-inactive-classes="dark:border-transparent text-gray-500 hover:text-gray-600 dark:text-gray-400 border-gray-100 hover:border-gray-300 dark:border-gray-700 dark:hover:text-gray-300"
                                role="tablist">
                                <li class="me-2" role="presentation">
                                    <button class="inline-block p-4 border-b-2 rounded-t-lg" id="sector-tab-1"
                                        data-tabs-target="#sector-data-tab-1" type="button" role="tab"
                                        aria-controls="sector-tab-1" aria-selected="false"></button>
                                </li>
                            </ul>
                        </div>
                        <div id="default-styled-tab-content" class="w-full">
                            <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800 space-y-2 " id="sector-data-tab-1"
                                role="tabpanel" aria-labelledby="profile-tab">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end px-2 py-4 pt-8 gap-2 md:gap-6 md:px-12">
                    <button id="sector-btn-cancel" type="button"
                        class="text-[#9F9FAA] bg-[#EDEDED] hover:bg-gray-500 hover:text-white focus:outline-none font-medium rounded-full text-sm sm:w-auto px-5 py-2.5 text-center close-upload-modal">Cancel</button>
                    <button id="sector-btn-save" type="button"
                        class="py-2.5 px-4 text-white bg-primary hover:bg-blue-800 text-sm font-medium rounded-full block">Select</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        $('#company_information').on('change', function() {
            if (url.searchParams.has('company_information')) {
                if (this.value !== 'all')
                    url.searchParams.set('company_information', this.value);
                else
                    url.searchParams.delete('company_information');
                url.searchParams.delete('page');
            } else {
                url.searchParams.append('company_information', this.value);
                url.searchParams.delete('page');
            }
            window.location.href = url.href;
        });
    </script>
    <script>
        let url = new URL(window.location.href);
        $('#bookmark').on('change', function() {
            if (url.searchParams.has('bookmark')) {
                url.searchParams.set('bookmark', this.value);
                url.searchParams.delete('page');
            } else {
                url.searchParams.append('bookmark', this.value);
                url.searchParams.delete('page');
            }
            window.location.href = url.href;
        });
        {{--$('#district-modal').on('click', function() {--}}
        {{--    const modal = createModal('default-modal', {--}}
        {{--        onHide: () => {--}}
        {{--            clearModalContent();--}}
        {{--        },--}}
        {{--        closable: false,--}}
        {{--    });--}}
        {{--    //Set up modal content--}}
        {{--    $('#title-modal').text('{{trans('trainee.job_support.ojt_list.filter.location')}}');--}}
        {{--    $('#tab-1').text('Province');--}}
        {{--    $('#tab-2').text('District');--}}
        {{--    $('#tab-3').text('Divisional Secretariat');--}}
        {{--    const provinces = @json($provinces);--}}
        {{--    let provinceFilter = url.searchParams.get('province');--}}
        {{--    appendOptionAll($('#data-tab-1'), provinceFilter === '' || provinceFilter === null,--}}
        {{--        'province', url);--}}
        {{--    provinces.forEach((province, index) => {--}}
        {{--        const isSelected = url.searchParams.get('province') == province.id;--}}
        {{--        appendProvince(province, index, isSelected);--}}

        {{--        $(`#province${index}`).on('click', function(e) {--}}
        {{--            handleProvinceClick(provinces, index, url);--}}
        {{--        });--}}

        {{--        if (isSelected) {--}}
        {{--            $(`#province${index}`).trigger('click');--}}
        {{--        }--}}
        {{--    });--}}

        {{--    $('#provinces-tab').trigger('click');--}}

        {{--    $('#btn-save').on('click', function() {--}}
        {{--        window.location.href = url.href;--}}
        {{--    });--}}

        {{--    $('#btn-cancel, #btn-close').on('click', function() {--}}
        {{--        modal.hide();--}}
        {{--    });--}}
        {{--    modal.show();--}}
        {{--});--}}

        $('#district-modal').on('click', function () {
            const modal = createModal('default-modal', {
                onHide: () => {
                    clearModalContent();
                },
                closable: false,
            });

            //Set up modal static content
            $('#title-modal').text('{{ trans('trainee.job_support.ojt_list.filter.location') }}');
            $('#tab-1').text('Province');
            $('#tab-2').text('District');
            $('#tab-3').text('Divisional Secretariat');

            const provinceFilter = url.searchParams.get('province');
            appendOptionAll($('#data-tab-1'), provinceFilter === '' || provinceFilter === null, 'province', url);

            // 🧠 GỌI AJAX để lấy provinces
            fetch('/api/get-provinces')
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        const provinces = result.data;

                        provinces.forEach((province, index) => {
                            const isSelected = url.searchParams.get('province') == province.id;
                            appendProvince(province, index, isSelected);

                            $(`#province${index}`).on('click', function () {
                                handleProvinceClick(provinces, index, url);
                            });

                            if (isSelected) {
                                $(`#province${index}`).trigger('click');
                            }
                        });

                        $('#provinces-tab').trigger('click');
                    } else {
                        console.error('API returned error:', result.message);
                    }
                })
                .catch(error => {
                    console.error('Error fetching provinces:', error);
                });

            $('#btn-save').on('click', function () {
                window.location.href = url.href;
            });

            $('#btn-cancel, #btn-close').on('click', function () {
                modal.hide();
            });

            modal.show();
        });

        // Xử lý toggle sector (tạm thời rỗng, có thể thêm sau)
        $('#sector-modal-open').on('click', function() {
            const modal = createModal('sector-modal', {
                onHide: () => {
                    clearModalContent();
                },
                closable: false,
            });
            $('#title-sector-modal').text('Job catagory');
            $('#sector-tab-1').text('Job catagory');
            const sectors = @json($sectors);
            let sectorFilter = url.searchParams.get('sector');
            appendOptionAll($('#sector-data-tab-1'), sectorFilter === '' || sectorFilter === null,
                'sector', url);
            sectors.forEach((sector, index) => {
                const isSelected = url.searchParams.get('sector') == sector.id;
                appendSector(sector, index, isSelected);

                $(`#sector${index}`).on('click', function(e) {
                    handleSectorClick(sectors, index, url);
                });

                if (isSelected) {
                    $(`#sector${index}`).trigger('click');
                }
            })
            $('#sector-btn-save').off('click').on('click', function() {
                window.location.href = url.href;
            });

            $('#sector-btn-cancel, #sector-btn-close').off('click').on('click', function() {
                modal.hide();
            });
            modal.show();
        });


        // Hàm để làm sạch nội dung modal
        function clearModalContent() {
            $('#tab-1').empty();
            $('#tab-2').empty();
            $('#tab-3').empty();
            $('#data-tab-1').empty();
            $('#data-tab-3').empty();
            $('#data-tab-2').empty();
            $('#sector-tab-1').empty();
            $('#sector-data-tab-1').empty();
        }

        // Hàm để thêm province vào modal
        function appendProvince(province, index, isSelected) {
            const html = itemOptionSlect('province' + index, 'province', province.name, isSelected,
                `data-index="${index}"`);
            $('#data-tab-1').append(html);
        }

        function appendOptionAll(dataTabEl, isSelected, nameFilter, url) {
            let optionAllId = makeid(10);
            const html = itemOptionSlect(optionAllId, nameFilter, 'All', isSelected);
            dataTabEl.append(html);
            $(`#${optionAllId}`).on('click', function() {
                if (nameFilter == 'province') {
                    url.searchParams.delete('province');
                    url.searchParams.delete('district');
                    url.searchParams.delete('divisional_secretariat');
                    $('#data-tab-3').empty();
                    $('#data-tab-2').empty();
                } else if (nameFilter == 'district') {
                    url.searchParams.delete('divisional_secretariat');
                    $('#data-tab-3').empty();
                    url.searchParams.delete('district');
                } else if (nameFilter == 'divisional_secretariat') {
                    url.searchParams.delete('divisional_secretariat');
                } else {
                    url.searchParams.delete('sector');
                }

                toggleSelected($(`.${nameFilter}`), $(this));
            });
        }

        function handleProvinceClick(provinces, index, url) {
            toggleSelected($('.province'), $(`#province${index}`));
            $('#tab-2').trigger('click');
            url.searchParams.set('province', provinces[index].id);
            url.searchParams.delete('page');

            $('#data-tab-2').empty();
            $('#data-tab-3').empty();
            let districtFilter = url.searchParams.get('district');
            let flag = false;
            appendOptionAll($('#data-tab-2'), districtFilter === '' || districtFilter === null, 'district', url);
            provinces[index].districts.forEach((district, idx) => {
                const isSelected = districtFilter == district.id;
                if (isSelected) {
                    flag = true;
                }
                appendDistrict(provinces[index].districts, district, idx, isSelected, url);

                if (isSelected) {
                    $(`#district${index}`).trigger('click');
                }
            });
            if (!flag) {
                url.searchParams.delete('district');
            }
        }

        function handleDistrictClick(districts, index, url) {
            toggleSelected($('.district'), $(`#district${index}`));
            $('#tab-3').trigger('click');

            url.searchParams.set('district', districts[index].id);
            url.searchParams.delete('page');

            $('#data-tab-3').empty();

            let divisionalFilter = url.searchParams.get('divisional_secretariat');
            let flag = false;
            appendOptionAll($('#data-tab-3'), divisionalFilter === '' || divisionalFilter === null,
                'divisional_secretariat', url);
            districts[index].divisional_secretariats.forEach((divisional, idx) => {
                const isSelected = divisionalFilter == divisional.id;
                if (isSelected) {
                    flag = true;
                }
                appendDivisionalSecretariats(divisional, idx, isSelected, url);
            });

            if (!flag) {
                url.searchParams.delete('divisional_secretariat');
            }
        }

        // Hàm để thêm district vào modal
        function appendDistrict(districts, district, index, isSelected, url) {
            const html = itemOptionSlect('district' + index, 'district', district.name, isSelected,
                `data-index="${index}" data-district-id="${district.id}"`);
            $('#data-tab-2').append(html);
            $(`#district${index}`).off('click').on('click', function() {
                toggleSelected($('.district'), $(this));
                url.searchParams.set('district', $(this).data('district-id'));

                handleDistrictClick(districts, index, url);
            });
        }

        function appendDivisionalSecretariats(divisional, index, isSelected, url) {
            const html = itemOptionSlect('divisional_secretariat' + index, 'divisional_secretariat', divisional.ds_name,
                isSelected, `data-index="${index}" data-divisional-secretariat-id="${divisional.id}"`);
            $('#data-tab-3').append(html);

            $(`#divisional_secretariat${index}`).off('click').on('click', function() {
                toggleSelected($('.divisional_secretariat'), $(this));
                url.searchParams.set('divisional_secretariat', $(this).data('divisional-secretariat-id'));
            });
        }

        function appendSector(sector, index, isSelected) {
            const html = itemOptionSlect('sector' + index, 'sector', sector.name, isSelected, `data-index="${index}"`);
            $('#sector-data-tab-1').append(html);
        }

        function handleSectorClick(sectors, index, url) {
            toggleSelected($('.sector'), $(`#sector${index}`));

            url.searchParams.set('sector', sectors[index].id);
            url.searchParams.delete('page');
        }

        // Hàm để toggle trạng thái chọn
        function toggleSelected(allEl, selectedEl) {
            allEl.find('svg.inline-block').removeClass('inline-block').addClass('hidden');
            allEl.removeClass('text-[#4984F6] font-semibold dark:text-[#4984F6]').addClass(
                'text-[#706F81] dark:text-white font-normal');
            selectedEl.find('svg').removeClass('hidden').addClass('inline-block');
            selectedEl.removeClass('text-[#706F81] dark:text-white font-normal').addClass(
                'text-[#4984F6] font-semibold dark:text-[#4984F6]');
        }

        function itemOptionSlect(id, name, title, isSelected, data = '') {
            return `
                <span id="${id}" ${data}
                        class="${name} flex justify-between w-full cursor-pointer
                                hover:text-[#4984F6] hover:font-semibold
                                dark:hover:text-[#4984F6] 1
                                ${isSelected ?
                'text-[#4984F6] dark:text-[#4984F6] font-semibold' :
                'text-[#706F81] dark:text-white font-normal'
            }">
                    ${title}
                    <svg class="${isSelected ? 'inline-block' : 'hidden'}" width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20.5 6.00006L9.5 17.0001L4.5 12.0001" stroke="#4984F6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
                    `;
        }

        function createModal(id, options = null) {
            clearModalContent();
            const targetEl = document.getElementById(id);
            const instanceOptions = {
                id: id,
                override: true
            };
            return new Modal(targetEl, options, instanceOptions);
        }

        function makeid(length) {
            let result = '';
            const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            const charactersLength = characters.length;
            let counter = 0;
            while (counter < length) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
                counter += 1;
            }
            return result;
        }
    </script>
    <script>
        $(document).ready(function() {
            $('.btn-bookmark-job').on('click', function() {
                $buttonEl = $(this);
                let svgElement = $buttonEl.find('svg');
                svgElement.addClass('fill-primary');
            });
        });
    </script>
    <script>
        function handleKeepTrainee(button) {
            toggleLoadingOverlay();
            const traineeId = button.getAttribute('data-trainee-id');
            const companyId = button.getAttribute('data-company-id');
            $.ajax({
                url: '{{ route('trainee.job-support.company.mark-company') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    trainee_id: traineeId,
                    company_id: companyId,
                },
                success: function(response) {
                    let current_number = parseInt($("#number_of_bookmark_" + companyId).text());

                    if (response.action == 'mark') {
                        var svgElement = button.querySelector('svg');
                        svgElement.classList.toggle('fill-primary');
                        current_number += 1; // increment the number
                        $("#number_of_bookmark_" + companyId).text(current_number);
                    } else {
                        var svgElement = button.querySelector('svg');
                        current_number -= 1; // decrement the number
                        svgElement.classList.toggle('fill-primary');
                        $("#number_of_bookmark_" + companyId).text(current_number);
                    }
                    Toastify({
                        text: response.message,
                        duration: 3000,
                        newWindow: true,
                        close: true,
                        gravity: "top", // `top` or `bottom`
                        position: "right", // `left`, `center` or `right`
                        stopOnFocus: true, // Prevents dismissing of toast on hover
                        style: {
                            background: "linear-gradient(to right, #00b09b, #96c93d)",
                        },
                        onClick: function() {} // Callback after click
                    }).showToast();
                    toggleLoadingOverlay();
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    toggleLoadingOverlay();
                }
            });
        }
    </script>
    <script>
        if ('{{ Session::get('success') }}') {
            Toastify({
                text: '{{ Session::get('success') }}',
                duration: 3000,

                newWindow: true,
                close: true,
                gravity: "top", // `top` or `bottom`
                position: "right", // `left`, `center` or `right`
                stopOnFocus: true, // Prevents dismissing of toast on hover
                style: {
                    background: "linear-gradient(to right, #00b09b, #96c93d)",
                },
                onClick: function() {} // Callback after click
            }).showToast();
        } else if ('{{ Session::get('error') }}') {
            Toastify({
                text: '{{ Session::get('error') }}',
                duration: 3000,

                newWindow: true,
                close: true,
                gravity: "top", // `top` or `bottom`
                position: "right", // `left`, `center` or `right`
                stopOnFocus: true, // Prevents dismissing of toast on hover
                style: {
                    background: "linear-gradient(to right, #db4a4a, #bb7f7f)",
                },
                onClick: function() {} // Callback after click
            }).showToast();
        }
    </script>
@endpush
