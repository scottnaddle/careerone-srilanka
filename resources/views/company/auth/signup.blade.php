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
    </style>
@endpush


@section('content')
    <div class="max-w-2xl mx-auto w-screen leading-9 py-24 px-7 flex h-auto mb-10 items-start">
        <div
            class="bg-white dark:bg-[#1E1E1E] shadow-md space-y-6 border-gray-200 rounded-xl px-10 py-5 ">
            <div class="flex flex-col gap-6">
                <a href="/choose-login"
                   class="text-gray-900 dark:text-white border-gray-200 font-medium gap-2 rounded-xl text-xl font-semibold w-fit text-center inline-flex items-center hover:text-primary dark:hover:text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                    </svg>
                    {{ trans('auth.choose_login_title') }}
                </a>

                <a href="/" class="flex items-center rtl:space-x-reverse w-fit">
                    <img src="{{asset('/images/careerone-logo.webp')}}" class="h-8 md:h-12 block dark:hidden" alt="Careerone Logo" />
                    <img src="{{asset('/images/careerone-logo-dark.webp')}}" class="h-8 md:h-12 hidden dark:block" alt="Careerone Logo" />
                </a>
                @if (session()->get('error'))
                    <span
                        class="bg-green-100 text-green-800 text-base font-medium px-2.5 py-3 rounded dark:bg-[#1E1E1E] dark:text-green-400 border border-green-400">{!! session()->get('error') !!}</span>
                @endif
                @if(session()->has('success'))
                    <div class="alert alert-success text-green-600 dark:text-white font-semibold bg-green-200 px-4 py-2 rounded-xl">
                        {{ session()->get('success') }}
                    </div>
                @endif
                <form class="space-y-6 leading-5" action="{{ route('company.auth.postRegister') }}" method="POST"
                    enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <input type="text" name="company_id" class="hidden" id="company_id" value="{{old('company_id')}}">
                    <div class="flex flex-col">
                        <label for="company" class="font-medium text-gray-600 block dark:text-gray-300 mb-2">
                            {{__('auth.Company name')}} <span class="text-red-600 p-1 text-center">*</span></label>
                        <div class="flex gap-2">
                            <input type="text" name="company" id="company" value="{{ old('company') }}"
                                placeholder=" {{__('auth.Type Name of Company and click Check')}}"
                                class="w-5/6 p-3 pl-4 h-9 bg-gray-50 border border-[#EDEDED]  sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white">
{{--                            <button type="button"--}}
{{--                                class="w-1/6 checkCompanyButton text-white bg-[#4984F6] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-full flex items-center justify-center--}}
{{--                         px-2 py-1 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 text-xs font-medium overflow-hidden text-ellipsis whitespace-nowrap">{{trans('system.form.button.checkwqe')}}--}}
{{--                            </button>--}}
                                <button type="button"
                                        class="w-1/6 checkCompanyButton text-white bg-[#4984F6] hover:bg-blue-800 rounded-full flex items-center justify-center
                                            px-2 py-1 text-center dark:bg-blue-600 text-xs font-medium">

                                            <span class="truncate w-full text-center">
                                                {{ trans('system.form.button.check') }}
                                            </span>
                                </button>
                                <button type="button"class="w-1/6 btn-reset text-white bg-gray-500 hover:bg-gray-600 rounded-full flex items-center justify-center px-2 py-1 text-center text-xs font-medium hidden">
                                                <span class="truncate w-full text-center">
                                                    {{ trans('system.form.button.reset') }}
                                                </span>
                                </button>
                        </div>
                        @if ($errors->has('company'))
                            <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('company') }}</span>
                        @endif
                        @if ($errors->has('company_id'))
                            <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('company_id') }}</span>
                        @endif
                    </div>

                    <div>
                        <label for="email"
                               class="font-medium text-gray-600 block mb-1.5 dark:text-gray-300">{{trans('system.form.email')}}<span
                                class="text-red-600 p-1 text-center">*</span>
                        </label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                               placeholder="You@email.com"
                               class="bg-gray-50 border p-3 pl-4 h-9 border-[#EDEDED] text-gray-900 sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white">
                        @if ($errors->has('email'))
                            <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('email') }}</span>
                        @endif
                    </div>

                    <div>
                        <label for="password"
                               class="font-medium text-gray-600 block mb-1.5 dark:text-gray-300">{{trans('system.form.password')}}<span
                                class="text-red-600 p-1 text-center">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" name="password" id="password"
                                   placeholder="********"
                                   class="bg-gray-50 border p-3 pl-4 h-9 border-[#EDEDED] text-gray-900 sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white"
                                   >
                            <button type="button" id="toggle-password" class="absolute inset-y-0 right-0 flex items-center pr-3 dark:text-white">
                                <!-- Eye Icon for Show Password -->
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5" id="eye-icon-show">
                                    <path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"></path>
                                    <path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" clip-rule="evenodd"></path>
                                </svg>
                                <!-- Eye Icon for Hide Password -->
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 hidden" id="eye-icon-hide">
                                    <path fill-rule="evenodd" d="M3.28 2.22a.75.75 0 0 0-1.06 1.06l14.5 14.5a.75.75 0 1 0 1.06-1.06l-1.745-1.745a10.029 10.029 0 0 0 3.3-4.38 1.651 1.651 0 0 0 0-1.185A10.004 10.004 0 0 0 9.999 3a9.956 9.956 0 0 0-4.744 1.194L3.28 2.22ZM7.752 6.69l1.092 1.092a2.5 2.5 0 0 1 3.374 3.373l1.091 1.092a4 4 0 0 0-5.557-5.557Z" clip-rule="evenodd"></path>
                                    <path d="m10.748 13.93 2.523 2.523a9.987 9.987 0 0 1-3.27.547c-4.258 0-7.894-2.66-9.337-6.41a1.651 1.651 0 0 1 0-1.186A10.007 10.007 0 0 1 2.839 6.02L6.07 9.252a4 4 0 0 0 4.678 4.678Z"></path>
                                </svg>
                            </button>
                        </div>
                        <small class=" text-xs p-0 m-0 dark:text-white" id="password-feedback"><i>{{trans('auth.Password must be 8-16 characters with 1 uppercase, 1 number, and 1 special character')}}</i></small>
                        @if ($errors->has('password'))
                            <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('password') }}</span>
                        @endif
                    </div>

                    <div>
                        <label for="repassword"
                               class="font-medium text-gray-600 block mb-1.5 dark:text-gray-300">{{trans('system.form.confirm_password')}}<span
                                class="text-red-600 p-1 text-center">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" name="repassword" id="repassword" placeholder="{{trans('Retype your password')}}"
                                   class="bg-gray-50 border p-3 pl-4 h-9 border-[#EDEDED] text-gray-900 sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white"
                                   >
                            <button type="button" id="toggle-repassword" class="absolute inset-y-0 right-0 flex items-center pr-3 dark:text-white">
                                <!-- Eye Icon for Show Password -->
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5" id="eye-icon-show-confirm">
                                    <path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"></path>
                                    <path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" clip-rule="evenodd"></path>
                                </svg>
                                <!-- Eye Icon for Hide Password -->
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 hidden" id="eye-icon-hide-confirm">
                                    <path fill-rule="evenodd" d="M3.28 2.22a.75.75 0 0 0-1.06 1.06l14.5 14.5a.75.75 0 1 0 1.06-1.06l-1.745-1.745a10.029 10.029 0 0 0 3.3-4.38 1.651 1.651 0 0 0 0-1.185A10.004 10.004 0 0 0 9.999 3a9.956 9.956 0 0 0-4.744 1.194L3.28 2.22ZM7.752 6.69l1.092 1.092a2.5 2.5 0 0 1 3.374 3.373l1.091 1.092a4 4 0 0 0-5.557-5.557Z" clip-rule="evenodd"></path>
                                    <path d="m10.748 13.93 2.523 2.523a9.987 9.987 0 0 1-3.27.547c-4.258 0-7.894-2.66-9.337-6.41a1.651 1.651 0 0 1 0-1.186A10.007 10.007 0 0 1 2.839 6.02L6.07 9.252a4 4 0 0 0 4.678 4.678Z"></path>
                                </svg>
                            </button>
                        </div>
                        <div id="repassword-feedback"></div>
                        @if ($errors->has('repassword'))
                            <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('repassword') }}</span>
                        @endif
                        <div class="error_repassword text-red-600 text-xs pt-1"></div>
                    </div>

                    <div>
                        <label for="first_name"
                            class="font-medium text-gray-600 block mb-1.5 dark:text-gray-300">{{trans('system.form.first_name')}}<span
                                class="text-red-600 p-1 text-center">*</span>
                        </label>
                        <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}"
                            placeholder="E.g: Saman"
                            class="bg-gray-50 border p-3 pl-4 h-9 border-[#EDEDED] text-gray-900 sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white">
                        @if ($errors->has('first_name'))
                            <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('first_name') }}</span>
                        @endif
                    </div>

                    <div>
                        <label for="last_name"
                            class="font-medium text-gray-600 block mb-1.5 dark:text-gray-300">{{trans('system.form.last_name')}}<span
                                class="text-red-600 p-1 text-center">*</span>
                        </label>
                        <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}"
                            placeholder="E.g: Gamage"
                            class="bg-gray-50 border p-3 pl-4 h-9 border-[#EDEDED] text-gray-900 sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white">
                        @if ($errors->has('last_name'))
                            <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('last_name') }}</span>
                        @endif
                    </div>


                    <div>
                        <label for="telephone"
                            class="font-medium text-gray-600 block mb-1.5 dark:text-gray-300">{{trans('system.form.telephone')}}<span
                                class="text-red-600 p-1 text-center">*</span>
                        </label>
                        <input type="text" name="telephone" id="telephone" value="{{ old('telephone') }}"
                            placeholder="Eg: 0129 084 713"
                            class="bg-gray-50 border p-3 pl-4 h-9 border-[#EDEDED] text-gray-900 sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white">
                        @if ($errors->has('telephone'))
                            <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('telephone') }}</span>
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
                            class="font-medium text-gray-600 block mb-1.5 dark:text-gray-300">{{trans('system.form.preferred_verification_method')}}<span class="text-red-600 p-1 text-center">*</span>
                        </label>
                        <div class="flex gap-6">
                            @foreach(getCodeList('verification_method') as $item)
                            <div class="flex items-center justify-center">
                                <input type="checkbox" name="verification_type" value="{{strtolower(str_replace('-', '', $item->code_name))}}"
                                {{ old('verification_type') == strtolower(str_replace('-', '', $item->code_name)) ? 'checked' : '' }}
                                    class="rounded-full shrink-0 border-gray-500 rounded-full text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800"
                                    id="hs-radio-group-{{$item->code_id}}">
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
                            class="h-4 w-4 shrink-0 text-blue-600 focus:ring-blue-500 border-gray-500 rounded"
                            value="1" {{ old('agree_terms') == '1' ? 'checked' : '' }}
                            />
                        <label for="agree_terms" class="pl-3 block text-sm text-gray-500">
                            {!! trans('system.form.accept_term_message', ['file' => asset('files/T&C for Company 2.pdf') ]) !!}
                        </label>
                    </div>
                    @if ($errors->has('agree_terms'))
                        <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('agree_terms') }}</span>
                    @endif


                    <button type="submit" id="signup-button" disabled
                        class="w-full text-white bg-[#4984F6] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-full
                        text-xl px-5 py-3 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">{{trans('auth.sign_up')}}
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div id="modalEl" tabindex="-1" aria-hidden="true" class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-10rem)] max-h-full w-full overflow-y-auto overflow-x-hidden p-4 md:inset-0">
        <div class="relative max-h-full w-full max-w-2xl">
            <!-- Modal content -->
            <div class="relative rounded-lg bg-white shadow dark:bg-gray-700">
                <!-- Modal body -->
                <div class="max-w-2xl mx-auto w-screen flex flex-col h-auto justify-start">
                    <div
                        class="bg-white shadow-md border space-y-6 border-gray-200 rounded-xl px-10 py-5 dark:bg-gray-800 dark:border-gray-700">
                        <div class="flex flex-col gap-6">
                            <a href="{{route('company.auth.register')}}" data-modal-hide="modalEl"
                               class="text-gray-900 bg-white border-gray-200 font-medium rounded-xl text-sm w-fit text-center inline-flex items-center">
                                <svg class="w-5 h-5 text-gray-800 dark:text-white mr-2" aria-hidden="true"
                                     xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="m15 19-7-7 7-7" />
                                </svg>
                                <span class="text-xl font-semibold text-gray-900 dark:text-white">{{trans('auth.Organisation Registration')}}</span>
                            </a>

                            <a href="/" class="flex items-center rtl:space-x-reverse w-fit">
                                <img src="/images/TVET.svg" alt="TVET Logo" />
                            </a>
                            <div class="flex flex-col gap-4">
                                <label for="company" class="font-medium text-gray-600 block dark:text-gray-300 mb-2">
                                    {{trans('general.Company')}} <span class="text-red-600 p-1 text-center">*</span></label>
                                <div class="flex gap-4 mb-1">
                                    <input type="text" name="company" value="{{ old('company') }}"
                                           placeholder=""
                                           class="w-5/6 p-3 pl-4 h-9 bg-gray-50 border border-[#EDEDED] text-[#91919A] sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white">
                                    <button type="button"
                                            class="checkCompanyButton text-white w-1/6 bg-[#4984F6] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-full flex items-center justify-center
                     px-2 py-1 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 text-xs font-medium">{{trans('system.form.button.search')}}
                                    </button>
                                </div>
                                <div class="relative overflow-x-auto">
                                    <div class="loading flex items-center justify-center w-full h-32 ">
                                        <div role="status">
                                            <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/></svg>
                                            <span class="sr-only">{{trans('system.form.loading')}}</span>
                                        </div>
                                    </div>
                                    <table class="w-full text-left rtl:text-right table-auto hidden">
                                        <thead class="bg-[#F5F7FA] dark:bg-[#282828] dark:text-white">
                                            <tr>
                                                <th scope="col" class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base">
                                                    {{trans('system.form.id')}}
                                                </th>
                                                <th scope="col" class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base text-center">
                                                    {{trans('system.form.company_name')}}
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-body">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <a href="{{route('company.register.get-form')}}"
                                    class="w-full text-white bg-[#4984F6] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-full
                        text-xl px-5 py-3 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">{{trans('system.form.button.register_new_company')}}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('js/select2.js') }}" type="module"></script>
    <script type="module">
         function validateTelephoneInput(input) {
                let value = input.value;
                if (value.length >= 1 && value.charAt(0) !== "0") {
                    value = "";
                }
                value = value.replace(/\D/g, '');
                value = value.substring(0, 10);
                input.value = value;
            }
            document.getElementById('telephone').oninput = function() {
                validateTelephoneInput(this);
            };
    </script>
    <script type="module">
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "{{trans('auth.Please select one')}}"
            });
            $('input[name="verification_type"]').on('change', function() {
                // If this checkbox is checked, uncheck the others
                if ($(this).is(':checked')) {
                    $('input[name="verification_type"]').not(this).prop('checked', false);
                }

                // Call the toggle function to check the button state
                toggleSignUpButton();
            });
