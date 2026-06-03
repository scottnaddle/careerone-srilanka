@extends('homepage.layouts.master')
@section('title', 'Job support - Job List')

@section('content')
    <style>
        .ellipsis {
            display: -webkit-box;
            -webkit-box-orient: vertical;
            overflow: hidden;
            -webkit-line-clamp: 2;
            line-clamp: 2;
            text-overflow: ellipsis;
            max-height: calc(1.5em * 2);
            line-height: 1.5em;
        }
    </style>
    <div class="mb-6 flex flex-col">
        {{--    <p class="text-2xl text-[#464559] dark:text-white font-semibold"></p> --}}
        <div class="py-6">
            <x-breadcrumb :items="[
                ['label' => 'Home', 'url' => route('homepage')],
                ['label' => 'Job support', 'url' => '#'],
                ['label' => __('company.job_vacancy'), 'url' => '#'],
            ]" />
        </div>
        <div class="bg-white dark:bg-[#1E1E1E] rounded-xl px-4 py-5 flex flex-col gap-5">
            <form action="{{ route('company.job-support.job-vacancy.list') }}" method="GET" class="flex flex-col gap-6">
                {{--            <span class="text-xl text-primary dark:text-white flex justify-start items-center font-semibold"> --}}
                {{--                <div class="mr-2 w-1 h-4 bg-primary dark:bg-white rounded" bis_skin_checked="1"></div>{{ __('company.job_list') }} --}}
                {{--            </span> --}}
                <a href="{{ route('company.job-support.job-vacancy.create') }}"
                    class="flex items-center gap-2 font-semibold text-white bg-[#4984F6] hover:bg-blue-600 focus:ring-4 focus:outline-none
                    rounded-full text-sm px-4 p-2.5 text-center dark:bg-[#4984F6] dark:hover:bg-blue-700 dark:focus:ring-blue-800 w-fit"
                    type="button">
                    {{ __('company.my_page.publish_job') }}
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="14" viewBox="0 0 15 14" fill="none">
                        <path d="M7.5013 1.16699V12.8337M1.66797 7.00033H13.3346" stroke="white" stroke-width="1.67"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>
                {{-- Filter --}}
                <div class="flex flex-row gap-4">
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white"
                            placeholder="{{ __('general.Job title') }}" />

                    </div>
                    <button type="submit"
                        class="flex items-center gap-2 font-semibold text-white bg-[#4984F6] hover:bg-blue-600 focus:ring-4 focus:outline-none
                    rounded-full text-sm px-6 lg:px-12 py-2 text-center dark:bg-[#4984F6] dark:hover:bg-blue-700 dark:focus:ring-blue-800 w-fit">
                        {{ __('company.search') }}
                    </button>
                </div>
                <div class="flex justify-between items-center">
                    @if (
                        (request()->has('status') && request()->query('status') != '') ||
                            (request()->has('search') && request()->query('search') != ''))
                        <p class="text-[#706F81] text-lg font-semibold dark:text-white">{{ $jobs->total() }} Results</p>
                    @else
                        <p></p>
                    @endif
                    <div class="flex w-full gap-4 items-end justify-end">
                        <select id="filterStatus" name="status"
                        class="bg-[#F9FBFF] font-semibold border border-[#EDEDED] text-[#4984F6] text-base rounded-xl focus:border-primary block p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 w-fit">
                        <option value="">{{ __('company.status') }}</option>
                        @forelse(getCodeList('job_status') as $job_status)
                            <option value="{{$job_status->code_id}}" {{ request()->input('status') != '' && $job_status->code_id == request()->input('status') ? 'selected' : '' }}>{{ $job_status->code_name }}</option>
                        @empty
                        @endforelse
                    </select>
                    <select id="sort_by" name="sort_by"
                        class="bg-[#F9FBFF] font-semibold border border-[#EDEDED] text-[#4984F6] text-base rounded-xl focus:border-primary block p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 w-fit">
                        <option value="desc" @selected(request()->input('sort_by') == 'desc')>{{trans('system.filter.recently')}}</option>
                        <option value="asc" @selected(request()->input('sort_by') == 'asc')>{{trans('system.filter.oldest')}}</option>
                    </select>
                    </div>

                </div>

            </form>
            <div class="relative overflow-x-auto">
                <table class="w-full text-left rtl:text-right table-auto">
                    <thead class="bg-[#F5F7FA] dark:bg-[#282828] dark:text-white text-center shadow-md">
                        <tr>
                            <th scope="col"
                                class="px-4 py-3 text-primary dark:text-white font-semibold text-base whitespace-nowrap">
                                {{ __('company.job_title') }}
                            </th>
                            <th scope="col"
                                class="px-4 py-3 text-primary dark:text-white font-semibold text-base whitespace-nowrap">
                                {{ __('company.registration_date') }}
                            </th>
                            <th scope="col"
                                class="px-4 py-3 text-primary dark:text-white font-semibold text-base whitespace-nowrap">
                                {{ __('company.close_date') }}
                            </th>
                            <th scope="col"
                                class="px-4 py-3 text-primary dark:text-white font-semibold text-base whitespace-nowrap">
                                {{ __('company.status') }}
                            </th>
                            <th scope="col"
                                class="px-4 py-3 text-primary dark:text-white font-semibold text-base whitespace-nowrap">
                                {{ __('company.applied') }}
                            </th>
                            <th scope="col"
                                class="px-4 py-3 text-primary dark:text-white font-semibold text-base whitespace-nowrap">
                                {{ __('company.matched') }}
                            </th>
                            <th scope="col"
                                class="px-4 py-3 text-primary dark:text-white font-semibold text-base whitespace-nowrap">
                                {{ __('company.unread') }}
                            </th>
                            <th scope="col"
                                class="px-4 py-3 text-primary dark:text-white font-semibold text-base whitespace-nowrap">
                                {{ __('company.shortlist') }}
                            </th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jobs as $job)
                            <tr
                                class="bg-white dark:bg-[#1E1E1E] border-b border-[#F8F8F8] dark:border-gray-700 text-center">
                                <td scope="row" class="px-4 py-6 font-semibold text-sm  w-1/3 text-left">
                                    <a href="{{ route('company.job-support.job-vacancy.show', ['job_id' => $job->id, 'slug' => $job->slug]) }}"
                                        class="text-[#201F36] dark:text-white hover:text-primary dark:hover:text-primary ellipsis">
                                        {{ $job->title }}
                                    </a>
                                </td>
                                <td class="px-4 py-6 text-sm text-[#706F81] dark:text-white">
                                    {{ $job->created_at ? date('Y-m-d', strtotime($job->created_at)) : '' }}
                                </td>
                                <td class="px-4 py-6 text-sm text-[#706F81] dark:text-white">
                                    {{ $job->application_endtime ? date('Y-m-d', strtotime($job->application_endtime)) : '' }}
                                </td>
                                <td class="px-4 py-6 text-sm dark:text-white">
                                    @if ($job->status == \App\Enums\JobStatusEnum::PROGRESS->value)
                                        <label
                                            class="text-primary bg-[#E9F5FF] px-4 py-1 rounded-lg font-semibold flex items-center gap-2 whitespace-nowrap justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="8" height="9"
                                                 viewBox="0 0 8 9" fill="none">
                                                <circle cx="4" cy="4.49023" r="4" fill="#4984F6" />
                                            </svg>
                                            {{ getCodeNameByCodeId('job_status', $job->status) }}</label>
                                    @elseif($job->status == \App\Enums\JobStatusEnum::CANCEL->value)
                                        <label
                                            class="text-[#706F81] bg-[#ECECEC] px-4 py-1 rounded-lg font-semibold flex items-center gap-2 whitespace-nowrap justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="8" height="9"
                                                 viewBox="0 0 8 9" fill="none">
                                                <circle cx="4" cy="4.49023" r="4" fill="#706F81" />
                                            </svg>
                                            {{ getCodeNameByCodeId('job_status', $job->status) }}</label>
                                    @elseif($job->status == \App\Enums\JobStatusEnum::COMPLETED->value)
                                        <label
                                            class="text-green-500 bg-green-100 px-4 py-1 rounded-lg font-semibold flex items-center gap-2 whitespace-nowrap justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="8" height="9"
                                                 viewBox="0 0 8 9" fill="none">
                                                <circle cx="4" cy="4.49023" r="4" fill="#057a2e" />
                                            </svg>
                                            {{ getCodeNameByCodeId('job_status', $job->status) }}</label>
                                    @endif

                                </td>
                                <td class="px-4 py-6 text-sm text-[#706F81] dark:text-white">
                                    {{ $job->appliesWithCondition('apply_type', \App\Enums\TypeTraineeApply::APPLY)->count() }}
                                </td>
                                <td class="px-4 py-6 text-sm text-[#706F81] dark:text-white">
                                    {{ $job->appliesTypeMatch->count() }}
                                </td>
                                <td class="px-4 py-6 text-sm text-[#706F81] dark:text-white">
                                    {{ $job->unread->count() }}
                                </td>
                                <td class="px-4 py-6 text-sm text-[#706F81] dark:text-white">
                                    {{ $job->shortlist->count() }}
                                </td>
                                <td class="dark:text-white text-[#706F81] text-sm">
                                    <div class="flex flex-row gap-2 items-center">
                                        <a title="View" href="{{ route('company.job-support.job-vacancy.candidate-list.list', ['job_id' => $job->id, 'slug' => $job->slug]) }}"
                                            class="text-[#91919A] hover:text-primary p-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            </svg>

                                        </a>
                                        <a title="Edit" href="{{ route('company.job-support.job-vacancy.edit', ['job_id' => $job->id]) }}"
                                            class="text-[#91919A] hover:text-primary p-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                            </svg>

                                        </a>
                                        <button title="Delete" @if (
                                            $job->appliesWithCondition('apply_type', \App\Enums\TypeTraineeApply::APPLY)->count() > 0 ||
                                                $job->appliesTypeMatch->count() > 0) disabled @endif
                                            data-modal-target="delete-modal" data-modal-toggle="delete-modal"
                                            data-id="{{ $job->id }}"
                                            class=" hover:text-primary p-1 {{ $job->appliesWithCondition('apply_type', \App\Enums\TypeTraineeApply::APPLY)->count() > 0 || $job->appliesTypeMatch->count() > 0 ? 'cursor-not-allowed text-[#91919A]' : 'text-red-600' }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>

                                        </button>
                                    </div>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9">
                                    <div class="flex flex-col gap-4 justify-center items-center p-4">
                                        <img src="{{ asset('/images/empty-box.png') }}" class="opacity-50 h-32"
                                            alt="Empty">
                                        <p class="dark:text-white">No record!</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
            <div class="mt-6">
                {{ $jobs->onEachSide(1)->links() }}
            </div>
        </div>

    </div>

    <div id="delete-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-[#1E1E1E] dark:border dark:border-white px-4 py-8">
                <!-- Modal header -->
                <div class="relative pb-4 border-b rounded-t">
                    <button type="button"
                            class="absolute top-2 right-2 close-modal text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="delete-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button><br>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white text-center mt-8">
                        Confirm Delete Job: <span id="modal_title_job"></span>
                    </h3>
                </div>

                <!-- Modal body -->
                <div class="flex flex-col gap-4">
                    <svg class="mt-6 mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400 text-center">
                        Are you sure you want to delete this content?
                        <br>
                        Trainee apply and match will also be deleted accordingly!
                    </h3>
                    <div class="flex justify-center gap-4">
                        <form action="" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none
                        focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                Yes, I'm sure
                            </button>
                        </form>
                        <button data-modal-hide="delete-modal" type="button"
                            class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">No,
                            cancel</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('js/toastify.js') }}"></script>
    <script>
        let url = new URL(window.location.href);
        $('#filterStatus').on('change', function() {
            if (url.searchParams.has('status')) {
                url.searchParams.set('status', this.value);
                url.searchParams.delete('page');
            } else {
                url.searchParams.append('status', this.value);
                url.searchParams.delete('page');
            }
            window.location.href = url.href;

        });
         // Handle sort_by selection change
         $('#sort_by').on('change', function() {
                let url = new URL(window.location.href);
                if (url.searchParams.has('sort_by')) {
                    url.searchParams.set('sort_by', this.value);
                    url.searchParams.delete('page');
                } else {
                    url.searchParams.append('sort_by', this.value);
                    url.searchParams.delete('page');
                }
                window.location.href = url.href;
            });
        $('button[data-modal-toggle="delete-modal"]').on('click', function() {
            let id = $(this).data('id');
            let title = $(this).closest('tr').find('td').eq(0).text();
            $('#modal_title_job').text(title);
            $('#delete-modal form').attr('action', `/company/job-support/job-vacancy/${id}`);
        });
        @if (Session::get('status'))
            showToast('{{ Session::get('message') }}', 3000, '{{ Session::get('status') }}');
        @endif

        function showToast(message, duration, status) {
            const bgColor = status === 'success' ?
                'linear-gradient(to right, #00b09b, #96c93d)' :
                status === 'error' ?
                'linear-gradient(to right, #db4a4a, #bb7f7f)' :
                '#9e9d9d';

            Toastify({
                text: message,
                duration: duration,
                newWindow: true,
                close: true,
                gravity: "top",
                position: "right",
                stopOnFocus: true,
                style: {
                    background: bgColor,
                },
                onClick: function() {}
            }).showToast();
        }
    </script>
@endpush
