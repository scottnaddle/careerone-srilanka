<style>
    .dz-preview .dz-image img {
        width: 100% !important;
        height: 100% !important;
        object-fit: cover;
    }

    .dropzone {
        background: white;
        border-width: 1px;
        border-radius: 0.5rem;
        --tw-border-opacity: 1;
        border-color: rgb(209 213 219 / var(--tw-border-opacity));
    }

    .dropzone:hover {
        background-color: aliceblue !important;
    }

    .ck-editor__editable_inline {
        min-height: 200px;
    }

    #container {
        width: 1000px;
        margin: 20px auto;
    }

    .ck-editor__editable[role="textbox"] {
        /* Editing area */
        min-height: 200px;
    }

    .ck-content .image {
        /* Block images */
        max-width: 80%;
        margin: 20px auto;
    }

    .reply-item {
        /* width: fit-content; */
        display: flex;
        gap: 4px;
    }

    .reply-container {
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 30px;
    }

    .reply-child-container-style {
        margin-left: 60px;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .reply-content-child-container {
        display: flex;
        gap: 4px;
    }

    .dropdown {
        visibility: hidden;
        opacity: 0;
        position: absolute;
        transition: visibility 0s, opacity 0.2s ease-in-out;
    }

    .dropdown.show {
        visibility: visible;
        opacity: 1;
    }
</style>
<div class="flex flex-col gap-4 p-4 bg-white dark:bg-[#1E1E1E] rounded-xl">
    <div class="reply">
        <div class="reply-container reply-container-append">
            @foreach ($content->comments as $item)
                <div class="flex gap-3 flex-col reply-remove-{{ $item->id }}">
                    <div class="reply-item-container">
                        <div class="reply-item">
                            @if (isset($item->author->profile_image))
                                <img class="w-12 h-12 me-2 rounded-full object-cover"
                                     src="{{ asset($item->author->profile_image) }}">
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor" class="size-12">
                                    <path stroke-linecap="round" class="stroke-primary" stroke-linejoin="round"
                                          d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                            @endif
                            <div class="flex flex-col w-full pr-2">
                                <div class="flex justify-between font-semibold text-base items-center">
                                    <p class="dark:text-white">{{ $item->user?->fullName }}</p>
{{--                                    @if (Auth::guard(activeGuard())->check() || Auth::guard('admin')->check() &&--}}
{{--                                            $item->answer_by == Auth::guard(activeGuard())->user()->id &&--}}
{{--                                            $item->system == activeGuard())--}}
                                    @php
                                        $user = Auth::guard(activeGuard())->user();
                                    @endphp

                                    @if (
                                        (Auth::guard(activeGuard())->check() && $item->answer_by == $user?->id && $item->system == activeGuard()) ||
                                        (Auth::guard('admin')->check())
                                    )
                                        <button type="button"
                                                data-dropdown-toggle="action-dropdown-menu-{{ $item->id }}"
                                                class="inline-flex items-center font-semibold justify-center text-primary cursor-pointer bg-white dark:bg-[#1E1E1E] dark:text-white">
                                            <div>
                                                <p title="Action"
                                                   class="text-xl tracking-wider font-semibold text-gray-700 dark:text-white heading-6">
                                                    ...</p>
                                            </div>

                                        </button>
                                        <div class="w-fit z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-xl border shadow-lg  dark:bg-[#1E1E1E]"
                                             id="action-dropdown-menu-{{ $item->id }}">
                                            <ul class="font-medium" role="none">
                                                <li>
                                                    <form class="delete-reply-form" data-id="{{ $item->id }}"
                                                          data-element=".reply-remove-{{ $item->id }}"
                                                          action="{{ route('informations.contents.content-comments.delete', ['qNAAnswer' => $item]) }}"
                                                          method="POST" method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="w-full block px-6 py-2 text-sm text-gray-900 hover:bg-primary hover:text-white dark:text-gray-400 dark:hover:bg-[#383838] dark:hover:text-white hover:rounded-xl"
                                                                role="menuitem">
                                                            <div class="inline-flex items-center">
                                                                {{ trans('system.form.button.delete') }}
                                                            </div>
                                                        </button>
                                                    </form>

                                                </li>

                                            </ul>
                                        </div>
                                    @endif
                                </div>
                                <div class="mr-3">
                                    <p id="article-answer-{{ $item->id }}"
                                       class="font-medium text-[#706F81] text-base whitespace-normal mr-3 dark:text-white"
                                       style="word-break: break-word; overflow-wrap: break-word;">
                                        {{ \Illuminate\Support\Str::limit($item->answer, 150) }}
                                    </p>
                                    @if (strlen($item->answer) > 150)
                                        <button class="btn btn-primary btn-readmore text-sm text-primary underline"
                                                data-id="{{ $item->id }}"
                                                data-answer="{{ $item->answer }}">{{ trans('system.information.qna.read_more') }}</button>
                                    @endif
                                    <button class="btn btn-primary btn-showless hidden text-sm text-primary underline "
                                            data-id="{{ $item->id }}"
                                            data-summary="{{ \Illuminate\Support\Str::limit($item->answer, 150) }}"
                                            data-answer="{{ $item->answer }}">{{ trans('system.information.qna.show_less') }}</button>
                                </div>

                            </div>

                        </div>

                        <div class="flex">
                            <div class="w-12"></div>
                            <p class="font-medium text-xs text-[#91919A]">{{ $item->created_at }}</p>
                        </div>
                    </div>
                    <div class=" reply-child-container-style" id="reply-child-container-{{ $item->id }}">
                        @foreach ($item->children as $reply)
                            <div class="reply-item reply-item-{{ $reply->id }}">
                                @if (isset($reply->author->profile_image))
                                    <img class="w-8 h-8 me-2 rounded-full object-cover"
                                         src="{{ asset($reply->author->profile_image) }}">
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke-width="1.5" stroke="currentColor" class="size-10">
                                        <path stroke-linecap="round" class="stroke-primary" stroke-linejoin="round"
                                              d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                @endif



                                <div class="w-full flex flex-col pr-2">
                                    <div class="flex justify-between font-semibold text-base dark:text-white">
                                        @if ($reply->author)
                                            <p class="dark:text-white">{{ \Str::limit($reply->author?->fullName, 20) }}
                                            </p>
                                        @else
                                            Admin
                                        @endif
                                        @if (Auth::guard('admin')->check() || (Auth::guard(activeGuard())->check() &&
                                                $reply->answer_by == Auth::guard(activeGuard())->user()->id &&
                                                $reply->system == activeGuard()))
                                            <button type="button"
                                                    data-dropdown-toggle="action-dropdown-menu-{{ $reply->id }}"
                                                    class="inline-flex items-center font-semibold justify-center text-primary cursor-pointer bg-white dark:bg-[#1E1E1E] dark:text-white hover:rounded-lg">
                                                <div>
                                                    <p
                                                        class="text-xl tracking-wider font-semibold text-gray-700 dark:text-white heading-6">
                                                        ...</p>
                                                </div>

                                            </button>
                                            <div class="w-fit z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-xl border shadow-lg  dark:bg-[#1E1E1E]"
                                                 id="action-dropdown-menu-{{ $reply->id }}">
                                                <ul class="font-medium" role="none">
                                                    <li>
                                                        <form class="delete-reply-form" data-id="{{ $reply->id }}"
                                                              data-element=".reply-item-{{ $reply->id }}"
                                                              action="{{ route('informations.contents.content-comments.delete', ['qNAAnswer' => $reply]) }}"
                                                              method="POST" method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                    class="w-full block px-6 py-2 text-sm text-gray-900 hover:bg-primary hover:text-white dark:text-gray-400 dark:hover:bg-[#383838] dark:hover:text-white hover:rounded-xl"
                                                                    role="menuitem">
                                                                <div class="inline-flex items-center">
                                                                    {{ trans('system.form.button.delete') }}
                                                                </div>
                                                            </button>
                                                        </form>

                                                    </li>

                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                                    {{-- <p class="font-medium text-[#706F81] text-base">{{ $reply->answer }}</p> --}}
                                    <div class="">
                                        <p id="article-answer-{{ $reply->id }}"
                                           class="font-medium text-[#706F81] text-base whitespace-wrap mr-3 dark:text-white"
                                           style="word-break: break-word; overflow-wrap: break-word;">
                                            {{ \Illuminate\Support\Str::limit($reply->answer, 150) }}
                                        </p>
                                        @if (strlen($reply->answer) > 150)
                                            <button class="btn btn-primary btn-readmore text-sm text-primary underline"
                                                    data-id="{{ $reply->id }}"
                                                    data-answer="{{ $reply->answer }}">{{ trans('system.information.qna.read_more') }}</button>
                                        @endif
                                        <button
                                            class="btn btn-primary btn-showless hidden text-sm text-primary underline"
                                            data-id="{{ $reply->id }}"
                                            data-summary="{{ \Illuminate\Support\Str::limit($reply->answer, 150) }}"
                                            data-answer="{{ $reply->answer }}">{{ trans('system.information.qna.show_less') }}</button>
                                    </div>


                                    <p class="font-medium text-xs text-[#91919A]">{{ $reply->created_at }}</p>
                                </div>

                            </div>
                        @endforeach
                        @if (Auth::guard(activeGuard())->check() || Auth::guard('admin')->check())
                            <form id="contentFormParent" class="flex flex-col gap-2">
                                @csrf
                                <input type="text" value="{{ $content->id }}" name="qna_id" hidden>
                                <input type="text" value="{{ $item->id }}" name="parent_id" hidden>
                                <input type="text" value="{{ $type ?? 'content' }}" name="type" hidden>
                                <input type="text" value="{{ activeGuard() ?? 'admin' }}" name="system" hidden>
                                <div class="reply-content-child-container">
                                    @if (isset(Auth::guard(activeGuard())->user()->profile_image))
                                        <img class="w-8 h-8 me-2 rounded-full object-cover"
                                             src="{{ asset(Auth::guard(activeGuard())->user()->profile_image) }}">
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="1.5" stroke="currentColor" class="size-12">
                                            <path stroke-linecap="round" class="stroke-primary"
                                                  stroke-linejoin="round"
                                                  d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                    @endif
                                    <div class="relative w-full h-16">
                                            <span
                                                class="absolute font-semibold z-50 p-2 dark:text-white">{{ \Str::limit(Auth::guard(activeGuard())->user()?->fullName, 20) }}</span>
                                        <input type="text" name="answer" id="answer-input" maxlength="255"
                                               class="pr-8 absolute align-bottom placeholder:font-medium text-base placeholder-[#C9CCD4] text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-2 pt-9 pb-1 dark:bg-[#1E1E1E] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                               placeholder="{{__('system.write_something')}}..." required />
                                        <button title="Send" type="submit" class="absolute bottom-0 right-0 me-2 mb-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                 viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                 class="size-5">
                                                <path class="stroke-primary" stroke-linecap="round"
                                                      stroke-linejoin="round"
                                                      d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                                            </svg>
                                        </button>
                                        <p id="warning-message" class="text-red-500 text-sm mt-1 hidden">You have
                                            reached the character limit!</p>
                                    </div>
                                </div>

                            </form>
                        @endif

                    </div>
                </div>
            @endforeach

        </div>
        <div class="mt-6 reply-new">
            @if (Auth::guard(activeGuard())->check() || Auth::guard('admin')->check())
                <form id="contentForm" class="flex flex-col gap-2">
                    @csrf
                    <input type="text" value="{{ $content->id }}" name="qna_id" hidden>
                    <input type="text" value="{{ activeGuard() ?? 'admin' }}" name="system" hidden>
                    <input type="text" value="{{ $type ?? 'content' }}" name="type" hidden>
                    <div class="reply-content-child-container">
                        @if (isset(Auth::guard(activeGuard())->user()->profile_image))
                            <img class="w-12 h-12 me-5 rounded-full object-cover"
                                 src="{{ asset(Auth::guard(activeGuard())->user()->profile_image) }}">
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                 stroke-width="1.5" stroke="currentColor" class="size-12">
                                <path stroke-linecap="round" class="stroke-primary" stroke-linejoin="round"
                                      d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        @endif
                        <div class="relative w-full h-16">
                                <span
                                    class="absolute font-semibold z-50 p-2 dark:text-white">{{ \Str::limit(Auth::guard(activeGuard())->user()?->fullName, 20) }}</span>
                            <input type="text" name="answer"
                                   class="pr-8 absolute align-bottom placeholder:font-medium text-base placeholder-[#C9CCD4] text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-2 pt-9 pb-1 dark:bg-[#1E1E1E] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="{{__('system.write_something')}}..." required />
                            <button type="submit" class="absolute bottom-0 right-0 me-2 mb-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor" class="size-5">
                                    <path class="stroke-primary" stroke-linecap="round" stroke-linejoin="round"
                                          d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                                </svg>
                            </button>

                        </div>
                    </div>

                </form>
            @endif
        </div>
        @if (activeGuard() == '' && !Auth::guard('admin')->check())
            <p class="text-sm italic mt-3 dark:text-white text-right">You must login to comment</p>
        @endif
    </div>
</div>

<script src="{{ asset('js/datepicker.min.js') }}" type="module"></script>
<script src="{{ asset('js/ckeditor.js') }}" type="module"></script>
{{--<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>--}}
{{--<script src="https://unpkg.com/create-file-list"></script>--}}

<script>
    $(document).on('click', '.btn-readmore', function() {
        let answer = $(this).data('answer');
        let id = $(this).data('id');
        $("#article-answer-" + id).html(answer);
        $(this).addClass('hidden');
        $('.btn-showless[data-id="' + id + '"]').removeClass('hidden');
    });

    $(document).on('click', '.btn-showless', function() {
        let id = $(this).data('id');
        let summary = $(this).data('summary');
        $("#article-answer-" + id).html(summary + '...');
        $(this).addClass('hidden');
        $('.btn-readmore[data-id="' + id + '"]').removeClass('hidden');
    });

    $(document).on('click', '.dropdown-toggle', function() {
        let dropdownId = $(this).data('dropdown-target');
        let dropdownMenu = $('#' + dropdownId);

        $('.dropdown-menu').not(dropdownMenu).addClass('hidden');

        dropdownMenu.toggleClass('hidden');
    });

    $(document).click(function(event) {
        if (!$(event.target).closest('.dropdown-toggle, .dropdown-menu').length) {
            $('.dropdown-menu').addClass('hidden');
        }
    });



    function closeDropdown() {
        document.getElementById('action-dropdown-menu').classList.add('hidden');
    }

    function trimSpaces(input) {
        input.value = input.value.replace(/^\s+/, '');
    }
</script>

<script>
    $(document).on("submit", "#contentForm", function(event) {
        event.preventDefault();
        let form = this;
        submitForm(form);
    });

    $(document).on("submit", "#contentFormParent", function(event) {
        event.preventDefault();
        let form = this;
        submitForm(form);
    });



    {{--function submitForm(form) {--}}
    {{--    if (typeof toggleLoadingOverlay === 'function') {--}}
    {{--        toggleLoadingOverlay();--}}
    {{--    } else {--}}
    {{--        console.error('toggleLoadingOverlay is not defined');--}}
    {{--    }--}}
    {{--    let formData = new FormData(form);--}}

    {{--    $.ajax({--}}
    {{--        url: '{{ route('informations.contents.content-comments.create', ['qNA' => $content]) }}',--}}
    {{--        method: 'POST',--}}
    {{--        data: formData,--}}
    {{--        contentType: false,--}}
    {{--        processData: false,--}}
    {{--        success: function(response) {--}}
    {{--            if (response.status === 'success') {--}}
    {{--                $(form).remove();--}}
    {{--                if (response.data.parent_id) {--}}
    {{--                    appendChildReply(response.data);--}}
    {{--                    addNewChildrenForm(response.data);--}}
    {{--                } else {--}}
    {{--                    appendReply(response.data);--}}
    {{--                    addNewForm(response.data.qna_id);--}}
    {{--                }--}}
    {{--            } else {--}}
    {{--                console.error('Error:', response.message);--}}
    {{--            }--}}
    {{--        },--}}
    {{--        error: function(xhr, status, error) {--}}
    {{--            console.error('AJAX Error:', error);--}}
    {{--        },--}}
    {{--        complete: function(response) {--}}
    {{--            if (typeof toggleLoadingOverlay === 'function') {--}}
    {{--                toggleLoadingOverlay();--}}
    {{--            }--}}
    {{--        }--}}

    {{--    });--}}
    {{--}--}}
    function submitForm(form) {
        // Lấy nút submit trong form
        let submitButton = $(form).find('button[type="submit"]');

        // Vô hiệu hóa nút submit để ngăn nhiều lần nhấn
        submitButton.prop('disabled', true);

        if (typeof toggleLoadingOverlay === 'function') {
            toggleLoadingOverlay();
        } else {
            console.error('toggleLoadingOverlay is not defined');
        }

        let formData = new FormData(form);

        $.ajax({
            url: '{{ route('informations.contents.content-comments.create', ['qNA' => $content]) }}',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.status === 'success') {
                    $(form).remove();
                    if (response.data.parent_id) {
                        appendChildReply(response.data);
                        addNewChildrenForm(response.data);
                    } else {
                        appendReply(response.data);
                        addNewForm(response.data.qna_id);
                    }
                } else {
                    console.error('Error:', response.message);
                    // Kích hoạt lại nút submit nếu có lỗi
                    submitButton.prop('disabled', false);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
                // Kích hoạt lại nút submit nếu có lỗi
                submitButton.prop('disabled', false);
            },
            complete: function(response) {
                if (typeof toggleLoadingOverlay === 'function') {
                    toggleLoadingOverlay();
                }
                // Có thể bỏ comment dòng dưới nếu muốn kích hoạt lại khi hoàn tất
                // submitButton.prop('disabled', false);
            }
        });
    }

    function addNewForm(qnaId) {
        let newForm = `
            @if (Auth::guard(activeGuard())->check() || Auth::guard('admin')->check())
        <form id="contentForm" class="flex flex-col gap-2">
@csrf
        <input type="text" value=${qnaId} name="qna_id" hidden>
                    <input type="text" value="{{ activeGuard() ?? 'admin' }}" name="system" hidden>
                    <input type="text" value="{{ $type ?? 'content' }}" name="type" hidden>
                    <div class="reply-content-child-container">
                    @if (isset(Auth::guard(activeGuard())->user()->profile_image))
        <img class="w-12 h-12 me-2 rounded-full object-cover"
            src="{{ asset(Auth::guard(activeGuard())->user()->profile_image) }}">
                    @else
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke-width="1.5" stroke="currentColor" class="size-12">
            <path stroke-linecap="round" class="stroke-primary" stroke-linejoin="round"
                d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
        </svg>
@endif
        <div class="relative w-full h-16">
            <span class="absolute font-semibold z-50 p-2 dark:text-white">{{ Str::limit(Auth::guard(activeGuard())->user()?->fullName, 20) }}</span>
                        <input type="text" name="answer" class="pr-8 absolute align-bottom placeholder:font-medium text-base placeholder-[#C9CCD4] text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-2 pt-9 pb-1 dark:bg-[#1E1E1E] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="{{__('system.write_something')}}..." required>
                        <button type="submit" class="absolute bottom-0 right-0 me-2 mb-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                <path class="stroke-primary" stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5"/>
                            </svg>
                        </button>
                    </div>
                </form>
            @endif
        `;

        // Thêm form mới vào DOM
        $(".reply-new").append(newForm);
    }

    function addNewChildrenForm(data) {
        let html = `
            @if (Auth::guard(activeGuard())->check() || Auth::guard('admin')->check())
        <form id="contentFormParent" class="flex flex-col gap-2">
@csrf
        <input type="text" value="${data.qna_id}" name="qna_id" hidden>
            <input type="text" value="{{ $type ?? 'content' }}" name="type" hidden>
            <input type="text" value="${data.parent_id}" name="parent_id" hidden>
                    <input type="text" value="{{$type ?? 'content'}}" name="type" hidden>
                    <input type="text" value="{{ activeGuard() ?? 'admin' }}" name="system" hidden>
                    <div class="reply-content-child-container">
                        @if (isset(Auth::guard(activeGuard())->user()->profile_image))
        <img class="w-8 h-8 me-2 rounded-full object-cover"
            src="{{ asset(Auth::guard(activeGuard())->user()->profile_image) }}">
                        @else
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke-width="1.5" stroke="currentColor" class="size-12">
            <path stroke-linecap="round" class="stroke-primary"
                stroke-linejoin="round"
                d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
        </svg>
@endif
        <div class="relative w-full h-16">
            <span
                class="absolute font-semibold z-50 p-2 dark:text-white">{{ \Str::limit(Auth::guard(activeGuard())->user()?->fullName, 20) }}</span>
                            <input type="text" name="answer"
                                class="pr-8 absolute align-bottom placeholder:font-medium text-base placeholder-[#C9CCD4] text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-2 pt-9 pb-1 dark:bg-[#1E1E1E] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="{{__('system.write_something')}}..." required />
                            <button type="submit" class="absolute bottom-0 right-0 me-2 mb-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                    class="size-5">
                                    <path class="stroke-primary" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                                </svg>
                            </button>
                        </div>
                    </div>

                </form>
            @endif
        `;
        $(`#reply-child-container-${data.parent_id}`).append(html);
    }

    function appendReply(data) {
        let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let replyHtml = `
            <div class="flex gap-3 flex-col reply-remove-${data.id}">
            <div class="reply-item-container">
                <div class="reply-item">
                    ${data.author.profile_image !== null ? `
                                <img class="w-12 h-12 me-2 rounded-full object-cover" src="${data.author.profile_image}" alt="${data.author.fullName}">
                            ` : `
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-12">
                                    <path stroke-linecap="round" class="stroke-primary" stroke-linejoin="round"
                                        d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>`}
                    <div class="flex flex-col w-full pr-2">
                        <div class="flex justify-between font-semibold text-base items-center">
                            <p class="dark:text-white">${data.author.fullName}</p>
                            ${data.canEdit ? `
                                    <div class="relative inline-block text-left">
                                        <button type="button" class="dropdown-toggle inline-flex items-center font-semibold justify-center text-primary cursor-pointer bg-white dark:bg-[#1E1E1E] dark:text-white hover:rounded-lg"
                                            data-dropdown-target="action-dropdown-menu-${data.id}">
                                            <div>
                                                <p class="text-xl tracking-wider font-semibold text-gray-700 dark:text-white heading-6">...</p>
                                            </div>
                                        </button>

                                        <div class="dropdown-menu absolute w-fit z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-xl border shadow-lg  dark:bg-[#1E1E1E]"
                                            id="action-dropdown-menu-${data.id}">
                                            <ul class="font-medium" role="none">
                                                <li>
                                                    <form
                                                        class="delete-reply-form" data-id="${data.id}" data-element=".reply-remove-${data.id}"
                                                        action="/informations/contents/deletecommentreply/${data.id}"
                                                        method="post">
                                                        <input class="hidden" name="_token" value="${csrfToken}" />
                                                        <input class="hidden" name="_method" value="DELETE" />
                                                        <button type="submit"
                                                            class="w-full block px-6 py-2 text-sm text-gray-900 hover:bg-primary hover:text-white dark:text-gray-400 dark:hover:bg-[#383838] dark:hover:text-white hover:rounded-xl"
                                                            role="menuitem">
                                                            <div class="inline-flex items-center">
                                                                {{ trans('system.form.button.delete') }}
        </div>

    </button>
</form>

</li>

</ul>
</div>
</div>
` : ''}
                        </div>
                        <div class="w-fit mr-3">
                            <p id="article-answer-${data.id}" class="w-fit font-medium text-[#706F81] text-base whitespace-normal mr-3 dark:text-white"
                            style="word-break: break-word; overflow-wrap: break-word;">
                                ${data.answer.length > 150 ? data.answer.substring(0, 150) + '...' : data.answer}
                            </p>
                            ${data.answer.length > 150 ? `
                                    <button class="btn btn-primary btn-readmore text-sm text-primary underline"
                                        data-id="${data.id}" data-answer="${data.answer}">
                                        Read more
                                    </button>
                                    <button class="btn btn-primary btn-showless hidden text-sm text-primary underline"
                                        data-id="${data.id}" data-summary="${data.answer.substring(0, 150)}" data-answer="${data.answer}">
                                        Show less
                                    </button>
                                ` : ''}
                        </div>
                    </div>
                </div>
                <div class="flex justify-between px-5">
                    <p class="font-medium text-xs text-[#91919A]">${data.created_at}</p>
                </div>
            </div>
            <div class=" reply-child-container-style" id="reply-child-container-${data.id}">
                @if (Auth::guard(activeGuard())->check() || Auth::guard('admin')->check())
        <form id="contentFormParent" class="flex flex-col gap-2">
@csrf
        <input type="text" value="${data.qna_id}" name="qna_id" hidden>
            <input type="text" value="${data.type}" name="type" hidden>
            <input type="text" value="${data.id}" name="parent_id" hidden>
                        <input type="text" value="{{ activeGuard() ?? 'admin' }}" name="system" hidden>
                        <div class="reply-content-child-container">
                            @if (isset(Auth::guard(activeGuard())->user()->profile_image))
        <img class="w-8 h-8 me-2 rounded-full object-cover"
            src="{{ asset(Auth::guard(activeGuard())->user()->profile_image) }}">
                            @else
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke-width="1.5" stroke="currentColor" class="size-12">
            <path stroke-linecap="round" class="stroke-primary"
                stroke-linejoin="round"
                d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
        </svg>
@endif
        <div class="relative w-full h-16">
            <span
                class="absolute font-semibold z-50 p-2 dark:text-white">{{ \Str::limit(Auth::guard(activeGuard())->user()?->fullName, 20) }}</span>
                                <input type="text" name="answer"
                                    class="pr-8 absolute align-bottom placeholder:font-medium text-base placeholder-[#C9CCD4] text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-2 pt-9 pb-1 dark:bg-[#1E1E1E] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Write something..." required />
                                <button type="submit" class="absolute bottom-0 right-0 me-2 mb-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                        class="size-5">
                                        <path class="stroke-primary" stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                                    </svg>
                                </button>

                            </div>
                        </div>

                    </form>
                @endif

        </div>
        </div>
`;

        $(".reply-container-append").append(replyHtml);
    }

    // Similar logic for appendChildReply


    function appendChildReply(data) {
        let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let html = `
            <div class="reply-item reply-item-${data.id}">
                ${data.author.profile_image ? `
                            <img class="w-8 h-8 me-2 rounded-full object-cover" src="${data.author.profile_image}" alt="${data.author.fullName}">
                        ` : `
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-10">
                                <path stroke-linecap="round" class="stroke-primary" stroke-linejoin="round"
                                    d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        `}

                <div class="w-full flex flex-col pr-2">
                    <div class="flex justify-between font-semibold text-base dark:text-white">
                        ${data.author.fullName ? `<p class="dark:text-white">${data.author.fullName}</p>` : 'Admin'}
                        ${data.canEdit ? `
                                <div class="relative inline-block text-left">
                                    <button type="button" class="dropdown-toggle inline-flex items-center font-semibold justify-center text-primary cursor-pointer bg-white dark:bg-[#1E1E1E] dark:text-white hover:rounded-lg"
                                        data-dropdown-target="action-dropdown-menu-${data.id}">
                                        <div>
                                            <p class="text-xl tracking-wider font-semibold text-gray-700 dark:text-white heading-6">...</p>
                                        </div>
                                    </button>


                                    <div class="dropdown-menu absolute w-fit z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-xl border shadow-lg  dark:bg-[#1E1E1E]"
                                        id="action-dropdown-menu-${data.id}">
                                        <ul class="font-medium" role="none">
                                            <li>
                                                <form
                                                    class="delete-reply-form" data-id="${data.id}" data-element=".reply-item-${data.id}"
                                                    action="/informations/contents/deletecommentreply/${data.id}"
                                                    method="post">
                                                    <input class="hidden" name="_token" value="${csrfToken}" />
                                                    <input class="hidden" name="_method" value="DELETE" />
                                                    <button type="submit"
                                                        class="w-full block px-6 py-2 text-sm text-gray-900 hover:bg-primary hover:text-white dark:text-gray-400 dark:hover:bg-[#383838] dark:hover:text-white hover:rounded-xl"
                                                        role="menuitem">
                                                        <div class="inline-flex items-center">
                                                            {{ trans('system.form.button.delete') }}
        </div>

    </button>
</form>

</li>

</ul>
</div>
</div>
` : ''}
                    </div>

                    <div class="">
                        <p id="article-answer-${data.id}" class="w-fit font-medium text-[#706F81] text-base whitespace-normal mr-3 dark:text-white"
                        style="word-break: break-word; overflow-wrap: break-word;">
                            ${data.answer.length > 150 ? data.answer.substring(0, 150) + '...' : data.answer}
                        </p>

                        ${data.answer.length > 150 ? `
                                    <button class="btn btn-primary btn-readmore text-sm text-primary underline"
                                        data-id="${data.id}" data-answer="${data.answer}">
                                        Read more
                                    </button>
                                ` : ''}

                        <button class="btn btn-primary btn-showless hidden text-sm text-primary underline"
                            data-id="${data.id}" data-summary="${data.answer.substring(0, 150)}" data-answer="${data.answer}">
                            Show less
                        </button>
                    </div>


                    <p class="font-medium text-xs text-[#91919A]">${data.created_at}</p>
                </div>
            </div>`;

        $(`#reply-child-container-${data.parent_id}`).append(html);
    }