// set the modal menu element
            const $targetEl = document.getElementById('modalEl');

// options with default values
            const options = {
                placement: 'center-center',
                backdrop: 'fixed',
                backdropClasses:
                    'bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-40',
                closable: true,
                onHide: () => {

                },
                onShow: () => {

                },
                onToggle: () => {

                },
            };

            // instance options object
            const instanceOptions = {
                id: 'modalEl',
                override: true
            };
            window.modal = new Modal($targetEl, options, instanceOptions);
            function isPasswordValid(password, repassword = null) {
                const validationRules = [
                    (value) => value.length >= 8 && value.length <= 16,  // length check
                    (value) => /[A-Z]/.test(value),                      // uppercase check
                    (value) => /[!@#$%^&*(),.?":{}|<>]/.test(value),    // special char check
                    (value) => /[0-9]/.test(value)                       // number check
                ];

                // Kiểm tra các rule cho password chính
                const isMainPasswordValid = validationRules.every(rule => rule(password));

                // Nếu không có repassword, chỉ trả về kết quả validate password chính
                if (repassword === null) {
                    return isMainPasswordValid;
                }

                // Nếu có repassword, kiểm tra cả khớp password và các rule
                return isMainPasswordValid && password === repassword;
            }
            function toggleSignUpButton() {
                // Get the values of all input fields
                let companyValue = $('#company').val();
                let firstNameValue = $('#first_name').val();
                let lastNameValue = $('#last_name').val();
                let emailValue = $('#email').val();
                let passwordValue = $('#password').val();
                let repasswordValue = $('#repassword').val();
                let telephoneValue = $('#telephone').val();
                let agreeTermsChecked = $('#agree_terms').is(':checked');
                const verificationTypeChecked = $('input[name="verification_type"]:checked').length > 0;
                var isPasswordInvalid = !isPasswordValid(passwordValue,repasswordValue);
                // Check if all input fields are empty or null
                let anyFieldEmptyOrNull = !verificationTypeChecked || !companyValue || !firstNameValue || !lastNameValue || !emailValue || !passwordValue || !repasswordValue || !telephoneValue || !agreeTermsChecked;

                // Disable or enable the Sign up button based on the condition
                if (anyFieldEmptyOrNull || isPasswordInvalid) {
                    $('#signup-button').addClass('disabled-button');
                    $('#signup-button').prop('disabled', true);
                } else {
                    $('#signup-button').removeClass('disabled-button');
                    $('#signup-button').prop('disabled', false);
                }
            }

            $('#repassword').on('input', function() {
                // Check is same value with password?
                let value = $(this).val();
                if($("#password").val() && value != $("#password").val()) {
                    $(".error_repassword").html('Confirmation password not match!');
                }else {
                    $(".error_repassword").html('');
                }
            });

            function toggleCheckButton() {
                // Get the values of all input fields
                let companyValue = $('#company').val();

                if (!companyValue) {
                    $('.checkCompanyButton').addClass('disabled-button cursor-not-allowed');
                    $('.checkCompanyButton').prop('disabled', true);
                } else {
                    $('.checkCompanyButton').removeClass('disabled-button cursor-not-allowed');
                    $('.checkCompanyButton').prop('disabled', false);
                }
            }
            toggleSignUpButton();
            toggleCheckButton();

            $('input, select').on('input change', function() {
                toggleSignUpButton();
                toggleCheckButton();
            });
            $("input[name='company']").on('input', function() {
                let value = $(this).val();
                $("input[name='company']").not(this).val(value);
            });

            if ($('#company').val().trim() !== '' && $('#company_id').val().trim() !== '') {
                $('.btn-reset').removeClass('hidden');
                $('.checkCompanyButton').addClass('hidden');
            }


            $(".checkCompanyButton").click(function (e) {
                e.preventDefault();
                $("#company_id").val('');
                $(".loading").removeClass('hidden');
                $("table").addClass('hidden');
                let keyword = $("input[name='company']").val();
                if(keyword != '') {
                    window.modal.show();
                    $.ajax({
                        type:'GET',
                        url:'/company/search/'+ keyword,
                        success:function(data) {
                            $(".table-body").html('');
                            let datas = data.data;
                            if(datas.length > 0) {
                                for(let i = 0; i < datas.length; i++) {
                                    let company_name = `<span class="dark:text-white">${datas[i].name} (${datas[i].district.name})</span>`;
                                    if(datas[i].verified_at == null && data.verified_by == null) {
                                        company_name += `
                                                    <span class="rounded-lg bg-gray-400 text-white px-2 py-1 text-xs">{{trans('company.pending_approval')}}</span>`;
                                    }

                                    $("#modalEl .table-body").append(`
                                        <tr class="bg-white dark:bg-[#1E1E1E] border-b border-[#F8F8F8] dark:border-gray-700">
                                            <td class="px-3 py-2 font-semibold text-sm text-[#201F36] dark:text-white flex items-center gap-1">
                                                ${datas[i].id}
                                            </td>
                                            <td class="px-3 py-2 text-sm text-[#706F81] dark:text-[#C9CCD4]">
                                                <div class="flex justify-between items-center">
                                                    <div class="text-left flex justify-between w-full">
                                                   `+company_name+`
                                                    </div>
                                                   <button class="btn-copy ml-2 text-blue-600 underline hover:text-blue-800" data-copy-id="${datas[i].id}" data-copy-name="${datas[i].name}">
                                                        {{trans('company.Select')}}
                                                    </button>

                                                </div>
                                            </td>
                                        </tr>
                                    `);
                                }

                            }else {
                                $("#modalEl .table-body").append(`<tr class="bg-white dark:bg-[#1E1E1E] border-b border-[#F8F8F8] dark:border-gray-700">
                                            <td class="px-3 py-2 font-semibold text-sm text-[#201F36] dark:text-white flex items-center gap-1">
                                                {{trans('company.not_found')}}
                                            </td>
                                        </tr>`);
                            }
                            $(".loading").addClass('hidden');
                            $("table").removeClass('hidden');
                        }
                    });
                }else {
                    Toastify({
                        text: "Please insert company keyword!",
                        duration: 2000,
                        className: "error",
                        style: {
                            background: "#e74c3c",
                        }
                    }).showToast();
                }
            });

// Toggle for Password
            $('#toggle-password').click(function() {
                const passwordInput = $('#password');
                const eyeIconShow = $('#eye-icon-show');
                const eyeIconHide = $('#eye-icon-hide');

                if (passwordInput.attr('type') === 'password') {
                    passwordInput.attr('type', 'text');
                    eyeIconShow.addClass('hidden');
                    eyeIconHide.removeClass('hidden');
                } else {
                    passwordInput.attr('type', 'password');
                    eyeIconShow.removeClass('hidden');
                    eyeIconHide.addClass('hidden');
                }
            });

            // Toggle for Re-password
            $('#toggle-repassword').click(function() {
                const repasswordInput = $('#repassword');
                const eyeIconShowConfirm = $('#eye-icon-show-confirm');
                const eyeIconHideConfirm = $('#eye-icon-hide-confirm');

                if (repasswordInput.attr('type') === 'password') {
                    repasswordInput.attr('type', 'text');
                    eyeIconShowConfirm.addClass('hidden');
                    eyeIconHideConfirm.removeClass('hidden');
                } else {
                    repasswordInput.attr('type', 'password');
                    eyeIconShowConfirm.removeClass('hidden');
                    eyeIconHideConfirm.addClass('hidden');
                }
            });
        });
        $(document).on('click', '.btn-copy', function(event) {
            let name =  $(this).data('copy-name');
            let id =  $(this).data('copy-id');
            if(name != '') {
                var $temp = $('<textarea>');
                $('body').append($temp);
                $temp.val(name).select();
                document.execCommand('copy');
                $temp.remove();
                // Toastify({
                //     text: "Copied!",
                //     duration: 2000,
                //     className: "infor",
                //     style: {
                //         background: "linear-gradient(to right, #00b09b, #96c93d)",
                //     }
                // }).showToast();

                $("input[name='company']").val(name);
                $("#company_id").val(id);
                $("input[name='company']").attr('readonly', 'true');
                $("input[name='company']").addClass('border-green-700');
                $('.checkCompanyButton').addClass('hidden');
                $('.btn-reset').removeClass('hidden');
                window.modal.hide();
            }
        });

        $(document).on('click', '.btn-reset', function(event) {
            $("input[name='company']").val('');
            $("input[name='company']").removeAttr('readonly');
            $("input[name='company']").removeClass('border-green-700');
            $('.btn-reset').addClass('hidden');
            $('.checkCompanyButton').removeClass('hidden');

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
            // repasswordFeedback.textContent = 'Passwords do not match';
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
