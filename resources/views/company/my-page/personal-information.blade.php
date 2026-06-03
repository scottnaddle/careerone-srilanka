@extends('homepage.layouts.master')
@section('title', 'Company - My page - Personal information')
@push('css')
    <style>
        .avatar-wrapper{
            position: relative;
            height: 8rem;
            width: 8rem;
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
    </style>
@endpush
@section('content')
    <div class="mb-6 flex flex-col">
        <div class="py-6">
            <x-breadcrumb :items="[
            ['label' => trans('company.menu.home'), 'url' => route('homepage')],
            ['label' => trans('system.menu.my_page'), 'url' => route('company.my-page.my-page')],
            ['label' => trans('company.my_page.my_personal_information'), 'url' => '#'],
        ]" />
        </div>
        <div class="bg-white dark:bg-[#1E1E1E] rounded-xl px-4 py-5 flex flex-col gap-4">
            <a class="text-xl text-[#464559] dark:text-white flex gap-4 items-center font-semibold capitalize hover:text-primary" href="{{route('company.my-page.my-page')}}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                </svg>
                {{$user->company->name}}
            </a>
            @if(session()->has('success'))
                <div class="alert alert-success text-green-600 dark:text-white font-semibold bg-green-200 px-4 py-2 rounded-xl">
                    {{ session()->get('success') }}
                </div>
            @endif
            @if($errors->any())
                {!! implode('', $errors->all('<div class="alert alert-danger text-red-600 dark:text-red font-semibold bg-red-200 px-4 py-2 rounded-xl">:message</div>')) !!}
            @endif
            <form class="flex flex-col lg:flex-row gap-6 px-6 py-5 lg:justify-between" method="post" action="{{route('company.my-page.personal-information.post')}}" enctype="multipart/form-data">
                @csrf
                <div class="flex flex-col gap-4 items-center">
                    <div class="avatar-wrapper shadow-custom-light dark:shadow-custom-dark rounded-full">
                        @if($user->profile_image != '')
                        <img class="profile-pic object-cover" src="{{asset($user->profile_image)}}" />
                        @else
                        <img class="profile-pic object-cover" src="{{asset('images/user-default.svg')}}" />
                        @endif
                        <div class="upload-button flex flex-col justify-end items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 bg-gray-800 opacity-50 w-full">
                                <path stroke-linecap="round" class="stroke-[#91919A] hover:stroke-white" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                                <path stroke-linecap="round" class="stroke-[#91919A] hover:stroke-white" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                            </svg>
                        </div>
                        <input class="file-upload" type="file" accept="image/*" name="avatar" />
                    </div>
                    <div class="flex flex-col gap-1 items-center justify-center text-center">
                        <p class="text-2xl text-[#464559] font-semibold dark:text-white">{{$user->fullName}}</p>
                        <p class="text-sm md:text-base text-[#91919A] dark:text-white">
                            <span>{{$user->company->name}}</span>
                        </p>
                    </div>

                </div>
                <div class="w-full lg:w-[80%]">
                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <div>
                            <label for="first_name" class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{trans('company.my_page.first_name')}} <span class="text-red-700">*</span></label>
                            <input type="text" id="first_name" class="border border-[#EDEDED] text-[#464559] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{$user->first_name}}" name="first_name" required />
                        </div>
                        <div>
                            <label for="last_name" class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{trans('company.my_page.last_name')}} <span class="text-red-700">*</span></label>
                            <input type="text" id="last_name" class="border border-[#EDEDED] text-[#464559] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{$user->last_name}}" name="last_name" required />
                        </div>
                        <div>
                            <label for="phone" class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{trans('company.my_page.telephone')}} <span class="text-red-700">*</span></label>
                            <input type="tel" id="phone" class=" border border-[#EDEDED] text-[#464559] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{formatPhoneNumber($user->telephone)}}" name="telephone" required />
                        </div>
                        <div class="">
                            <label for="email" class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">E-mail <span class="text-red-700">*</span></label>
                            <input type="email" id="email" class=" border border-[#EDEDED] text-[#464559] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{$user->email}}" name="email" required />
                        </div>


                    </div>
                    <div class="flex justify-end gap-4">
                        <button type="submit" class="text-[#9F9FAA] bg-[#EDEDED] hover:bg-gray-600 focus:ring-4 focus:outline-none font-medium rounded-full text-sm sm:w-auto px-10 py-2.5 text-center">{{trans('system.form.button.cancel')}}</button>
                        <button type="submit" class="text-white bg-primary hover:bg-blue-700 focus:ring-4 focus:outline-none font-medium rounded-full text-sm  sm:w-auto px-10 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">{{trans('system.form.button.save')}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function() {

            var readURL = function(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('.profile-pic').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $(".file-upload").on('change', function(){
                readURL(this);
            });

            $(".upload-button").on('click', function() {
                $(".file-upload").click();
            });
        });
    </script>
@endpush
