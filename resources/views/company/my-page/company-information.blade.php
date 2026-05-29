@extends('homepage.layouts.master')
@section('title', 'Company - My page - Company information')
@push('css')
    <link rel="stylesheet" href="{{asset('css/select2/select2.css')}}">
    <style>
        .avatar-wrapper{
            position: relative;
            height: 12rem;
            width: 12rem;
            overflow: hidden;
            transition: all .3s ease;
        &:hover{
             transform: scale(1.05);
             cursor: pointer;
         }
        &:hover .profile-pic{
             opacity: .5;
         }
        .profile-pic {
            height: 100%;
            width: 100%;
            transition: all .3s ease;
        }
        .upload-button {
            position: absolute;
            top: 0; left: 0;
            height: 100%;
            width: 100%;
        }
        }
        .select2-container--default .select2-selection--single{
            background-color: #fff;
            height: 2.25rem !important;
            font-size: 14px !important;
            padding-top: 0 !important;
            padding-bottom: 0!important;
            border-radius: 10px;
        }
        .select2-selection__rendered {
            color: #91919A !important;
            height: 100% !important;
        }
        .select2-selection__arrow {
            height: 100% !important;
        }
        .select2-container--default .select2-selection--single:is(.dark *) {
            background: #1E1E1E;
            border-color: #fff;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered:is(.dark *) {
            color: #fff !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 20px !important;
        }
        .select2-container .select2-selection--single .select2-selection__rendered {
            padding-top: 0.5rem !important;
            padding-left: 0 !important;
        }

    </style>
