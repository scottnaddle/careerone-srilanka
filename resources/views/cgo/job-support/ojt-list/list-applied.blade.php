@extends('homepage.layouts.master')
@section('title', 'CGO - Job support - OJT List - OJT Matched')
@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
@endpush
@section('content')
    <div class="mb-6 flex flex-col">
        {{--        <p class="text-2xl text-[#464559] dark:text-white font-semibold">{{ trans('cgo.job_support.ojt_list.list_matched.root') }}</p> --}}
        <div class="py-6">
            <x-breadcrumb :items="[
                ['label' => trans('cgo.menu.home'), 'url' => route('homepage')],
                ['label' => trans('cgo.menu.job_support.root'), 'url' => '#'],
                ['label' => trans('cgo.menu.job_support.ojt_list'), 'url' => route('cgo.job-support.ojt-list.list')],
                ['label' => trans('cgo.job_support.ojt_list.table.list_applied'), 'url' => ''],
            ]" />
        </div>
        <div class="bg-white dark:bg-[#1E1E1E] rounded-xl px-4 py-5 flex flex-col gap-5">
            <form class="flex flex-col w-full gap-4">
                <div class="flex gap-6 items-center">
                    <label for="simple-search"
                           class="sr-only">{{ trans('cgo.job_support.ojt_list.list_matched.search') }}</label>
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>
                        <input type="text" id="simple-search" name="search" value="{{ request('search') }}"
                               class="bg-gray-50 border border-[#EDEDED] text-[#706F81] text-sm rounded-lg focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white"
                               placeholder="{{ __('general.Trainee name') }}" />
                    </div>
                    <button type="submit"
                            class="px-6 lg:px-12 py-2 md:py-3 font-medium text-white bg-primary rounded-full hover:bg-blue-800  shadow-xs">
                        {{ trans('cgo.job_support.ojt_list.list_matched.search') }}
                    </button>
                </div>

            </form>
            <div class="flex justify-between items-center">
                @if (request()->has('search') && request()->query('search') != '')
                    <p class="text-[#706F81] text-lg font-semibold dark:text-white">{{ $trainees->total() }}
                        {{ trans('cgo.job_support.ojt_list.list_matched.filterResults') }}</p>
                @else
                    <p></p>
                @endif
            </div>
            <div class="relative overflow-x-auto">
                <table class="w-full text-left rtl:text-right table-auto">
                    <thead class="bg-[#F5F7FA] dark:bg-[#282828] dark:text-white text-center shadow-md">
                    <tr>
                        <th scope="col" class="px-4 py-6 text-primary dark:text-white font-semibold text-base">
                            {{ trans('cgo.job_support.ojt_list.list_matched.trainee_information') }}
                        </th>
                        <th scope="col" class="px-4 py-6 text-primary dark:text-white font-semibold text-base">
                            {{ trans('cgo.job_support.ojt_list.list_matched.ojt_apply') }}
                        </th>
                    </tr>
                    </thead>
                    <tbody>

                    @forelse ($trainees as $trainee)

                        {{--                            {{ dd($trainee->ojtMatches->selected) }} --}}
                        {{--                            {{ dd($trainee->ojtMatches->employeed) }} --}}
                        {{--                            {{ dd($trainee->ojtMatches->read) }} --}}
                        <tr
                            class="bg-white dark:bg-[#1E1E1E] text-center border-t hover:bg-blue-100 dark:hover:bg-gray-700">
                            <td class="md:p-5">
                                <div class="flex gap-6 items-center">
                                    @if ($trainee->profile_image)
                                        <img class="w-16 h-16 rounded-full" src="{{ asset($trainee->profile_image) }}"
                                             alt="user photo">
                                    @else
                                        <img class="w-16 h-16 rounded-full" src="{{ asset('images/user-default.svg') }}"
                                             alt="user photo">
                                    @endif
                                    <div class="flex flex-col gap-1 items-start">
                                        <p class="flex gap-3">
                                            <a href="{{ route('cgo.job-support.ojt-list.trainee-applied-information', ['slug' => $ojt->slug, 'trainee' => $trainee]) }}"
                                               class="text-primary font-semibold hover:text-blue-700 dark:hover:text-white">{{ $trainee->fullName }}</a>
                                        </p>
                                        <p class="text-[#706F81] dark:text-white">

                                            {!! getNewestTrainingInformationOfTrainee($trainee->id) !!}
                                        </p>
                                        <p class="text-sm text-[#706F81] dark:text-white">
                                            {{ trans('company.applied_at') }}
                                            {{ date('Y-m-d', strtotime(getTimeApply($trainee->id, $ojt->id, 'ojt', ''))) }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-sm text-[#706F81] dark:text-[#C9CCD4]">
                                @php
                                    $readShown = false;
                                    $selectedShown = false;
                                    $unSelectedShown = false;
                                    $employeedShown = false;
                                    $ojt_trainee_apply=$trainee->ojtMatches()->where('ojt_id',$ojt->id)->get();
                                @endphp
                                @foreach ( $ojt_trainee_apply as $item)
                                    <div class="flex flex-col gap-6 items-end">
                                        {{-- Read --}}
                                        @if (!empty($item->read) && !$readShown)
                                            @php $readShown = true; @endphp
                                            <span
                                                class="text-sm text-primary flex gap-1 items-center font-semibold read-cv">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="17"
                                                         viewBox="0 0 16 17" fill="none">
                                                        <path
                                                            d="M4.66665 8.50008L7.99998 11.8334L14.6666 5.16675M1.33331 8.50008L4.66665 11.8334M7.99998 8.50008L11.3333 5.16675"
                                                            stroke="#4984F6" stroke-width="1.5" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                    </svg>
                                                    Read
                                                </span>
                                        @endif

                                        <div class="flex gap-2  pb-2">
                                            {{-- Selected --}}

                                            @if (!empty($item->selected) && empty($item->employeed) && !$selectedShown)
                                                @php $selectedShown = true; @endphp
                                                <span
                                                    class="text-sm text-primary px-2 py-1 bg-[#E9F5FF] rounded-xl font-semibold selected-cv">
                                                        {{trans('company.Selected')}}
                                                    </span>
                                            @endif
                                            @if (!empty($item->unselect_at) && empty($item->employeed) && !$unSelectedShown)
                                                @php $unSelectedShown = true; @endphp
                                                <span
                                                    class="text-sm text-red-600 px-2 py-1 rounded-xl font-semibold bg-red-100">
                                                        {{trans('company.Unselected')}}
                                                    </span>
                                            @endif

                                            {{-- Employeed --}}
                                            @if (!empty($item->employeed) && !$employeedShown)
                                                @php $employeedShown = true; @endphp
                                                <span
                                                    class="text-sm text-primary px-2 py-1 bg-[#E9F5FF] rounded-xl font-semibold employeed-trainee">
                                                        {{trans('admin/status.approved')}}
                                                    </span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2">
                                <div class="flex flex-col gap-4 justify-center items-center p-4">
                                    <img src="{{asset('/images/empty-box.png')}}" class="opacity-50 h-32" alt="Empty">
                                    <p class="dark:text-white">{{ trans('cgo.no_record') }}</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse


                    </tbody>
                </table>

            </div>

            {{--            // this renders the tailwind pagination from vendor --}}
            {{ $trainees->onEachSide(1)->links() }}
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        let url = new URL(window.location.href);
        $('#nvq_level').on('change', function() {
            if (url.searchParams.has('nvq_level')) {
                url.searchParams.set('nvq_level', this.value);
                url.searchParams.delete('page');
            } else {
                url.searchParams.append('nvq_level', this.value);
                url.searchParams.delete('page');
            }


            window.location.href = url.href;
        });

        $('#district').on('change', function() {
            if (url.searchParams.has('district')) {
                url.searchParams.set('district', this.value);
                url.searchParams.delete('page');
            } else {
                url.searchParams.append('district', this.value);
                url.searchParams.delete('page');
            }
            window.location.href = url.href;
        });

        $('#sector').on('change', function() {
            if (url.searchParams.has('sector')) {
                url.searchParams.set('sector', this.value);
                url.searchParams.delete('page');
            } else {
                url.searchParams.append('sector', this.value);
                url.searchParams.delete('page');
            }
            window.location.href = url.href;
        });
    </script>
    <script>
        function handleCheckboxChange(checkbox) {
            toggleLoadingOverlay();
            const ojt_id = checkbox.value;
            const traineeId = checkbox.getAttribute('data-trainee-id');
            const matched_by = checkbox.getAttribute('data-matched-by');
            const system = checkbox.getAttribute('data-system');
            $.ajax({
                url: '{{ route('cgo.job-support.ojt-list.match-trainee') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    ojt_id: ojt_id,
                    trainee_id: traineeId,
                    matched_by: matched_by,
                    system: system
                },
                success: function(response) {
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
@endpush
