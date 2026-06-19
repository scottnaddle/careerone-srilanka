@extends('homepage.layouts.master')
@section('title', 'CGO - Job support - Company list')

@section('content')
    <div class="py-6">
        <x-breadcrumb :items="[
            ['label' => trans('cgo.menu.home'), 'url' => route('homepage')],
            ['label' => trans('cgo.menu.job_support.root'), 'url' => '#'],
            ['label' => trans('cgo.menu.job_support.company_list'), 'url' => route('trainee.job-support.company.company-list')],
        ]" />
    </div>
    <div class="mb-6 flex flex-col gap-5">
        <div class="bg-white dark:bg-[#1E1E1E] rounded-xl px-4 py-5 flex flex-col gap-5">
            <div class="flex flex-col gap-4">
                <form action="{{ route('cgo.job-support.company-list.list') }}" method="GET">
                    <div class="flex flex-col">
                        <div class="flex gap-6 mb-6 items-center">
                            <div class="w-5/6 relative">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-[#706F81] dark:text-gray-400" aria-hidden="true"
                                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                              stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                    </svg>
                                </div>
                                <input type="text" value="{{ request('company_name') }}" id="company"
                                    name="company_name"
                                    class="ps-10 border border-[#EDEDED] text-[#706F81] text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-gray-600 dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="{{ trans('admin/dashboard.compnay_job.company_name') }}" />
                            </div>

                            <div class="w-1/6">
                                <button type="submit"
                                    class="px-6 lg:px-12 py-2.5 font-medium text-white bg-primary rounded-full hover:bg-blue-800  shadow-xs w-full text-center">
                                    {{ trans('cgo.job_support.company_list.search') }}
                                </button>
                            </div>
                        </div>
                        <div class="flex justify-between items-center">
                            @if (
                                (request()->has('company_name') && request()->query('company_name') != '') ||
                                    (request()->has('district') && request()->query('district') != 'all') ||
                                    (request()->has('province') && request()->query('province') != 'all') ||
                                    (request()->has('company_information') && request()->query('company_information') != 'all') ||
                                    (request()->has('type_of_enterprise') && request()->query('type_of_enterprise') != 'all'))
                                <p class="text-[#706F81] text-lg font-semibold dark:text-white">{{ $companies->total() }}
                                    {{ trans('cgo.job_support.company_list.filterResult') }}</p>
                            @else
                                <p></p>
                            @endif
                            <div class="flex gap-4">
                                <button value="all" name="district-modal" id="district-modal" type="button"
                                    data-modal-target="default-modal"
                                    class="flex justify-around space-x-1 bg-[#F8F8F8] font-semibold border border-[#EDEDED] text-[#706F81] text-base rounded-xl focus:border-primary p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 w-fit">
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
{{--                                <select id="type_of_enterprise" name="type_of_enterprise"--}}
{{--                                    class="w-full md:w-auto bg-[#F8F8F8] font-semibold border border-[#EDEDED] text-[#706F81] text-base rounded-xl focus:border-primary block p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 w-fit">--}}
{{--                                    <option value="all">{{ trans('cgo.job_support.company_list.filter.type_of_enterprise') }}--}}
{{--                                    </option>--}}
{{--                                    @foreach ($typeOfEnterprises as $typeOfEnterprise)--}}
{{--                                        <option value="{{ $typeOfEnterprise->code_id }}" @selected(request()->input('type_of_enterprise') == $typeOfEnterprise->code_id)>--}}
{{--                                            {{ $typeOfEnterprise->code_name }}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
                                <select id="company_information" name="company_information"
                                        class="w-auto md:w-auto bg-[#F8F8F8] font-semibold border border-[#EDEDED] text-[#706F81] text-base rounded-xl focus:border-primary block p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 w-fit">
                                    <option value="all">{{ trans('cgo.job_support.company_list.filter.company_information') }}
                                    </option>
                                    @foreach ($companyInformations as $companyInformation)
                                        <option value="{{ $companyInformation->code_id }}" @selected(request()->input('company_information') == $companyInformation->code_id)>
                                            {{ $companyInformation->code_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                    </div>
                </form>
                {{--                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6"> --}}
                {{--                    @foreach ($companies as $item) --}}
                {{--                        <div --}}
                {{--                            class="flex flex-col gap-4 shadow-custom-light dark:shadow-custom-dark rounded-xl  hover:bg-blue-100 dark:hover:bg-gray-700"> --}}
                {{--                            @if ($item->logo != '') --}}
                {{--                                <a class="flex justify-center" --}}
                {{--                                    href="{{ route('cgo.job-support.company-list.job-list', ['company' => $item]) }} "><img --}}
                {{--                                        src="{{ asset($item->logo) }}" alt="" --}}
                {{--                                        class="object-cover rounded-xl h-48"></a> --}}
                {{--                            @else --}}
                {{--                                <a class="flex justify-center" --}}
                {{--                                    href="{{ route('cgo.job-support.company-list.job-list', ['company' => $item]) }} "><img --}}
                {{--                                        src="{{ asset('images/company-default.png') }}" alt="" --}}
                {{--                                        class="object-cover rounded-xl w-64"></a> --}}
                {{--                            @endif --}}
                {{--                            <div class="flex flex-col gap-1.5 p-2.5 mb-1"> --}}
                {{--                                <a href="{{ route('cgo.job-support.company-list.job-list', ['company' => $item]) }} "> --}}
                {{--                                    <p --}}
                {{--                                        class="text-[#201F36] font-bold dark:text-white hover:text-primary dark:hover:text-primary break-words"> --}}
                {{--                                        {{ $item->name }}</p> --}}
                {{--                                </a> --}}
                {{--                                <p><span --}}
                {{--                                        class="text-primary text-sm dark:text-black px-2 py-1 bg-[#F1FAFF] font-bold rounded-sm">{{ $item->jobs->count() }} --}}
                {{--                                        {{ trans('cgo.job_support.company_list.jobLabel') }}</span></p> --}}
                {{--                            </div> --}}
                {{--                        </div> --}}
                {{--                    @endforeach --}}
                {{--                </div> --}}
                {{--                --}}{{--            // this renders the tailwind pagination from vendor --}}
                {{--                {{ $companies->onEachSide(1)->links() }} --}}
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
                                    {{ trans('trainee.job_support.company.table.label.number_workers') }}
                                </th>
                                <th scope="col"
                                    class="px-4 py-3 text-primary dark:text-white font-semibold text-base whitespace-nowrap">
                                    {{ trans('trainee.job_support.company.table.label.district') }}
                                </th>
                                <th scope="col"
                                    class="px-4 py-3 text-primary dark:text-white font-semibold text-base whitespace-nowrap">
                                    Jobs
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($companies as $item)
                                <tr
                                    class="bg-white dark:bg-[#1E1E1E] border-b border-[#F8F8F8] dark:border-gray-700 text-center hover:bg-blue-100 dark:hover:bg-gray-700">
                                    <td scope="row" class="px-4 py-6 font-semibold text-sm  w-1/3 text-left">
                                        <a href="{{ route('cgo.job-support.company-list.job-list', ['company' => $item]) }}"
                                            class="text-[#201F36] dark:text-white hover:text-primary dark:hover:text-primary">{{ $item->name }}</a>
                                    </td>
                                    <td class="px-4 py-6 text-sm text-[#201F36] dark:text-white">
                                        {{ getCodeNameByCodeId('office_type', $item->office_type) }}
                                    </td>
                                    <td class="px-4 py-6 text-sm text-[#201F36] dark:text-white">
                                        {{getCodeNameByCodeId('company_information', $item->company_information) ?? 'No information'}}
                                    </td>
                                    <td class="px-4 py-6 text-sm text-[#201F36] dark:text-white">
                                        {{$item->number_workers}}
                                    </td>
                                    <td class="px-4 py-6 text-sm text-[#201F36] dark:text-white">
                                        {{ $item->getDistrict() }}
                                    </td>
                                    <td class="px-4 py-6 text-sm text-[#201F36] dark:text-white">
                                        {{ $item->jobRecruitings()->count() }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">
                                        <div class="flex flex-col gap-4 justify-center items-center p-4">
                                            <img src="{{ asset('/images/empty-box.png') }}" class="opacity-50 h-32" alt="Empty">
                                            <p class="dark:text-white">{{ trans('cgo.job_support.company_list.no_record') }}</p>
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
                        <div id="default-styled-tab-content" class="w-full relative">
                            <div id="loading" class="flex items-center justify-center w-full h-full border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-800 dark:border-gray-700 top-0 absolute z-60 hidden">
                                <div role="status">
                                    <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/></svg>
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
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
@endsection

@push('js')
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
            $("#loading").removeClass('hidden');
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

            // 🧠 CALL AJAX to get provinces
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
                        $("#loading").addClass('hidden');
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

        function clearModalContent() {
            $('#tab-1').empty();
            $('#tab-2').empty();
            $('#tab-3').empty();
            $('#data-tab-1').empty();
            $('#data-tab-2').empty();
            $('#data-tab-3').empty();
        }

        // Function to add a province to the modal
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
                    $('#data-tab-2').empty();
                    $('#data-tab-3').empty();
                } else if (nameFilter == 'district') {
                    url.searchParams.delete('district');
                    url.searchParams.delete('divisional_secretariat');
                    $('#data-tab-3').empty();
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
            let districtFilter = url.searchParams.get('district');
            let flag = false;
            let indexDis = -1;
            appendOptionAll($('#data-tab-2'), districtFilter === '' || districtFilter === null, 'district', url);
            provinces[index].districts.forEach((district, idx) => {
                const isSelected = districtFilter == district.id;
                if (isSelected) {
                    flag = true;
                    indexDis = idx;
                }
                appendDistrict(provinces[index].districts, district, idx, isSelected, url);

            });
            if (!flag) {
                url.searchParams.delete('district');
            } else {
                handleDistrictClick(provinces[index].districts, indexDis, url);
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

        // Function to add a district to the modal
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
@endpush
