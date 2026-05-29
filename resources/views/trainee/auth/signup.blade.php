@extends('auth.layouts.master')

@section('title', 'Sign Up')
<link href="{{ asset('css/select2/select2.css') }}" rel="stylesheet" />
<link href="{{ asset('css/filepond/filepond.css') }}" rel="stylesheet" />
@push('css')
    <style>
        .disabled-button {
            pointer-events: none;
            background-color: gray;
        }
        .select2-container--default .select2-selection--single {
            @apply  dark:bg-[#1E1E1E] rounded-lg border border-gray-300 text-sm h-10 flex items-center;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            @apply px-3 py-2 text-gray-700;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            @apply h-full right-2;
        }
    </style>
@endpush


@section('content')
    <div class="max-w-2xl mx-auto w-full leading-9 py-24 px-7 flex h-auto mb-10 items-start">
        <div
            class="bg-white dark:bg-[#1E1E1E] shadow-md  space-y-6 border-gray-200 rounded-lg px-10 py-5 ">
            <div class="flex flex-col gap-6">
                <a href="/choose-login"
                    class="text-gray-900 dark:text-white border-gray-200 font-medium gap-2 rounded-lg text-xl font-semibold w-fit text-center inline-flex items-center hover:text-primary dark:hover:text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                    </svg>
                    {{ trans('auth.choose_login_title') }}
                </a>

                <a href="/" class="flex items-center rtl:space-x-reverse w-fit">
                    <img src="{{asset('/images/careerone-logo.png')}}" class="h-8 md:h-12 block dark:hidden" alt="Careerone Logo" />
                    <img src="{{asset('/images/careerone-logo-dark.png')}}" class="h-8 md:h-12 hidden dark:block" alt="Careerone Logo" />
                </a>
                @if (session()->get('message'))
                    <div class="bg-green-100 text-green-800 text-base font-medium px-4 py-3 rounded dark:bg-[#1E1E1E] dark:text-green-400 border border-green-400">
                        {!! session()->get('message') !!}
                    </div>
                @endif
                @if (session()->get('error'))
                    <span
                        class="bg-green-100 text-green-800 text-base font-medium px-2.5 py-3 rounded dark:bg-[#1E1E1E] dark:text-green-400 border border-green-400">{!! session()->get('error') !!}</span>
                @endif

                <form class="space-y-6 leading-5" action="{{ route('trainee.auth.postRegister') }}" method="POST"
                    enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <div class="flex gap-2 flex-col">
                        <label for="nic" class=" font-medium text-gray-600 block dark:text-gray-300">
                            {{ trans('system.form.nic') }}</label>
                        @if (old('nic') != '' && !$errors->has('nic'))
                            <div class="flex flex-col">
                                <div class="flex gap-4 items-center">
                                    <input type="text" name="nic" id="nic"
                                        class="w-full p-3 pl-4 h-9  border border-gray-300 text-[#91919A] sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white"
                                        value="{{ old('nic') }}" placeholder="XXXX XXXX XXXX" readonly required maxlength="10">
                                </div>
                                @error('nic_check_fail')
                                    <span class="text-sm text-red-600 hidden">{{ $message }}</span>
                                @enderror
                                @if ($errors->has('nic'))
                                    <span class="help-block">
                                        <span class="text-sm text-red-600">{{ $errors->first('nic') }}</span>
                                    </span>
                                @endif
                                <small class="dark:text-white text-xs"><i>{{ trans('system.form.nic_hint') }}</i></small>
                            </div>
                        @else
                            <div class="flex flex-col">
                                <div class="flex gap-4 items-center">
                                    <input type="text" name="nic" id="nic"
                                        class="w-full p-3 pl-4 h-9  border border-gray-300 text-[#91919A] sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white"
                                        value="" placeholder="XXXX XXXX XXXX">
                                    <button type="button"
                                        class="btn-check-nic text-white w-3/12 bg-[#4984F6] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-full
                                 px-2 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800  font-medium flex justify-center items-center">{{ trans('system.form.button.check') }}
                                    </button>
                                    <button disabled type="button"
                                        class="hidden checking-btn text-white text-white  w-3/12 bg-[#4984F6] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-full
                                 px-6 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 font-medium flex justify-center items-center">
                                        <svg aria-hidden="true" role="status"
                                            class="inline w-5 h-5 text-white animate-spin" viewBox="0 0 100 101"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                                fill="#E5E7EB" />
                                            <path
                                                d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                                fill="currentColor" />
                                        </svg>
                                    </button>
                                    <button type="button"
                                        class="btn-reset-nic text-white w-3/12 bg-[#4984F6] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-full
                                         px-2 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800  font-medium flex justify-center items-center hidden">{{ trans('system.form.button.reset') }}
                                    </button>
                                </div>
                                @error('nic_check_fail')
                                    <span class="text-sm text-red-600 hidden">{{ $message }}</span>
                                @enderror
                                @if ($errors->has('nic'))
                                    <span class="help-block">
                                        <span class="text-sm text-red-600">{{ $errors->first('nic') }}</span>
                                    </span>
                                @endif
                                <small class="dark:text-white text-xs"><i>{{ trans('system.form.nic_hint') }}</i></small>
                            </div>
                        @endif
                    </div>

                    <div>
                        <label for="full_name"
                            class="text-sm font-medium text-gray-600 block mb-1.5 dark:text-gray-300">{{ trans('system.form.full_name') }}<span
                                class="text-red-600 p-1 text-center">*</span>
                        </label>
                        <input type="text" name="full_name" id="full_name" value="{{ old('full_name') }}"
                            class=" border p-3 pl-4 h-9 border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-none block w-full  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white cursor-not-allowed"
                            readonly>
                        @if ($errors->has('full_name'))
                            <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('full_name') }}</span>
                        @endif
                    </div>
                    <div>
                        <label for="email"
                            class="text-sm font-medium text-gray-600 block mb-1.5 dark:text-gray-300">{{ trans('system.form.email') }}<span
                                class="text-red-600 p-1 text-center">*</span>
                        </label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                            placeholder="You@email.com"
                            class=" border p-3 pl-4 h-9 border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white">
                        @if ($errors->has('email'))
                            <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('email') }}</span>
                        @endif
                        <span id="email-error" class="text-red-600 text-xs p-0 m-0"></span>
                    </div>

                    <div>
                        <label for="password"
                            class="text-sm font-medium text-gray-600 block mb-1.5 dark:text-gray-300">{{ trans('system.form.password') }}<span
                                class="text-red-600 p-1 text-center">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" name="password" id="password" placeholder="********"
                                class=" border p-3 pl-4 h-9 border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white">
                            <span class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer dark:text-white"
                                id="toggle-password">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5" id="eye-icon-show">
                                    <path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"></path>
                                    <path fill-rule="evenodd"
                                        d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5 hidden" id="eye-icon-hide">
                                    <path fill-rule="evenodd"
                                        d="M3.28 2.22a.75.75 0 0 0-1.06 1.06l14.5 14.5a.75.75 0 1 0 1.06-1.06l-1.745-1.745a10.029 10.029 0 0 0 3.3-4.38 1.651 1.651 0 0 0 0-1.185A10.004 10.004 0 0 0 9.999 3a9.956 9.956 0 0 0-4.744 1.194L3.28 2.22ZM7.752 6.69l1.092 1.092a2.5 2.5 0 0 1 3.374 3.373l1.091 1.092a4 4 0 0 0-5.557-5.557Z"
                                        clip-rule="evenodd"></path>
                                    <path
                                        d="m10.748 13.93 2.523 2.523a9.987 9.987 0 0 1-3.27.547c-4.258 0-7.894-2.66-9.337-6.41a1.651 1.651 0 0 1 0-1.186A10.007 10.007 0 0 1 2.839 6.02L6.07 9.252a4 4 0 0 0 4.678 4.678Z">
                                    </path>
                                </svg>
                            </span>
                        </div>
                        <small class="text-xs p-0 m-0 dark:text-white" id="password-feedback"><i>{{ trans('auth.password_feeback') }}</i></small>
                        @if ($errors->has('password'))
                            <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('password') }}</span>
                        @endif
                    </div>

                    <div>
                        <label for="repassword"
                            class="text-sm font-medium text-gray-600 block mb-1.5 dark:text-gray-300">{{ trans('system.form.confirm_password') }}<span
                                class="text-red-600 p-1 text-center">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" name="repassword" id="repassword" placeholder="{{trans('Retype your password')}}"
                                class=" border p-3 pl-4 h-9 border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white">
                            <span class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer dark:text-white"
                                id="toggle-repassword">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5"
                                    id="eye-icon-show-repassword">
                                    <path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"></path>
                                    <path fill-rule="evenodd"
                                        d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5 hidden"
                                    id="eye-icon-hide-repassword">
                                    <path fill-rule="evenodd"
                                        d="M3.28 2.22a.75.75 0 0 0-1.06 1.06l14.5 14.5a.75.75 0 1 0 1.06-1.06l-1.745-1.745a10.029 10.029 0 0 0 3.3-4.38 1.651 1.651 0 0 0 0-1.185A10.004 10.004 0 0 0 9.999 3a9.956 9.956 0 0 0-4.744 1.194L3.28 2.22ZM7.752 6.69l1.092 1.092a2.5 2.5 0 0 1 3.374 3.373l1.091 1.092a4 4 0 0 0-5.557-5.557Z"
                                        clip-rule="evenodd"></path>
                                    <path
                                        d="m10.748 13.93 2.523 2.523a9.987 9.987 0 0 1-3.27.547c-4.258 0-7.894-2.66-9.337-6.41a1.651 1.651 0 0 1 0-1.186A10.007 10.007 0 0 1 2.839 6.02L6.07 9.252a4 4 0 0 0 4.678 4.678Z">
                                    </path>
                                </svg>
                            </span>
                        </div>
                        <div id="repassword-feedback"></div>
                        @if ($errors->has('repassword'))
                            <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('repassword') }}</span>
                        @endif
                    </div>

