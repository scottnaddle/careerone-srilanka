@extends('homepage.layouts.master')
@section('title', 'Career Guidance - Guidance - Create Offline')

@section('content')
    <div class="my-6 flex flex-col gap-5">
        <div class="py-6">
            <x-breadcrumb :items="[
                ['label' => trans('trainee.menu.home'), 'url' => route('homepage')],
                ['label' => trans('trainee.menu.career_guidance.root'), 'url' => '#'],
                ['label' => trans('trainee.guidance_history'), 'url' => route('trainee.career-guidance.counseling.counseling-history')],
                ['label' => trans('trainee.guidance_details'), 'url' => ''],
            ]" />
        </div>
        <div class="bg-white dark:bg-[#1E1E1E] rounded-xl px-4 py-5 flex flex-col gap-4 md:gap-6 pb-10">
            <a href="{{ route('trainee.career-guidance.counseling.counseling-history') }}"
                class="flex items-center gap-2 text-[#464559] dark:text-white text-xl font-semibold w-fit">
                <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15.5 6L9.5 12L15.5 18" stroke="#354052" stroke-width="2" class="dark:stroke-white"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>{{$counseling->title}}
            </a>



            <div class="flex gap-6 flex-col lg:flex-row">
                <div>
                    <label for=""
                        class="sm:text-base text-base font-semibold text-[#464559] block mb-1.5 dark:text-white">Requested
                        date</label>
                    <input type="text" id="" name="requested_date" maxlength="50"
                        class="mb-2 border border-[#EDEDED] text-[#706F81] text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-[#1E1E1E] dark:border-gray-600 dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        value="{{ date('H:i A d-m-Y', $counseling->created_at->timestamp) }}" readonly disabled>
                </div>
                <div>
                    <label for=""
                        class="sm:text-base text-base font-semibold text-[#464559] block mb-1.5 dark:text-white mb-5">Type</label>
                    <div class="flex gap-1 items-center">
                        @if ($counseling->counseling_type == getCodeIdByStringEn('counselling_type', 'online'))
                            <img src="{{ asset('images/online.svg') }}" alt="Online" class="w-3 h-3">
                            <span class="text-sm font-normal text-[#7AED86]">{{ getCodeNameByCodeId('counselling_type', $counseling->counseling_type) }}</span>
                        @endif
                        @if (
                            $counseling->counseling_type == getCodeIdByStringEn('counselling_type', 'offline')||
                                $counseling->counseling_type == getCodeIdByStringEn('counselling_type', 'Guidance without reservation'))
                            <img src="{{ asset('images/offline.svg') }}" alt="Offline" class="w-3 h-3">
                            <span class="text-sm font-normal text-[#91919A]">{{ getCodeNameByCodeId('counselling_type', $counseling->counseling_type) }}</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-start-2 col-end-5">
                <div>
                    <div>
                        <label for=""
                            class="sm:text-base text-base font-semibold text-[#464559] block mb-1.5 dark:text-white">{{ __('cgo.counseling_field') }}</label>
                            <div class="relative w-full">
                                <input
                                    class="mb-2 border border-[#EDEDED] text-[#706F81] text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-gray-600 dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    disabled />
                                    <label
                                    class="absolute left-2 top-1/2 transform -translate-y-1/2 text-primary bg-[#F6FBFF] dark:bg-[#455E85] dark:text-[#4984F6] dark:bg-opacity-25 px-2 py-2 font-semibold rounded-lg text-base sm:text-sm leading-tight w-auto ">
                                    {{ getCodeNameByCodeId('counselling_field', $counseling->counseling_field_id) }}
                                </label>
                            </div>

                    </div>
                </div>
            </div>

            <div class="col-start-2 col-end-5">
                <div>
                    <label for=""
                        class="sm:text-base text-base font-semibold text-[#464559] block mb-1.5 dark:text-white">{{ __('cgo.title') }}</label>
                    <input type="text" id="" name="title" maxlength="50"
                        class="mb-2 border border-[#EDEDED] text-[#706F81] text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-gray-600 dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        value="{{ $counseling->title }}" readonly disabled>
                </div>
            </div>

            <div class="col-start-2 col-end-5">
                <div>
                    <div>
                        <label for=""
                            class="sm:text-base text-base font-semibold text-[#464559] block mb-1.5 dark:text-white">Location</label>
                        <textarea type="text" id="" name="location" maxlength="50" rows="2"
                            class="mb-2 border border-[#EDEDED] text-[#706F81] text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-gray-600 dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            readonly disabled>{{ $counseling->district->name ?? '' }}</textarea>
                    </div>
                </div>
            </div>

            <div class="col-start-2 col-end-5">
                <div>
                    <div>
                        <label for=""
                               class="sm:text-base text-base font-semibold text-[#464559] block mb-1.5 dark:text-white">Institute</label>
                        <textarea type="text" id="" name="institute" maxlength="50" rows="2"
                                  class="mb-2 border border-[#EDEDED] text-[#706F81] text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-gray-600 dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                  readonly disabled>{{ $counseling->institute->name ?? '' }}</textarea>
                    </div>
                </div>
            </div>

            <div class="col-start-2 col-end-5">
                <div>
                    <label for=""
                        class="sm:text-base text-base font-semibold text-[#464559] block mb-1.5 dark:text-white">{{ __('cgo.detail_information') }}</label>
                    <textarea type="" id="" name="detail_information" maxlength="1000" rows="6"
                        class=" mb-2 border border-[#EDEDED] text-[#706F81] text-base rounded-lg
                       focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E]
                       dark:border-gray-600 dark:placeholder-white dark:text-white dark:focus:ring-blue-500
                       dark:focus:border-blue-500"
                        readonly disabled>{{ $counseling->detail_information }}</textarea>
                </div>
            </div>

            <div class="col-start-2 col-end-5">
                <div>
                    <div>
                        <label for=""
                            class="sm:text-base text-base font-semibold text-[#464559] block mb-1.5 dark:text-white">{{ __('cgo.available_time') }}</label>
                        <input type="text" id="" name="title" maxlength="50"
                            class="mb-2 border border-[#EDEDED] text-[#706F81] text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-gray-600 dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            value="{{ date("Y-m-d", strtotime($counseling->available_time)) }} {{$counseling->shift ?? ''}}" readonly disabled>
                    </div>
                </div>
            </div>
            @if ($counseling->status == \App\Enums\CgoCounselingStatusEnums::CONFIRM->value)
                <div class="col-start-2 col-end-5">
                <div>
                    <label for=""
                        class="sm:text-base text-base font-semibold text-[#464559] block mb-1.5 dark:text-white">{{ __('cgo.cgo_confirm') }}</label>
                    <input type="text" id="" name="title" maxlength="50"
                        class="mb-2 border border-[#EDEDED] text-[#706F81] text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-gray-600 dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        value=" {{ $counseling->first_name }} {{ $counseling->last_name }}" readonly disabled>
                </div>
            </div>
            @endif

            @if (!empty($counseling->counselingAttachment))
            <ul class="space-y-3">
                <label for=""
                    class="sm:text-base text-base font-semibold text-[#464559] block mb-1.5 dark:text-white">{{ __('Attach File') }}</label>
                @forelse ($counseling->counselingAttachment as $file)
                    <li class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200 dark:bg-[#282828] dark:text-white">
                        <span class="flex-grow">{{ $file->file_name }}</span>
                        <a href="{{ route('trainee.career-guidance.counseling.attachments.download', ['id' => $file->id]) }}"
                            class="flex items-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            <i class="fas fa-download mr-2"></i>
                            Download
                        </a>
                    </li>
                @empty
                    <p class="dark:text-white">No file uploaded</p>
                @endforelse

            </ul>
        @endif

            {{--                button form --}}

            @if ($counseling->status == getCodeIdByStringEn('counselling_status', 'completed'))
            <div class="col-start-2 col-end-5">
                <div>
                    <label for=""
                        class="sm:text-base text-base font-semibold text-[#464559] block mb-1.5 dark:text-white">{{ __('cgo.result') }}
                    </label>
                    <textarea type="" id="" name="result" maxlength="1000" rows="6"
                        class=" mb-2 border border-[#EDEDED] text-[#706F81] text-base rounded-lg
                   focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E]
                   dark:border-gray-600 dark:placeholder-white dark:text-white dark:focus:ring-blue-500
                   dark:focus:border-blue-500"
                        readonly disabled>{{ $counseling->result }}</textarea>
                </div>
                <div class="col-start-2 col-end-5">

                    <div class="col-start-2 col-end-5">
                        <div class="">
                            <label for=""
                                   class="sm:text-base text-base font-semibold text-[#464559] block mb-1.5 dark:text-white">{{ __('cgo.suggested_training_information') }}</label>
                            @if($counseling->suggested_institutes != null && count(json_decode($counseling->suggested_institutes)) > 0)
                            <div class="border p-2 font-semibold rounded-t-xl dark:text-white">
                                {{trans('cgo.institutes')}}
                            </div>
                            <div class="">
                                @forelse(json_decode($counseling->suggested_institutes) as $item)
                                    <div class="border p-2">
                                        <p class="dark:text-white text-sm">{{$item->text}}</p>
                                    </div>
                                @empty
                                @endforelse
                            </div>
                            @endif
                            @if($counseling->suggested_nvq_courses != null && count(json_decode($counseling->suggested_nvq_courses)) > 0)
                            <div class="border p-2 font-semibold dark:text-white">
                                {{trans('cgo.nvq_courses')}}
                            </div>
                            <div class="">
                                @forelse(json_decode($counseling->suggested_nvq_courses) as $item)
                                    <div class="border p-2">
                                        <p class="dark:text-white text-sm">{{$item->text}}</p>
                                    </div>
                                @empty
                                @endforelse
                            </div>
                            @endif
                            @if($counseling->suggested_tvec_courses != null && count(json_decode($counseling->suggested_tvec_courses)) > 0)
                            <div class="border p-2 font-semibold dark:text-white">
                                {{trans('cgo.tvec_courses')}}
                            </div>
                            <div class=" rounded-b-xl">
                                @forelse(json_decode($counseling->suggested_tvec_courses) as $item)
                                    <div class="border p-2 {{ $loop->last ? 'rounded-b-xl' : '' }}">
                                        <p class="dark:text-white text-sm">{{$item->text}}</p>
                                    </div>
                                @empty
                                @endforelse
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-start-2 col-end-5">
                <div>
                    <label for=""
                        class="sm:text-base text-base font-semibold text-[#464559] block mb-1.5 dark:text-white">{{ __('Feedback of Trainee') }}
                    </label>
                    <textarea type="" id="" name="result" maxlength="1000" rows="6"
                        class=" mb-2 border border-[#EDEDED] text-[#706F81] text-base rounded-lg
                   focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E]
                   dark:border-gray-600 dark:placeholder-white dark:text-white dark:focus:ring-blue-500
                   dark:focus:border-blue-500"
                        readonly disabled>{{ $counseling->trainee_feedback }}</textarea>
                </div>
            </div>
        @endif
            @if (
                $counseling->status == getCodeIdByStringEn('counselling_status', 'completed') &&
                    $counseling->counseling_type != getCodeIdByStringEn('counselling_type', 'Guidance without reservation'))
                <div class="flex flex-col items-center justify-center gap-6">
                    <div class="flex flex-col gap-1 items-center">
                        <p class="text-[#706F81] dark:text-white text-base md:text-lg">This is your feedback for the
                            following
                            CGO</p>
                        <p class="text-[#201F36] dark:text-white text-xl md:text-2xl font-semibold">
                            {{ $counseling->first_name }} {{ $counseling->last_name }}</p>
                    </div>
                    <div class="flex gap-4 md:gap-6 justify-center">
                        @if ($counseling->feedback)
                            @for ($i = 0; $i < $counseling->feedback; $i++)
                                <button type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="43" height="42"
                                        viewBox="0 0 43 42" fill="none">
                                        <path
                                            d="M21.5 0L27.4496 12.8111L41.4722 14.5106L31.1266 24.1279L33.8435 37.9894L21.5 31.122L9.15651 37.9894L11.8734 24.1279L1.52781 14.5106L15.5504 12.8111L21.5 0Z"
                                            fill="#FCC75E" />
                                    </svg>
                                </button>
                            @endfor
                            @for ($i = 5; $i > $counseling->feedback; $i--)
                                <button type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="43" height="42"
                                        viewBox="0 0 43 42" fill="none">
                                        <path
                                            d="M21.5 0L27.4496 12.8111L41.4722 14.5106L31.1266 24.1279L33.8435 37.9894L21.5 31.122L9.15651 37.9894L11.8734 24.1279L1.52781 14.5106L15.5504 12.8111L21.5 0Z"
                                            fill="#F5F7FA" />
                                    </svg>
                                </button>
                            @endfor
                        @else
                            @for ($i = 0; $i < 5; $i++)
                                <button type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="43" height="42"
                                        viewBox="0 0 43 42" fill="none">
                                        <path
                                            d="M21.5 0L27.4496 12.8111L41.4722 14.5106L31.1266 24.1279L33.8435 37.9894L21.5 31.122L9.15651 37.9894L11.8734 24.1279L1.52781 14.5106L15.5504 12.8111L21.5 0Z"
                                            fill="#F5F7FA" />
                                    </svg>
                                </button>
                            @endfor
                        @endif
                    </div>
                    <div class="flex flex-wrap gap-2 md:gap-4 w-1/3 justify-center">

                        @if ($counseling->feedback_message)
                            @foreach (json_decode($counseling->feedback_message) as $feedback)
                                <button type="button"
                                    class="text-white bg-primary hover:bg-blue-700 font-medium rounded-lg text-base px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">{{ __("cgo.$feedback") }}</button>
                            @endforeach
                        @endif
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection
@push('js')

{{--    <script>--}}
{{--        document.getElementById('cancel_reason').addEventListener('input', function() {--}}
{{--            var charCount = this.value.length;--}}
{{--            var charCountElement = document.getElementById('char-count');--}}
{{--            var errorMessage = document.getElementById('error-message');--}}

{{--            charCountElement.textContent = charCount;--}}

{{--            if (charCount > 1000) {--}}
{{--                errorMessage.style.display = 'block';--}}
{{--            } else {--}}
{{--                errorMessage.style.display = 'none';--}}
{{--            }--}}
{{--        });--}}

{{--        document.getElementById('form-deny-counseling').addEventListener('submit', function(event) {--}}
{{--            var charCount = document.getElementById('cancel_reason').value.length;--}}
{{--            if (charCount > 1000) {--}}
{{--                event.preventDefault(); // Prevent form submission--}}
{{--                alert('The form cannot be submitted because the character limit of 1000 has been exceeded.');--}}
{{--            }--}}
{{--        });--}}
{{--    </script>--}}
@endpush
