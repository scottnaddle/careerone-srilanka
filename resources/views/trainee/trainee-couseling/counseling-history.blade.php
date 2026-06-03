@extends('homepage.layouts.master')
@section('title', 'Career Guidance - Guidance - History')

@section('content')
    <div class="mb-6 flex flex-col">
        <div class="py-6">
            <x-breadcrumb :items="[
                ['label' => trans('trainee.menu.home'), 'url' => route('homepage')],
                ['label' => trans('trainee.menu.career_guidance.root'), 'url' => '#'],
                ['label' => trans('trainee.guidance_history'), 'url' => '#'],
            ]" />
        </div>

        <div class="bg-white dark:bg-[#1E1E1E] rounded-xl px-4 py-5 flex flex-col gap-4 md:gap-6 pb-10">
            <div class="flex flex-col gap-4 md:gap-4">
                <ul
                    class="flex flex-nowrap text-center text-gray-500 rounded-lg  dark:divide-gray-700 dark:text-gray-400 sm:p-0">
                    <li class="flex-1">
                        <a href="{{ route('trainee.career-guidance.counseling.counseling-request') }}"
                            class="text-sm sm:text-lg {{ Request::is('trainee/career-guidance/counseling/counseling-request') ? 'bg-primary text-white font-bold' : 'text-[#91919A] bg-[#F8F8F8]' }} inline-block w-full p-4 rounded-l-xl focus:ring-4 focus:ring-blue-300 focus:outline-none ">
                            {{ __('trainee.Request')}}
                        </a>
                    </li>
                    <li class="flex-1">
                        <a href="{{ route('trainee.career-guidance.counseling.counseling-history') }}"
                            class="text-sm sm:text-lg {{ Request::is('trainee/career-guidance/counseling/counseling-history') ? 'bg-primary text-white font-bold' : 'text-[#91919A] bg-[#F8F8F8]' }} inline-block w-full p-4 rounded-r-xl focus:ring-4 focus:ring-blue-300 focus:outline-none dark:primary "
                            aria-current="page">
                            {{ __('trainee.History')}}
                        </a>
                    </li>
                </ul>

                @forelse ($listCounselingHistory as $counseling)

                    <div
                        class="bg-white dark:bg-[#282828] w-full space-x-1 rounded-t-lg border-b border-gray-100 px-2.5 py-4 dark:border-gray-700 border-opacity-70 hover:bg-blue-100 dark:hover:bg-gray-700">
                        <div class="flex items-center ">
                            @if ($counseling->status == getCodeIdByStringEn('counselling_status', 'completed'))
                                @if ($counseling->feedback)
                                    <label
                                        class="text-[#62B96A] bg-[#F5FFF1] dark:bg-[#597050] dark:bg-opacity-25 px-2 py-1 rounded-lg font-semibold text-xs sm:text-sm leading-tight">
                                        {{getCodeNameByCodeId('counselling_status', $counseling->status)}}
                                    </label>
                                    @for ($i = 0; $i < $counseling->feedback; $i++)
                                        <svg class="w-3 h-3 text-yellow-300 ms-1" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                            <path
                                                d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                                        </svg>
                                    @endfor
                                    @for ($i = 5; $i > $counseling->feedback; $i--)
                                        <svg class="w-3 h-3 ms-1 text-gray-300 dark:text-gray-500" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                            <path
                                                d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                                        </svg>
                                    @endfor
                                @else
                                    <label
                                        class="text-primary bg-[#F6FBFF] dark:bg-[#455E85 dark:text-[#4984F6] dark:bg-opacity-25 px-2 py-1 font-semibold rounded-lg text-xs sm:text-sm leading-tight">
                                        {{ __('Feedback') }}
                                    </label>
                                    @for ($i = 0; $i < 5; $i++)
                                        <button class="show-modal-review" data-id="{{ $counseling->id }}">
                                            <svg class="w-3 h-3 ms-1 text-gray-300 dark:text-gray-500" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                                <path
                                                    d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                                            </svg>
                                        </button>
                                    @endfor
                                @endif
                            @endif
                            @if (
                                $counseling->status == getCodeIdByStringEn('counselling_status', 'request') ||
                                    $counseling->status == \App\Enums\CgoCounselingStatusEnums::RE_ASSIGN->value)
                                <label
                                    class="text-[#91919A] dark:text-white bg-[#F8F8F8] dark:bg-gray-500 px-2 py-1 rounded-lg font-semibold text-xs sm:text-sm mb-1 leading-tight">
                                    {{getCodeNameByCodeId('counselling_status', $counseling->status)}}
                                </label>
                            @endif
                            @if ($counseling->status == getCodeIdByStringEn('counselling_status', 'confirm'))
                                <label
                                    class="bg-yellow-50 dark:bg-[#55543D] dark:bg-opacity-25 text-yellow-300 dark:text-[#FCC75E] px-2 py-1 font-semibold rounded-lg text-xs sm:text-sm mb-1 leading-tight">
                                    {{getCodeNameByCodeId('counselling_status', $counseling->status)}}
                                </label>
                            @endif
                            @if ($counseling->status == getCodeIdByStringEn('counselling_status', 'cancel'))
                                <label
                                    class="text-red-500 bg-red-100 dark:bg-[#F34550]  dark:bg-opacity-25  px-2 py-1 font-semibold rounded-lg text-xs sm:text-sm mb-1 leading-tight">
                                    {{getCodeNameByCodeId('counselling_status', $counseling->status)}}
                                </label>
                            @endif
                        </div>

                        <div class="mt-1">
                            <a
                            @if ($counseling->status==\App\Enums\CgoCounselingStatusEnums::REQUEST->value )
                                 href="{{ route('trainee.career-guidance.counseling.get-edit', ['id' => $counseling->id]) }}"
                            @else
                                 href="{{ route('trainee.career-guidance.counseling.counseling-list.show', ['id' => $counseling->id]) }}"
                            @endif
                               >
                                <span
                                    class="font-semibold text-lg block dark:text-white truncate leading-tight hover:text-primary dark:hover:text-primary">
                                    {{ $counseling->title }}
                                </span>
                            </a>
                        </div>

                        <div class="flex text-center items-center pr-2">
                            <div class="py-1">
                                <span class="font-semibold text-xs sm:text-sm leading-tight">
{{--                                    @if ($counseling->counseling_type == \App\Enums\CgoCounselingTypeEnums::ONLINE->value)--}}
{{--                                        <span class="text-xs text-[#706F81]  leading-tight">Online</span>--}}
{{--                                    @endif--}}
{{--                                    @if (--}}
{{--                                        $counseling->counseling_type == \App\Enums\CgoCounselingTypeEnums::OFFLINE->value ||--}}
{{--                                            $counseling->counseling_type == \App\Enums\CgoCounselingTypeEnums::OFFLINE_CGO->value)--}}
{{--                                        <span class="text-xs text-[#706F81]  leading-tight">Offline</span>--}}
{{--                                    @endif--}}

                                    <span class="text-sm text-[#706F81] leading-tight">{{getCodeNameByCodeId('counselling_type', $counseling->counseling_type)}}</span>
                                </span>
                            </div>

                            <div class="flex items-center px-1 ">
                                <span class="text-gray-400 dark:text-gray-600 text-sm">|</span>
                            </div>

                            <div class="py-1">
                                <span class="font-semibold text-sm text-[#706F81] ">
                                    {{ getCodeNameByCodeId('counselling_field', $counseling->counseling_field_id) }}
                                </span>
                            </div>

                            <div class="flex items-center px-1">
                                <span class="text-gray-400 dark:text-gray-600 text-sm">|</span>
                            </div>

                            <div class="py-1">
                                <span class="text-sm text-[#706F81] dark:text-gray-400 leading-tight">
                                    {{ date('Y-m-d', strtotime($counseling->available_time)) }}
                                </span>
                            </div>


                        </div>
                        @if ($counseling->status == \App\Enums\CgoCounselingStatusEnums::COMPLETED->value && $counseling->feedback)
                            <a href="{{ route('trainee.career-guidance.counseling.counseling-list.show', ['id' => $counseling->id]) }}"
                               class="ml-auto flex items-center text-blue-400 dark:text-blue-400  font-semibold text-xs sm:text-sm">
                                    <span class="mr-2 text-[#4984F6] dark:text-[#4984F6]  text-xs justify-end">
                                        Result
                                    </span>
                                <svg class="w-4 h-4 text-[#4984F6] dark:text-[#4984F6] hover:text-blue-600"
                                     aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                     viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                          stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                </svg>
                            </a>
                        @endif
                    </div>

                    @if ($counseling->status == \App\Enums\CgoCounselingStatusEnums::COMPLETED->value && empty($counseling->feedback) )
                        <div id="reviewModal-{{ $counseling->id }}" style="z-index: 50"
                            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
                            <div class="bg-white p-6 rounded-xl shadow-lg max-w-md mx-auto relative">
                                <button class="absolute top-2 right-2 text-gray-500"
                                    onclick="document.getElementById('reviewModal-{{ $counseling->id }}').classList.add('hidden');">
                                    &times;
                                </button>

                                <form method="POST" data-id="{{ $counseling->id }}"
                                    action="{{ route('trainee.career-guidance.counseling.store-counseling-feedback', ['cgoCounseling' => $counseling->id]) }}">
                                    @csrf
                                    <div class="mb-4 flex justify-center items-center top-10 custom-padding-counseling">
                                        <div class="relative-custom">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <label class="absolute transform -translate-x-1/2"
                                                    style="left: {{ 45 + 180 * sin(deg2rad(20 * ($i - 3))) }}px; top: {{ 180 - 180 * cos(deg2rad(20 * ($i - 3))) }}px;">
                                                    <input type="radio" name="rating" value="{{ $i }}"
                                                        class="hidden" onchange="handleStarClick({{ $i }})">
                                                    <svg class="star w-12 h-12 cursor-pointer text-gray-400 hover:text-yellow-500 hover:scale-125 transition-transform duration-200"
                                                        aria-hidden="true" data-star="{{ $i }}"
                                                        onmouseover="handleStarHover({{ $i }})"
                                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                        viewBox="0 0 22 20">
                                                        <path
                                                            d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                                                    </svg>
                                                </label>
                                            @endfor
                                        </div>
                                    </div>

                                    <div class="mb-4 flex justify-center">

                                        <span class="text-center block">Please give us your feedback <br> for the following
                                            CGO
                                            {{ $counseling->first_name }} {{ $counseling->last_name }}</span>
                                    </div>




                                    <div class="mb-4 flex flex-wrap-custom-button justify-center space-x-2">
                                        @foreach ($listCounselingHistory->missing_feedback as $index => $miss_feedback)
                                            <label class="checkbox-button">
                                                <input type="checkbox" name="selected_buttons[]"
                                                    value="{{ $miss_feedback }}" class="hidden">
                                                <span class="custom-button">{{ __("cgo.$miss_feedback") }}</span>
                                            </label>
                                        @endforeach

                                    </div>

                                    <div class="">
                                        <textarea id="feedback_result" name="feedback_result" class="w-full h-32 p-2 border rounded-lg"
                                            placeholder="Leave your feedback here"></textarea>
                                    </div>
                                    <div class="mb-2 ">
                                        <div class="text-red-500" id="selected_buttons_container_{{ $counseling->id }}">
                                        </div>
                                    </div>

                                    <div class="flex justify-end">
                                        <button type="submit"
                                        class="submit-rating bg-blue-500 text-white w-full py-2 rounded-lg flex items-center justify-center"
                                        data-id="{{ $counseling->id }}">
                                            Submit
                                        </button>

                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                @empty
                    <tr>
                        <td colspan="9">
                            <div class="flex flex-col gap-4 justify-center items-center p-4">
                                <img src="{{ asset('/images/empty-box.png') }}" class="opacity-50 h-32" alt="Empty">
                                <p class="dark:text-white">No record!</p>
                            </div>
                        </td>
                    </tr>
                @endforelse

                <div class="flex flex-col gap-4 pb-6">
                    @if (count($listCounselingHistory) > 0)
                        <div class="mt-3">
                            {{ $listCounselingHistory->onEachSide(1)->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>


@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        if ('{{ Session::get('success') }}') {
            Toastify({
                text: '{{ Session::get('success') }}',
                duration: 3000,

                newWindow: true,
                close: true,
                gravity: "top",
                position: "right",
                stopOnFocus: true,
                style: {
                    background: "linear-gradient(to right, #00b09b, #96c93d)",
                },
                onClick: function() {}
            }).showToast();
        } else if ('{{ Session::get('error') }}') {
            Toastify({
                text: '{{ Session::get('error') }}',
                duration: 3000,

                newWindow: true,
                close: true,
                gravity: "top",
                position: "right",
                stopOnFocus: true,
                style: {
                    background: "linear-gradient(to right, #db4a4a, #bb7f7f)",
                },
                onClick: function() {}
            }).showToast();
        }


        function handleStarClick(selectedStar) {
            const stars = document.querySelectorAll('.star');
            stars.forEach(star => {
                const starValue = star.getAttribute('data-star');
                if (starValue <= selectedStar) {
                    star.classList.add('text-yellow-500');
                    star.style = "color: #fbbf24;"
                    star.classList.remove('text-gray-400');
                } else {
                    star.classList.add('text-gray-400');
                    star.style = "color: none;"
                    star.classList.remove('text-yellow-500');
                }
            });
        }

        function handleStarHover(hoveredStar) {
            const stars = document.querySelectorAll('.star');
            stars.forEach(star => {
                const starValue = star.getAttribute('data-star');
                if (starValue <= hoveredStar) {
                    star.classList.add('scale-125');
                } else {
                    star.classList.remove('scale-125');
                }
            });
        }

        function handleStarLeave() {
            document.querySelectorAll('.star').forEach(s => {
                s.classList.remove('hovered');
            });
        }
        $(".show-modal-review").on("click", function() {
            var target = $(this).data("id");
            document.getElementById('reviewModal-' + target).classList.remove('hidden');

        });
        $(window).on("load", function () {
            var hash = window.location.hash;
            if (hash.startsWith("#show-")) {
                var targetId = hash.split("-")[1];
                if (targetId) {
                    $('[data-id="' + targetId + '"]').trigger("click");
                    $('#reviewModal-' + targetId).removeClass("hidden");
                }
            }
        });


    </script>
    <script>
        $(document).ready(function() {
            const form = $('form');
            $(document).on('click', '.submit-rating', function(event) {
                event.preventDefault();
                const form = $(this).closest('form');
                const formId = $(this).data('id');

                if (validateFormFeedback(formId, form)) {
                    form.submit();
                }
            });
            var ratting = $('input[name="rating"]');
            ratting.on('change',function(e){
                var _id = form.data("id");
                var container = $('#selected_buttons_container_' + _id);
                container.text('')
            })
            function validateFormFeedback(id) {
                clearErrors(id);
                const container = $('#selected_buttons_container_' + id);

                let isValid = true;
                let errorMessages = [];

                const rating = form.find('input[name="rating"]:checked').val();
                const feedbackResult = $("#feedback_result").val();
                const selectedButtons = form.find('input[name="selected_buttons[]"]:checked');
                if (!rating) {
                    container.text('Please select a rating.')
                    errorMessages.push('Please select a rating.');
                } else if (selectedButtons.length === 0) {
                    container.text('Please select at least one option.')
                    errorMessages.push('Please select at least one option.');
                } else if (feedbackResult.length > 255) {
                    container.text('Feedback Result Length must not exceed 255 characters')
                    errorMessages.push('Feedback Result Length must not exceed 255 characters');
                }

                if (errorMessages.length > 0) {
                    // showErrors(errorMessages,id);
                    isValid = false;
                }

                return isValid;
            }

            function showErrors(messages, id) {
                const container = $('#selected_buttons_container_' + id);
                messages.forEach(message => {
                    const error = $('<div>', {
                        class: 'text-red-500 mb-2',
                        text: message
                    });
                    container.append(error)
                });
            }

            function clearErrors(id) {
                $('#selected_buttons_container_' + id + ' .text-red-500').remove();
            }
        });
    </script>
@endpush
@push('css')
    <style>
        .star {
            position: absolute;
            transform-origin: center;
        }

        .relative-custom {
            position: relative;
            width: 150px;
            height: 100px;
        }

        .custom-padding-counseling {
            padding-top: 10%;
        }

        .flex-wrap-custom-button>button {
            flex-basis: 33.33%;
            text-align: center;
        }

        .flex-wrap-custom-button {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .checkbox-button {
            display: inline-block;
            position: relative;
            padding-bottom: 0.5rem
        }

        .checkbox-button input:checked+.custom-button {
            background-color: #3b82f6;
            color: white;
        }

        .custom-button {
            display: inline-block;
            padding: 0.5rem 1rem;
            font-size: 1rem;
            font-weight: 500;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            cursor: pointer;
            transition: background-color 0.2s, color 0.2s;
        }


    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
@endpush