</script>

<script type="module">
    $(document).ready(function() {
        function toggleSubmitButton() {
            var titleValue = $('#title').val();
            var descriptionValue = $('#description').val();
            var anyFieldEmptyOrNull = !titleValue || !descriptionValue;
            if (anyFieldEmptyOrNull) {
                $('#submit-all').addClass('disabled-button');
                $('#submit-all').prop('disabled', true);
            } else {
                $('#submit-all').removeClass('disabled-button');
                $('#submit-all').prop('disabled', false);
            }
        }
        toggleSubmitButton();

        $('input, select, textarea').on('input change', function() {
            toggleSubmitButton();
        });

    });
</script>
<script>
    //Function handle upload attachment
    function dataFileDnD() {
        return {
            files: [],
            fileDragging: null,
            fileDropping: null,
            humanFileSize(size) {
                const i = Math.floor(Math.log(size) / Math.log(1024));
                return (
                    (size / Math.pow(1024, i)).toFixed(2) * 1 +
                    " " + ["B", "kB", "MB", "GB", "TB"][i]
                );
            },
            remove() {
                this.files = [];
            },
            drop(e) {
                // Since we only allow one file, dropping functionality is not needed
                e.preventDefault();
            },
            dragenter(e) {
                e.preventDefault();
            },
            dragstart(e) {
                // Dragging functionality is not needed since we only allow one file
            },
            loadFile(file) {
                const preview = document.querySelectorAll(".preview");
                const blobUrl = URL.createObjectURL(file);

                preview.forEach(elem => {
                    elem.onload = () => {
                        URL.revokeObjectURL(elem.src); // free memory
                    };
                });

                return blobUrl;
            },
            addFiles(e) {
                this.files = [];

                const allowedTypes = [
                    'image/png',
                    'image/jpg',
                    'image/jpeg',
                    'application/msword',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'application/pdf'
                ];

                // Convert FileList to Array
                const fileList = Array.from(e.target.files);

                // Filter files that are allowed
                const validFiles = fileList.filter(file => allowedTypes.includes(file.type));

                // Show error message if any files are not allowed
                if (validFiles.length !== fileList.length) {
                    Toastify({
                        text: "Only DOC, DOCX, IMAGES, and PDF files are allowed.",
                        className: "info",
                        style: {
                            background: "linear-gradient(to right, #00b09b, #96c93d)",
                        }
                    }).showToast();
                }

                // Append valid files to this.files
                this.files = createFileList([...this.files, ...validFiles]);

                // Update the form data with the selected files
                this.form.formData.files = this.files;
            }
        };
    }

    function createFileList(files) {
        const dataTransfer = new DataTransfer();
        files.forEach(file => dataTransfer.items.add(file));
        return dataTransfer.files;
    }
</script>

<script>
    $(document).ready(function() {

        $(document).on('submit', '.delete-reply-form', function(event) {
            event.preventDefault();
            if (typeof toggleLoadingOverlay === 'function') {
                toggleLoadingOverlay();
            } else {
                console.error('toggleLoadingOverlay is not defined');
            }


            var form = $(this);
            var replyId = form.data('id');
            var element = form.data('element')
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: {
                    _token: csrfToken,
                    _method: 'DELETE'
                },
                success: function(response) {
                    if (response.success) {
                        form.closest(element).remove();
                    } else {
                        console.error('Error:', response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                },
                complete: function(response) {
                    if (typeof toggleLoadingOverlay === 'function') {
                        toggleLoadingOverlay();
                    }
                }
            });
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('answer-input');
        const warningMessage = document.getElementById('warning-message');
        const maxChars = 255;

        input.addEventListener('input', function() {
            if (input.value.length > maxChars) {
                input.value = input.value.slice(0, maxChars);
                warningMessage.classList.remove('hidden');
            } else {
                warningMessage.classList.add('hidden');
            }
        });
    });
</script>