{{--                    <div>--}}
{{--                        <label for="telephone"--}}
{{--                            class="text-sm font-medium text-gray-600 block mb-1.5 dark:text-gray-300">{{ trans('system.form.telephone') }}--}}
{{--                        </label>--}}
{{--                        <input type="text" name="telephone" id="telephone" value="{{ old('telephone') }}"--}}
{{--                             placeholder="Eg: 0129 084 713"--}}
{{--                            class=" border p-3 pl-4 h-9 border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white">--}}
{{--                        @if ($errors->has('telephone'))--}}
{{--                            <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('telephone') }}</span>--}}
{{--                        @endif--}}
{{--                    </div>--}}
                    <div>
                        <label for="mobile"
                            class="text-sm font-medium text-gray-600 block mb-1.5 dark:text-gray-300">{{ trans('system.form.mobile') }}<span
                                class="text-red-600 p-1 text-center">*</span>
                        </label>
                        <input type="text" name="mobile" id="mobile" value="{{ old('mobile') }}"
                            placeholder="Eg: 075 555 5555"
                            class=" border p-3 pl-4 h-9 border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white">
                        @if ($errors->has('mobile'))
                            <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('mobile') }}</span>
                        @endif
                    </div>
                    <div>
                        <label for="recommended_by"
                               class="text-sm font-medium text-gray-600 block mb-1.5 dark:text-gray-300">{{ trans('general.Recommended by') }}
                        </label>

                        <select class="select2 recommended_by mb-0 rounded-lg " id="recommended_by" name="recommended_by" style="width: 100%"
                                data-placeholder="{{trans('auth.Please select one')}}">
                            <option></option>
                            @forelse($recommendedList as $user)
                                <option value="{{$user->system}}-{{ $user->id }}">
                                    {{ strtoupper($user->system) }} - {{$user->fullName}} - @if($user->system == 'cgo'){{ $user->institute?->name. "(". $user->institute?->reg_no . ")"}} @else {{ $user->tvetType?->head_office_code}} @endif</option>
                            @empty
                            @endforelse
                        </select>
                        @if ($errors->has('recommended_by'))
                            <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('recommended_by') }}</span>
                        @endif
                    </div>
                    <div>
                        <label for="verify_method"
                            class="text-sm font-medium text-gray-600 block mb-1.5 dark:text-gray-300">{{ trans('system.form.preferred_verification_method') }}<span
                                class="text-red-600 p-1 text-center">*</span>
                        </label>
                        <div class="flex gap-6">
                            @foreach(getCodeList('verification_method') as $item)
                                <div class="flex items-center justify-center">
                                    <input type="radio" name="verification_type"
                                           value="{{ strtolower(str_replace('-', '', $item->code_name)) }}"
                                           class="rounded-full shrink-0 border-gray-500 text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800"
                                           id="hs-radio-group-{{$item->code_id}}"
                                           {{ old('verification_type') == strtolower(str_replace('-', '', $item->code_name)) ? 'checked' : '' }}>
                                    <label for="hs-radio-group-{{$item->code_id}}"
                                           class="text-sm text-gray-500 ms-3 dark:text-neutral-400">{{$item->code_name}}</label>
                                </div>
                            @endforeach
                        </div>



                        @if ($errors->has('verification_type'))
                            <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('verification_type') }}</span>
                        @endif
                    </div>


                    <div class="flex items-center">
                        <input id="agree_terms" name="agree_terms" type="checkbox"
                            value="1" {{ old('agree_terms') == '1' ? 'checked' : '' }}
                            class="h-4 w-4 shrink-0 text-blue-600 focus:ring-blue-500 border-gray-500 rounded" />
                        <label for="agree_terms" class="pl-3 block text-sm text-gray-500">
                            {!! trans('system.form.accept_term_message', ['file' => asset('files/T&C for Trainee 2.pdf') ]) !!}
                        </label>
                    </div>
                    @if ($errors->has('agree_terms'))
                        <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('agree_terms') }}</span>
                    @endif


                    <button type="submit" id="signup-button" disabled
                        class="w-full text-white bg-[#4984F6] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-full
                        text-xl px-5 py-3 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">{{ trans('auth.sign_up') }}
                    </button>
                    <div class="text-sm dark:text-white mt-2">
                        {{trans('general.signup_note')}}
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="default-modal" tabindex="-1" aria-hidden="true"
         class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-[#1E1E1E] dark:border-white">
                <!-- Modal header -->
                <div class="flex items-center justify-between pb-4 border-b rounded-t p-4">
                    <h3 class="text-xl font-semibold dark:text-white text-center">
                        Message
                    </h3>
                    <button type="button"
                            class="close-modal text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="default-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                  stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="flex flex-col gap-4 p-6 modal-body">
{{--                    <svg class="mt-6 mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true"--}}
{{--                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">--}}
{{--                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"--}}
{{--                              d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />--}}
{{--                    </svg>--}}
                    <h3 class="mb-5 text-lg font-normal dark:text-white text-center">
                        {{trans('general.There is no NVQ information with the NIC you entered!')}}
                        <br>
                        <span class="text-base">
                            {!! trans('general.Please click here to proceed for account registration.') !!}
                        </span>
                    </h3>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('js/select2.js') }}" type="module"></script>
    @if (old('nic') != '' && !$errors->has('nic'))
        <script>
            window.nic_confirmed = true; // Set nic_confirmed directly
        </script>
    @endif

    <script type="module">
        $(document).ready(function () {
            // Set up modal
            const options = {
                onHide: () => {
                    if (timeoutId) { // When modal is hidden, clear timeout to prevent auto update read
                        clearTimeout(timeoutId);
                        timeoutId = null;
                    }
                },
            };
            window.modal = createModal('default-modal', options);

            function createModal($id, options = null) {
                const $targetEl = document.getElementById($id);

                // instance options object
                const instanceOptions = {
                    id: $id,
                    override: true
                };

                /*
                 * $targetEl: required
                 * options: optional
                 */
                return new Modal($targetEl, options, instanceOptions);
            }

            $('#nic').on('input', function () {
                // const maxLength = 12;
                // let value = $(this).val();
                //
                // if (value.length > maxLength) {
                //     $(this).val(value.substring(0, maxLength));
                // }
                let value = $(this).val().toUpperCase();

                // Remove invalid characters (only digits and V/X allowed)
                value = value.replace(/[^0-9VX]/g, '');

                // Limit max length to 12 (new NIC max)
                value = value.substring(0, 12);

                // Set value back to field
                $(this).val(value);

                // Validation patterns
                const isValidOld = /^\d{9}[VX]$/i.test(value); // e.g., 123456789V
                const isValidNew = /^\d{12}$/.test(value);      // e.g., 200012345678

                if (!isValidOld && !isValidNew) {
                    $(this).addClass('border-red-500');
                } else {
                    $(this).removeClass('border-red-500');
                }
            });
        });
        $(document).ready(function() {
            $('input[name="verification_type"]').on('change', function() {
                // If this checkbox is checked, uncheck the others
                if ($(this).is(':checked')) {
                    $('input[name="verification_type"]').not(this).prop('checked', false);
                }

                // Call the toggle function to check the button state
                toggleSignUpButton();
            });
            // Initialize Select2
            $('.select2').select2({
                placeholder: "{{trans('auth.Please select one')}}"
            });

            // Validate Telephone Input
            $('input[name="telephone"]').on('input', function() {
                validateTelephoneInput(this);
            });
             // Validate Telephone Input
             $('input[name="mobile"]').on('input', function() {
                validateMobileInput(this);
            });

            // Toggle visibility of password fields
            $('#toggle-password').on('click', function() {
                togglePasswordVisibility('#password', '#eye-icon-show', '#eye-icon-hide');
            });

            $('#toggle-repassword').on('click', function() {
                togglePasswordVisibility('#repassword', '#eye-icon-show-repassword',
                    '#eye-icon-hide-repassword');
            });

            // Handle NIC input change
            $("input[name='nic']").on('input', function() {
                handleNICInput();
            });

            // Check NIC validity
            $(".btn-check-nic").on('click', function(e) {
                checkNIC(e);
            });

            // Reset NIC input
            $(".btn-reset-nic").on('click', function() {
                resetNICInput();
            });

            // Toggle the sign-up button based on form completion
            $('input, select').on('input change', function() {
                toggleSignUpButton();
            });

            // Initialize the toggle for the sign-up button
            toggleSignUpButton();

            // Helper Functions
            function togglePasswordVisibility(passwordSelector, showIconSelector, hideIconSelector) {
                const passwordInput = $(passwordSelector);
                const showIcon = $(showIconSelector);
                const hideIcon = $(hideIconSelector);

                if (passwordInput.attr('type') === 'password') {
                    passwordInput.attr('type', 'text');
                    showIcon.addClass('hidden');
                    hideIcon.removeClass('hidden');
                } else {
                    passwordInput.attr('type', 'password');
                    showIcon.removeClass('hidden');
                    hideIcon.addClass('hidden');
                }
            }

            function handleNICInput() {
                const nicInput = $("input[name='nic']");
                const nic = nicInput.val();
                const btnCheckNIC = $(".btn-check-nic");

                nicInput.removeClass(
                    'bg-red-50 border-red-500 text-red-900 bg-green-50 border-green-500 text-green-900 dark:text-green-400'
                    );

                if (nic !== '') {
                    btnCheckNIC.prop('disabled', false).removeClass('cursor-not-allowed');
                } else {
                    btnCheckNIC.prop('disabled', true).addClass('cursor-not-allowed');
                    $(".checking-btn").addClass('hidden');
                }
            }

            function checkNIC(e) {
                const nic = $("input[name='nic']").val().trim();
                const oldNICRegex = /^[0-9]{9}[vVxX]$/;
                const newNICRegex = /^[0-9]{12}$/;
                if (!nic) {
                    showToast('NIC field is empty!', 'error', '#e74c3c');
                    e.preventDefault();
                    return;
                }
                if (!oldNICRegex.test(nic) && !newNICRegex.test(nic)) {
                    showToast('Invalid NIC format! Please enter a valid NIC.', 'error', '#e74c3c');
                    e.preventDefault();
                    return;
                }

                $(".btn-check-nic").addClass('hidden');
                $(".checking-btn").removeClass('hidden');

                $.ajax({
                    url: "{{ route('trainee.auth.checkNIC') }}",
                    type: 'GET',
                    data: {
                        nic: nic
                    },
                    success: function(data) {
                        $(".checking-btn").addClass('hidden');
                        handleNICResponse(data);
                        toggleSignUpButton();
                    }
                });
            }

            function handleNICResponse(data) {
                const nicInput = $("input[name='nic']");
                if ($.isEmptyObject(data.error)) {
                    window.nic_confirmed = true;
                    $(".btn-reset-nic").removeClass('hidden');
                    $("#full_name").val(data.data[0]['STD_FULL_NAME']);
                    // $("#email").val(data.data[0]['STD_EMAIL']);
                    // $("#telephone").val(data.data[0]['STD_TELPHONE']);
                    // $("#mobile").val(data.data[0]['STD_MOBILE']);
                    showToast(data.success, 'infor', 'linear-gradient(to right, #00b09b, #96c93d)');
                    nicInput.prop('readonly', true).addClass(
                        'bg-green-50 border-green-500 text-green-900 dark:text-green-400');
                } else {
                    window.nic_confirmed = false;
                    nicInput.addClass('bg-red-50 border-red-500 text-red-900');
                    // showToast(data.error, 'error', '#e74c3c');
                    if(data.exists == '1') {
                        showToast(data.error, 'error', '#e74c3c');
                    }else{
                        window.modal.show();
                    }
                    $(".btn-check-nic").removeClass('hidden');

                }
            }

            function resetNICInput() {
                const nicInput = $("input[name='nic']");
                nicInput.val('').prop('readonly', false).removeClass(
                    'bg-red-50 border-red-500 text-red-900 bg-green-50 border-green-500 text-green-900 dark:text-green-400'
                    );
                $(".btn-reset-nic").addClass('hidden');
                $(".btn-check-nic").prop('disabled', true).addClass('cursor-not-allowed').removeClass('hidden');
                $("#full_name").val('');
                $("#email").val('');
                $("#password").val('');
                $("#repassword").val('');
                $("#telephone").val('');
                $("#mobile").val('');
                $("#accept_term").prop('checked', false);
                window.nic_confirmed = false;
                toggleSignUpButton();
            }

            function toggleSignUpButton() {
                const fields = ['#nic', '#full_name', '#email', '#password', '#repassword', '#mobile'];
                const agreeTermsChecked = $('#agree_terms').is(':checked');
                const verificationTypeChecked = $('input[name="verification_type"]:checked').length > 0;
                const allFieldsFilled = fields.every(selector => $(selector).val());
                const signupButton = $('#signup-button');

                if (!window.nic_confirmed || !allFieldsFilled || !agreeTermsChecked || !verificationTypeChecked) {
                    signupButton.addClass('disabled-button').prop('disabled', true);
                } else {
                    signupButton.removeClass('disabled-button').prop('disabled', false);
                }
            }

            function showToast(message, type, bgColor) {
                Toastify({
                    text: message,
                    duration: 2000,
                    className: type,
                    style: {
                        background: bgColor
                    }
                }).showToast();
            }
            function validateTelephoneInput(input) {
                let value = input.value;
                if (value.length >= 1 && value.charAt(0) !== "0") {
                    value = "";
                }
                value = value.replace(/\D/g, '');
                value = value.substring(0, 10);
                input.value = value;
            }
            // function validateMobileInput(input) {
            //     let value = input.value;
            //     if (value.length >= 1 && value.charAt(0) !== "0") {
            //         value = "";
            //     }
            //     value = value.replace(/\D/g, '');
            //     value = value.substring(0, 10);
            //     input.value = value;
            // }
            function validateMobileInput(input) {
                let value = input.value;

                // Cho phép "+" chỉ ở đầu và loại bỏ các ký tự không phải số
                if (value.startsWith('+')) {
                    value = '+' + value.substring(1).replace(/\D/g, '');
                } else {
                    value = value.replace(/\D/g, '');
                }

                // Kiểm tra xem có bắt đầu đúng không
                if (value.startsWith('+94')) {
                    value = value.substring(0, 12); // +94 + 9 chữ số
                } else if (value.startsWith('0')) {
                    value = value.substring(0, 10); // 0 + 9 chữ số
                } else {
                    // Không bắt đầu bằng +94 hoặc 0 => ngăn nhập
                    value = '';
                }

                input.value = value;
            }
        });
        $(document).ready(function() {
            $('#email').on('input', function() {
                const email = $(this).val();
                const errorSpan = $('#email-error');
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                if (email === '') {
                    errorSpan.text('Email cannot be blank.');
                } else if (!emailRegex.test(email)) {
                    errorSpan.text('Email is not in correct format.');
                } else {
                    errorSpan.text('');
                }
            });
        });
        const validationRules = [
    {
        test: (value) => value.length >= 8 && value.length <= 16,
        message: 'Password must be 8-16 characters long'
    },
    {
        test: (value) => /[A-Z]/.test(value),
        message: 'Must contain at least 1 uppercase letter'
    },
    {
        test: (value) => /[!@#$%^&*(),.?":{}|<>]/.test(value),
        message: 'Must contain at least 1 special character'
    },
    {
        test: (value) => /[0-9]/.test(value),
        message: 'Must contain at least 1 number'
    }
];

// Function to validate password
function validatePassword(password) {
    return validationRules.every(rule => rule.test(password));
}

// Function to validate both passwords
function validatePasswords() {
    const passwordInput = document.getElementById('password');
    const repasswordInput = document.getElementById('repassword');
    const password = passwordInput.value;
    const repassword = repasswordInput.value;

    // Get or create feedback elements
    let passwordFeedback = document.getElementById('password-feedback');
    passwordFeedback.className = 'text-red-600 text-xs p-0 m-0';
    let repasswordFeedback = document.getElementById('repassword-feedback');
    repasswordFeedback.className = 'text-red-600 text-xs p-0 m-0';

    if (!passwordFeedback) {
        passwordFeedback = document.createElement('div');
        passwordFeedback.id = 'password-feedback';
        passwordFeedback.className = 'text-red-600 text-xs p-0 m-0';
        passwordInput.parentNode.insertBefore(passwordFeedback, passwordInput.nextSibling);
    }

    if (!repasswordFeedback) {
        repasswordFeedback = document.createElement('div');
        repasswordFeedback.id = 'repassword-feedback';
        repasswordFeedback.className = 'text-red-600 text-xs p-0 m-0';
        repasswordInput.parentNode.insertBefore(repasswordFeedback, repasswordInput.nextSibling);
    }

    // Reset classes
    passwordInput.classList.remove('border-red-500', 'border-green-500');
    repasswordInput.classList.remove('border-red-500', 'border-green-500');

    // Validate main password
    const isPasswordValid = validatePassword(password);

    if (password) {
        if (isPasswordValid) {
            passwordInput.classList.add('border-green-500');
            passwordFeedback.classList.remove('text-red-600');
            // passwordFeedback.style.display = 'none';
        } else {
            passwordInput.classList.add('border-red-500');
            passwordFeedback.style.display = 'block';
            passwordFeedback.textContent = 'Password must be 8-16 characters with 1 uppercase, 1 number, and 1 special character';
        }
    } else {
        // passwordFeedback.style.display = 'none';
    }

    // Validate repassword
    if (repassword) {
        if (password === repassword && isPasswordValid) {
            repasswordInput.classList.add('border-green-500');
            repasswordFeedback.style.display = 'none';
        } else {
            repasswordInput.classList.add('border-red-500');
            repasswordFeedback.style.display = 'block';
            repasswordFeedback.textContent = 'Passwords do not match';
        }
    } else {
        repasswordFeedback.style.display = 'none';
    }

    return isPasswordValid && password === repassword;
}

document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password');
    const repasswordInput = document.getElementById('repassword');

    passwordInput.addEventListener('input', validatePasswords);
    repasswordInput.addEventListener('input', validatePasswords);
});
    </script>
@endpush