@endpush
@section('content')
    <div class="mb-6 flex flex-col">
        <div class="py-6">
            <x-breadcrumb :items="[
            ['label' => trans('company.menu.home'), 'url' => route('homepage')],
            ['label' => trans('system.menu.my_page'), 'url' => route('company.my-page.my-page')],
            ['label' => trans('company.my_page.my_company_information'), 'url' => '#'],
        ]" />
        </div>
        <div class="bg-white dark:bg-[#1E1E1E] rounded-xl px-4 py-5 flex flex-col gap-4">
            <a class="text-xl text-[#464559] dark:text-white flex gap-4 items-center font-semibold capitalize hover:text-primary" href="{{route('company.my-page.my-page')}}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                </svg>
                {{$company->name}}
            </a>
            @if(session()->has('success'))
                <div class="alert alert-success text-green-600 dark:text-white font-semibold bg-green-200 px-4 py-2 rounded-xl">
                    {{ session()->get('success') }}
                </div>
            @endif
{{--            @if($errors->any())--}}
{{--                {!! implode('', $errors->all('<div class="alert alert-danger text-red-600 dark:text-red font-semibold bg-red-200 px-4 py-2 rounded-xl">:message</div>')) !!}--}}
{{--            @endif--}}
            <form class="flex flex-col gap-4 xl:gap-6 xl:px-6 py-5 lg:justify-between" method="post" action="{{route('company.my-page.company-information.post')}}" enctype="multipart/form-data">
                @csrf
                <div class="flex flex-col gap-4">
                    <div class="avatar-wrapper shadow-custom-light dark:shadow-custom-dark text-primary">
                        @if($company->logo != '')
                            <img class="profile-pic object-cover" src="{{asset($company->logo)}}" />
                        @else
                            <img class="profile-pic object-cover" src="{{asset('images/company-logo-default.svg')}}" />
                        @endif
                        <div class="upload-button flex flex-col justify-end items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 bg-gray-800 opacity-50 w-full">
                                <path stroke-linecap="round" class="stroke-[#91919A] hover:stroke-white" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                                <path stroke-linecap="round" class="stroke-[#91919A] hover:stroke-white" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                            </svg>
                        </div>
                        <input class="file-upload" type="file" accept="image/*" name="avatar" />
                    </div>
{{--                    <div class="flex flex-col gap-1 items-center justify-center text-center">--}}
{{--                        <p class="text-2xl text-[#464559] font-semibold dark:text-white">{{$company->name}}</p>--}}
{{--                        <p class="text-sm md:text-base text-[#91919A] dark:text-white">--}}
{{--                            <span>{{$company->getDistrict()}}</span>--}}
{{--                        </p>--}}
{{--                    </div>--}}

                </div>
                <hr class="bg-[#EDEDED]">
                <div class="w-full">
                    <div class="grid gap-6 mb-6 xl:grid-cols-2">
                        <input type="text" name="id" value="{{$company->id}}" class="hidden" required>
                        <div class="flex flex-col col-span-2" id="business_registration_number">
                            <label for="business_registration_number" class=" font-medium text-gray-600 block dark:text-gray-300 mb-2">
                                {{trans('company.my_page.business_registration_number')}} <span class="text-red-600 p-1 text-center">*</span></label>
                            <div class="flex gap-4 mb-1">
                                <input type="text" name="business_registration_number" id="business_registration_number" value="{{ $company->business_registration_number }}"
                                       placeholder="XXXX XXXX XXXX"
                                       class="w-full p-3 pl-4 h-9 bg-white border border-gray-300 text-[#91919A] sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block dark:bg-[#1E1E1E] dark:border-white dark:placeholder-gray-400 dark:text-white">
                            </div>
                            @if ($errors->has('business_registration_number'))
                                <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('business_registration_number') }}</span>
                            @endif
                        </div>
                        <div class="col-span-2 xl:col-span-1">
                            <label for="name"
                                   class=" font-medium text-[#706F81] block mb-1.5 dark:text-gray-300">{{trans('company.my_page.company_name')}}<span
                                    class="text-red-600 p-1 text-center">*</span>
                            </label>
                            <input type="text" name="name" id="name" value="{{$company->name}}"
                                   class="bg-white border p-3 pl-4 h-9 border-gray-300 text-[#91919A] dark:text-white sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-gray-400 dark:text-white" required>
                            @if ($errors->has('name'))
                                <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                        <div class="col-span-2 xl:col-span-1">
                            <label for="office_type"
                                   class=" font-medium text-[#706F81] block mb-1.5 dark:text-gray-300">{{trans('company.my_page.office_type')}}<span class="text-red-600 p-1 text-center">*</span>
                            </label>
                            <div class="flex gap-6">
                                @foreach(getCodeList('office_type') as $office_type)
                                <div class="flex items-center justify-center">
                                    <input type="radio" name="office_type" value="{{$office_type->code_id}}" {{ $company->office_type == $office_type->code_id ? 'checked' : '' }}
                                    class="shrink-0 border-gray-300 dark:border-white rounded-full text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800"
                                           id="hs-radio-office-type-{{$office_type->code_id}}" required>
                                    <label for="hs-radio-office-type-{{$office_type->code_id}}"
                                           class="text-sm text-[#91919A] dark:text-white ms-3 dark:text-neutral-400">{{$office_type->code_name}}</label>
                                </div>
                                @endforeach
                            </div>

                            @if ($errors->has('office_type'))
                                <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('office_type') }}</span>
                            @endif
                        </div>
                        <div class="hidden col-span-2" id="input_headquarter">
                            <label for="headquarter"
                                   class=" font-medium text-[#706F81] block mb-1.5 dark:text-gray-300">{{trans('company.my_page.headquarter')}}
{{--                                <span--}}
{{--                                    class="text-red-600 p-1 text-center">*</span>--}}
                            </label>
                            <select class="select2 mb-0 bg-white" id="headquarter" name="headquarter_id" style="width: 100%"
                                    data-placeholder="Please select one">
                                <option></option>
                                @forelse($headquarters as $headquarter)
                                    <option value="{{$headquarter->id}}" {{($company->headquarter_id == $headquarter->id) ? 'selected' : ''}}>{{$headquarter->name}} - {{$headquarter->website}}</option>
                                @empty
                                @endforelse
                            </select>
                            @if ($errors->has('headquarter_id'))
                                <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('headquarter_id') }}</span>
                            @endif
                        </div>
                        <div class="flex flex-col col-span-2">
                            <label for="address"
                                   class=" font-medium text-[#706F81] block mb-1.5 dark:text-gray-300">{{trans('company.my_page.address')}}<span class="text-red-600 p-1 text-center">*</span>
                            </label>
                            <input type="text" name="address" id="address" value="{{$company->address}}"
                                   class="bg-white border p-3 pl-4 h-9 border-gray-300 text-[#91919A] dark:text-white sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-gray-400 dark:text-white" required>
                            @if ($errors->has('address'))
                                <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('address') }}</span>
                            @endif
                        </div>
                        <div class="grid grid-cols-4 gap-4 col-span-2 w-full items-center">
                            <div class="col-span-1">
                                <label for="phone" class="block mb-2 font-medium text-[#706F81] dark:text-white">{{trans('company.my_page.telephone')}} <span class="text-red-600 p-1 text-center">*</span></label>
                                <input type="tel" id="phone" class="bg-white border border-gray-300 dark:border-white text-[#91919A] text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 h-9" value="{{$company->hotline}}" name="hotline" required />
                                @if ($errors->has('hotline'))
                                <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('hotline') }}</span>
                            @endif
                            </div>
                            <div class="col-span-1">
                                <label for="website"
                                       class=" font-medium text-[#706F81] block mb-1.5 dark:text-gray-300">{{trans('company.my_page.website')}}
{{--                                    <span--}}
{{--                                        class="text-red-600 p-1 text-center">*</span>--}}
                                </label>
                                <input type="url" name="website" id="website" value="{{ $company->website }}"
                                       class="bg-white border p-3 pl-4 h-9 border-gray-300 text-[#91919A] dark:text-white sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-gray-400 dark:text-white" pattern="https?://.+" placeholder="https://example.com">
                                @if ($errors->has('website'))
                                    <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('website') }}</span>
                                @endif
                            </div>
                            <div class="flex flex-col col-span-2">
                                <label for="company_information" class="block mb-2 font-medium text-[#706F81] dark:text-white">{{trans('company.my_page.company_information')}}</label>
                                <select class="select2 mb-0 bg-white dark:bg-[#1E1E1E]" id="company_information" name="company_information" style="width: 100%"
                                        data-placeholder="Please select one" required>
                                    <option></option>
                                    @forelse(getCodeList('company_information') as $information)
                                        <option value="{{$information->code_id}}" {{($information->code_id == $company->company_information) ? 'selected' : ''}}>{{$information->code_name}}</option>
                                    @empty
                                    @endforelse
                                </select>
{{--                                <div class="flex gap-2 h-full items-center">--}}
{{--                                    @foreach(getCodeList('company_information') as $information)--}}
{{--                                        <div class="flex items-center justify-center">--}}
{{--                                            <input type="radio" name="company_information" value="{{$information->code_id}}" {{ $company->company_information == $information->code_id ? 'checked' : '' }}--}}
{{--                                            class="shrink-0 border-gray-300 dark:border-white rounded-full text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800"--}}
{{--                                                   id="hs-radio-information-{{$information->code_id}}">--}}
{{--                                            <label for="hs-radio-information-{{$information->code_id}}"--}}
{{--                                                   class="text-sm text-[#91919A] dark:text-white ms-3 dark:text-neutral-400">{{$information->code_name}}</label>--}}
{{--                                        </div>--}}
{{--                                    @endforeach--}}
{{--                                </div>--}}

                            </div>
                        </div>

                        <div class="col-span-2 xl:col-span-1">
                            <label for="default-datepicker"
                                   class=" font-medium text-[#706F81] block mb-1.5 dark:text-gray-300">{{trans('company.my_page.date_of_establishment')}}<span
                                    class="text-red-600 p-1 text-center">*</span>
                            </label>
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 start-0 flex items-center pe-3.5 pointer-events-none justify-end right-0">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                    </svg>
                                </div>

                                <input id="dateOfEstablishment" name="date_of_establishment" type="text" class="bg-white dark:bg-[#1E1E1E] border border-gray-300 text-[#91919A] dark:text-white text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:border-white dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required value="{{$company->date_of_establishment}}" >
                            </div>
                        </div>
                        <div class="col-span-2 xl:col-span-1">
                            <label for="name_of_representative"
                                   class=" font-medium text-[#706F81] block mb-1.5 dark:text-gray-300">{{trans('company.my_page.name_of_representative')}}
{{--                                <span--}}
{{--                                    class="text-red-600 p-1 text-center">*</span>--}}
                            </label>
                            <input type="text" name="name_of_representative" id="name_of_representative" value="{{$company->name_of_representation }}"
                                   class="bg-white border p-3 pl-4 h-9 border-gray-300 text-[#91919A] dark:text-white sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-gray-400 dark:text-white">
                            @if ($errors->has('name_of_representative'))
                                <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('name_of_representative') }}</span>
                            @endif
                        </div>

                        <div class="col-span-2 xl:col-span-1">
                            <label for="number_workers"
                                   class=" font-medium text-[#706F81] block mb-1.5 dark:text-gray-300">{{trans('company.my_page.number_of_worker')}}<span
                                    class="text-red-600 p-1 text-center">*</span>
                            </label>
                            <input type="text" name="number_workers" id="number_workers" value="{{ $company->number_workers }}"
                                   class="bg-white border p-3 pl-4 h-9 border-gray-300 text-[#91919A] dark:text-white sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-gray-400 dark:text-white" required >
                            @if ($errors->has('number_workers'))
                                <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('number_workers') }}</span>
                            @endif
                        </div>
                        <div class="col-span-2 xl:col-span-1">
                            <label for="email"
                                   class=" font-medium text-[#706F81] block mb-1.5 dark:text-gray-300">E-mail
                            </label>
                            <input type="email" name="email" id="email" value="{{ $company->email }}"
                                   placeholder="You@email.com"
                                   class="bg-white border p-3 pl-4 h-9 border-gray-300 text-[#91919A] dark:text-white sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-gray-400 dark:text-white" required>
                            @if ($errors->has('email'))
                                <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('email') }}</span>
                            @endif
                        </div>

                        <div class="col-span-2 xl:col-span-1">
                            <label for="district_id"
                                   class=" font-medium text-[#706F81] block mb-1.5 dark:text-gray-300">{{trans('company.my_page.district')}}<span
                                    class="text-red-600 p-1 text-center">*</span>
                            </label>
                            <select class="select2 mb-0 bg-white dark:bg-[#1E1E1E]" id="districtSelect" name="district" style="width: 100%"
                                    data-placeholder="Please select one" required>
                                <option></option>
                                @forelse($districts as $district)
                                    <option value="{{$district->id}}" {{($company->district_id == $district->id) ? 'selected' : ''}}>{{$district->name}}</option>
                                @empty
                                @endforelse
                            </select>
                            @if ($errors->has('district'))
                                <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('district') }}</span>
                            @endif
                        </div>

                        <div class="col-span-2 xl:col-span-1">
                            <label for="ds_divisionsSelect"
                                   class=" font-medium text-[#706F81] block mb-1.5 dark:text-gray-300">{{trans('company.my_page.ds_division')}}<span
                                    class="text-red-600 p-1 text-center">*</span>
                            </label>
                            <select class="select2 mb-0 bg-white dark:bg-[#1E1E1E] cursor-not-allowed" id="ds_divisionsSelect" name="ds_id" style="width: 100%"
                                    data-placeholder="Please select one" {{$company->ds_id != '' ? 'disabled' : ''}} required>
                                @if($company->ds_id != '')
                                <option value="{{$company->ds_id}}" selected>{{$company->ds->ds_name}}</option>
                                @else
                                    <option value="">Please select one</option>
                                    @forelse($ds_divisions as $ds)
                                        <option value="{{$ds->id}}">{{$ds->ds_name}}</option>
                                    @empty
                                    @endforelse
                                @endif
                            </select>
                            @if ($errors->has('ds_id'))
                                <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('ds_id') }}</span>
                            @endif
                        </div>



                        <div class="col-span-2 xl:col-span-2">
                            <label for="co_business"
                                   class=" font-medium text-[#706F81] block mb-1.5 dark:text-gray-300">{{trans('company.my_page.co_business')}}
                            </label>
                            <input type="text" name="co_business" id="co_business" value="{{ $company->co_business }}"
                                   class="bg-white border p-3 pl-4 h-9 border-gray-300 text-[#91919A] dark:text-white sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-gray-400 dark:text-white" >
                            {{--                            <select class="select2 mb-0 bg-white dark:bg-[#1E1E1E]" id="co_businessSelect" name="co_business" style="width: 100%"--}}
                            {{--                                    data-placeholder="Please select one" required>--}}
                            {{--                                <option></option>--}}
                            {{--                                @forelse($co_businesses as $co_business)--}}
                            {{--                                    <option value="{{$co_business->id}}" {{($company->co_business_id == $co_business->id) ? 'selected' : ''}}>{{$co_business->name}}</option>--}}
                            {{--                                @empty--}}
                            {{--                                @endforelse--}}
                            {{--                            </select>--}}
                            @if ($errors->has('co_business'))
                                <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('co_business') }}</span>
                            @endif
                        </div>


                        <div class="col-span-2 xl:col-span-2">
                            <label for="sns_channel"
                                   class=" font-medium text-[#706F81] block mb-1.5 dark:text-gray-300">{{trans('company.sns_channel')}}
                            </label>
                            <input type="text" name="sns_channel" id="sns_channel" value="{{ $company->sns_channel }}"
                                   class="bg-white border p-3 pl-4 h-9 border-gray-300 text-[#91919A] dark:text-white sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-gray-400 dark:text-white" >
                            @if ($errors->has('sns_channel'))
                                <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('sns_channel') }}</span>
                            @endif
                        </div>


                        <div class="col-span-2 xl:col-span-2">
                            <label for="attached_file"
                                   class=" font-medium text-[#706F81] block mb-1.5 dark:text-white">{{trans('company.my_page.attached_file')}}
                            </label>
                            <input
                                class="relative bg-white dark:bg-[#1E1E1E] m-0 block w-full min-w-0 flex-auto cursor-pointer rounded-xl border border-gray-300 bg-transparent bg-clip-padding px-3 py-[0.32rem] text-xs font-normal text-surface transition duration-300 ease-in-out file:-mx-3 file:-my-[0.32rem] file:me-3 file:cursor-pointer file:overflow-hidden file:rounded-none file:border-0 file:border-e file:border-solid file:border-inherit file:bg-transparent file:px-3  file:py-[0.32rem] file:text-surface focus:border-primary focus:text-gray-700 focus:shadow-inset focus:outline-none dark:border-white/70 dark:text-white  file:dark:text-white"
                                id="attached_file" type="file" name="attached_file[]" accept=".pdf, image/*" multiple />
                            <span class="text-red-600 text-xs p-0 m-0"
                                  id="attached_file_error">{{ $errors->first('attached_file') }}</span>
                        </div>
{{--                        <div class="col-span-2 xl:col-span-1">--}}
{{--                            <label for="services"--}}
{{--                                   class=" font-medium text-[#706F81] block mb-1.5 dark:text-white">Services--}}
{{--                            </label>--}}
{{--                            <textarea id="services" name="services" rows="4" maxlength="1000"--}}
{{--                                      class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 dark:border-white focus:ring-blue-500 focus:border-blue-500 dark:bg-[#1E1E1E] dark:border-gray-300 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"--}}
{{--                                      placeholder="Services...">{{$company->services}}</textarea>--}}
{{--                        </div>--}}
{{--                        <div class="col-span-2 xl:col-span-1">--}}
{{--                            <label for="short_bio"--}}
{{--                                   class=" font-medium text-[#706F81] block mb-1.5 dark:text-white">Short Bio--}}
{{--                            </label>--}}
{{--                            <textarea id="services" name="short_bio" rows="4"--}}
{{--                                      class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 dark:border-white focus:ring-blue-500 focus:border-blue-500 dark:bg-[#1E1E1E] dark:border-gray-300 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"--}}
{{--                                      placeholder="Short Bio...">{{$company->short_bio}}</textarea>--}}
{{--                        </div>--}}

                        @if($company->attachment_details != '')
                            <div class="flex flex-col gap-2 w-full border-t border-gray-300 col-span-2 pt-4">
                                <p class="font-medium text-[#706F81] block mb-1.5 dark:text-white">{{trans('company.my_page.attachment')}}:</p>
                                <div class="flex flex-col gap-2" id="file-list">
                                    @forelse(json_decode($company->attachment_details) as $key => $attachment)
                                        <div id="attachment-{{$key}}" class="flex gap-1 items-center">
                                            <a href="{{asset($attachment->path)}}" target="_blank" class="hover:text-primary text-sm py-1 px-2 bg-gray-100 rounded-xl">{{$attachment->name}}</a> <button type="button" class="remove-attachment" data-file="{{$attachment->path}}" data-id="{{$key}}" data-company-id="{{$company->id}}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="20" viewBox="0 0 18 20" fill="none">
                                                    <path d="M12.3333 4.99996V4.33329C12.3333 3.39987 12.3333 2.93316 12.1517 2.57664C11.9919 2.26304 11.7369 2.00807 11.4233 1.84828C11.0668 1.66663 10.6001 1.66663 9.66667 1.66663H8.33333C7.39991 1.66663 6.9332 1.66663 6.57668 1.84828C6.26308 2.00807 6.00811 2.26304 5.84832 2.57664C5.66667 2.93316 5.66667 3.39987 5.66667 4.33329V4.99996M7.33333 9.58329V13.75M10.6667 9.58329V13.75M1.5 4.99996H16.5M14.8333 4.99996V14.3333C14.8333 15.7334 14.8333 16.4335 14.5608 16.9683C14.3212 17.4387 13.9387 17.8211 13.4683 18.0608C12.9335 18.3333 12.2335 18.3333 10.8333 18.3333H7.16667C5.76654 18.3333 5.06647 18.3333 4.53169 18.0608C4.06129 17.8211 3.67883 17.4387 3.43915 16.9683C3.16667 16.4335 3.16667 15.7334 3.16667 14.3333V4.99996" stroke="#F34550" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </button>
                                        </div>
                                    @empty
                                        <small class="dark:text-white">{{trans('company.my_page.no_attachment')}}</small>
                                    @endforelse
                                </div>
                            </div>
                        @endif
                        <div class="flex items-center w-full hidden">
                            <input id="agree_terms" name="agree_terms" type="checkbox"
                                    value="1" {{ old('agree_terms') == '1' ? 'checked' : '' }}
                                   class="h-4 w-4 shrink-0 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" checked required />
                            <label for="agree_terms" class="pl-3 block text-sm text-[#91919A]">
                                I agree with<a href="javascript:void(0);" class="text-primary font-semibold underline hover:underline ml-1">Terms and Conditions</a>
                            </label>
                        </div>


                    </div>
                    <div class="flex justify-end gap-4">
                        <a href="{{route('company.my-page.my-page')}}" class="text-[#9F9FAA] bg-[#EDEDED] hover:bg-gray-600 focus:ring-4 focus:outline-none font-medium rounded-full text-sm sm:w-auto px-10 py-2.5 text-center">{{trans('system.form.button.cancel')}}</a>
                        <button type="submit" class="text-white bg-primary hover:bg-blue-700 focus:ring-4 focus:outline-none font-medium rounded-full text-sm  sm:w-auto px-10 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">{{trans('system.form.button.save')}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div id="modalEl" tabindex="-1" aria-hidden="true" class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-10rem)] max-h-full w-full overflow-y-auto overflow-x-hidden p-4 md:inset-0">
        <div class="relative max-h-full w-full max-w-2xl">
            <!-- Modal content -->
            <div class="relative rounded-lg bg-white shadow dark:bg-gray-700">
                <div class="relative bg-white rounded-lg shadow dark:bg-[#1E1E1E] dark:border dark:border-white px-4 py-8">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between pb-4 border-b rounded-t">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white text-center">
                            Alert
                        </h3>
                        <button type="button" class="close-modal text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="modalEl">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="flex flex-col gap-4">
                        <svg class="mt-6 mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                        </svg>
                        <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400 text-center">Are you sure you want to delete this content?</h3>
                        <div class="flex justify-center gap-4">
                            <button type="button" id="confirm-remove" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                Yes, I'm sure
                            </button>
                            <button data-modal-hide="modalEl" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">No, cancel</button>
                        </div>

                    </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('js/select2.js') }}" type="module"></script>

    <script type="module">
        document.addEventListener('DOMContentLoaded', function() {
            const modalEl = document.getElementById('modalEl');
            const modalOptions = {
                placement: 'center-center',
                backdrop: 'fixed',
                backdropClasses: 'bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-40',
                closable: true,
                onHide: () => {
                    clearModalData();
                }
            };

            const instanceOptions = {
                id: 'modalEl',
                override: true
            };

            const modal = new Modal(modalEl, modalOptions, instanceOptions);

            // Cache selectors for reuse
            const $confirmRemove = $("#confirm-remove");
            const $modal = $("#modalEl");

            // Function to clear modal data attributes
            const clearModalData = () => {
                $confirmRemove.attr('data-id', '');
                $confirmRemove.attr('data-file', '');
                $confirmRemove.attr('data-company-id', '');
            };

            // Handle attachment removal
            $(".remove-attachment").on('click', function () {
                const id = $(this).data('id');
                const file = $(this).data('file');
                const companyId = $(this).data('company-id');

                $confirmRemove.attr('data-id', id);
                $confirmRemove.attr('data-file', file);
                $confirmRemove.attr('data-company-id', companyId);

                modal.show();
            });

            // Handle confirmation for removal
            $confirmRemove.on('click', function () {
                const file = $(this).data('file');
                const id = $(this).data('id');
                const companyId = $(this).data('company-id');

                $.ajax({
                    type: 'POST',
                    url: '{{ route('company.my-page.company-information.remove-attachment') }}',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: companyId,
                        path: file
                    },
                    success: (data) => {
                        modal.hide();
                        $(`#file-list #attachment-${id}`).remove();
                        showToast("Removed!");
                    },
                    error: (error) => {
                        console.error('Error removing attachment:', error);
                        showToast("Error removing file", true);
                    }
                });
            });

            // Function to show a toast notification
            const showToast = (message, isError = false) => {
                Toastify({
                    text: message,
                    duration: 2000,
                    className: isError ? 'error' : 'info',
                    style: {
                        background: isError ? 'linear-gradient(to right, #ff5f6d, #ffc371)' : 'linear-gradient(to right, #00b09b, #96c93d)',
                    }
                }).showToast();
            };

            // Handle office type change visibility
            const $headquarterInput = $("#input_headquarter");

            const toggleHeadquarterInput = () => {
                const officeType = $("input[name='office_type']:checked").val();
                $headquarterInput.toggleClass('hidden', officeType != {{getCodeIdByStringEn('office_type', 'branch')}});
            };

            $("input[name='office_type']").on('change', toggleHeadquarterInput);

            // Initial call to set visibility
            toggleHeadquarterInput();

            // Initialize datepicker
            const datepickerEl = document.getElementById('dateOfEstablishment');
            const today = new Date();

            new Datepicker(datepickerEl, {
                format: 'yyyy-mm-dd',
                maxDate: today,
                autohide: true
            });

            // Initialize select2
            $('.select2').select2({
                placeholder: "Please select one"
            });




            $(document).ready(function () {
                $('#districtSelect').on('change', function () {
                    var districtId = $(this).val();
                    var dsDivisionsSelect = $('#ds_divisionsSelect');

                    // Clear the existing options
                    dsDivisionsSelect.html('<option></option>').prop('disabled', true);

                    if (districtId) {
                        $.ajax({
                            url: '/company/my-page/get-ds-divisions',
                            type: 'GET',
                            data: { district_id: districtId },
                            success: function (response) {
                                if (response.length > 0) {
                                    $.each(response, function (key, dsDivision) {
                                        dsDivisionsSelect.append(
                                            `<option value="${dsDivision.id}">${dsDivision.ds_name}</option>`
                                        );
                                    });
                                    dsDivisionsSelect.prop('disabled', false); // Enable dropdown
                                    $('.select2').select2({
                                        placeholder: "Please select one"
                                    });
                                }
                            },
                            error: function () {
                                alert('Failed to load DS Divisions. Please try again.');
                            }
                        });
                    }
                });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const readURL = (input) => {
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        document.querySelector('.profile-pic').setAttribute('src', e.target.result);
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            };

            // Trigger file upload when upload button is clicked
            const $fileUpload = document.querySelector('.file-upload');
            const $uploadButton = document.querySelector('.upload-button');

            $fileUpload.addEventListener('change', function() {
                readURL(this);
            });

            $uploadButton.addEventListener('click', function() {
                $fileUpload.click();
            });
        });
    </script>

@endpush
