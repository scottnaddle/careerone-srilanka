@extends('homepage.layouts.master')
@section('title', 'Trainee - My page - Personal information')
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
    <div class="my-6 flex flex-col gap-5">
        <p class="text-2xl text-[#464559] dark:text-white font-semibold">{{ trans('system.my_page.my_personal_information') }}</p>
        <div class="bg-white dark:bg-[#1E1E1E] rounded-xl  gap-4 relative">
            <div class="loading hidden h-full w-full opacity-90 z-50 absolute flex items-center justify-center w-56 h-56 border border-gray-200 bg-gray-50 dark:bg-gray-800 dark:border-gray-700">
                <div role="status">
                    <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/></svg>
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <div class="px-4 py-5 flex flex-col">
                <a class="text-xl text-[#464559] dark:text-white flex gap-4 items-center font-semibold capitalize hover:text-primary" href="{{route('trainee.my-page.my-page')}}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                    </svg>
                    {{$user->fullName}}
                </a>
                @if(session()->has('success'))
                    <div class="alert alert-success text-green-600 dark:text-white font-semibold bg-green-200 px-4 py-2 rounded-xl">
                        {{ session()->get('success') }}
                    </div>
                @endif
                @if($errors->any())
                    {!! implode('', $errors->all('<div class="alert alert-danger text-red-600 dark:text-red font-semibold bg-red-200 px-4 py-2 rounded-xl">:message</div>')) !!}
                @endif
                <form class="flex flex-col gap-6 px-6 py-5 lg:justify-between" method="post" action="{{route('trainee.my-page.personal-information.post')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="flex flex-col gap-4 items-center relative">
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
                        <div class="flex justify-center h-8 md:h-16 absolute right-0 top-0">
                            {!! checkSkillPassportInformation($user->nic) !!}
                        </div>
                        <div class="flex flex-col gap-1 items-center justify-center text-center">
                            <p class="text-2xl text-[#464559] font-semibold dark:text-white">{{$user->fullName}}</p>
                            <p class="text-sm md:text-base text-[#91919A] dark:text-white">
                                <span>{{$user->contact_address}}</span>
                            </p>
                            {!! getSumaryTraining($user->id) !!}
                            <button type="button" id="btn-get-information" class="text-primary hover:text-blue-700 underline">{{trans('trainee.my_page.get_information')}}</button>
                        </div>

                    </div>
                    <input type="text" class="hidden" value="{{$user->id}}" name="id" required />
                    <div class="w-full">
                        <div class="grid gap-6 mb-6 md:grid-cols-2">
                            <div class="">
                                <label for="full_name" class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{trans('trainee.my_page.full_name')}} <span class="text-red-700">*</span></label>
                                <input type="text" id="full_name" class="opacity-70 border border-[#EDEDED] text-[#464559] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 cursor-not-allowed" value="{{$user->full_name}}" name="full_name" required readonly />
                            </div>
                            <div class="">
                                <label for="email" class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">eMail <span class="text-red-700">*</span></label>
                                <input type="email" id="email" class="border border-[#EDEDED] text-[#464559] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{$user->email}}" name="email" required />
                                <small class="text-red-600">{{trans('trainee.my_page.alert_change_email')}}</small>
                            </div>
                            {{--                        <div>--}}
                            {{--                            <label for="last_name" class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">Last name <span class="text-red-700">*</span></label>--}}
                            {{--                            <input type="text" id="last_name" class="border border-[#EDEDED] text-[#464559] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{$user->last_name}}" name="last_name" required />--}}
                            {{--                        </div>--}}
                            <div>
                                <label for="mobile" class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{trans('trainee.my_page.mobile_1')}} <span class="text-red-700">*</span></label>
                                <input type="tel" id="mobile" class=" border border-[#EDEDED] text-[#464559] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{$user->mobile }}" name="mobile" required oninput="this.value = this.value.replace(/[^0-9+]/g, '')" />
                            </div>
                            <div>
                                <label for="phone" class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{trans('trainee.my_page.mobile_2')}} </label>
                                <input type="tel" id="phone" class=" border border-[#EDEDED] text-[#464559] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{ $user->telephone }}" name="telephone" oninput="this.value = this.value.replace(/[^0-9+]/g, '')" />
                            </div>

                            <p class="text-sm text-gray-500 dark:text-gray-400 italic mb-4">
                                ⓘ {{ __('trainee.my_page.synced_from_nvq') }}
                            </p>
                            {{--                            <select id="district" class="border border-[#EDEDED] text-[#464559] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"  name="district" required>--}}
                            {{--                                <option value="">Choose a District</option>--}}
                            {{--                                @forelse($districts as $district)--}}
                            {{--                                    <option value="{{$district->id}}" {{($user->district_id == $district->id) ? 'selected' : ''}}>{{$district->name}}</option>--}}
                            {{--                                @empty--}}
                            {{--                                @endforelse--}}
                            {{--                            </select>--}}
                            {{--                        </div>--}}
                            {{--                        <div>--}}
                            {{--                            <label for="institute" class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">Institute <span class="text-red-700">*</span></label>--}}
                            {{--                            <select id="institute" class="border border-[#EDEDED] text-[#464559] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="institute" required>--}}
                            {{--                                <option value="">Choose a Institute</option>--}}
                            {{--                                @forelse($institutes as $institute)--}}
                            {{--                                    <option value="{{$institute->id}}" {{($user->institute_id == $institute->id) ? 'selected' : ''}}>{{$institute->name}}</option>--}}
                            {{--                                @empty--}}
                            {{--                                @endforelse--}}
                            {{--                            </select>--}}
                            {{--                        </div>--}}
                            {{--                        <div>--}}
                            {{--                            <label class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white" for="file_input">Attached file</label>--}}
                            {{--                            <input class="block w-full text-sm text-[#464559] border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-[#1E1E1E] dark:border-gray-600 dark:placeholder-gray-400" id="file_input" type="file" name="attachment_details">--}}
                            {{--                        </div>--}}
                        </div>
                        <div class="flex justify-end gap-4">
{{--                            <button type="button" id="custom-reset" class="text-[#9F9FAA] bg-[#EDEDED] hover:bg-gray-300 focus:ring-4 focus:outline-none font-medium rounded-full text-sm sm:w-auto px-10 py-2.5 text-center">{{trans('system.form.button.reset')}}</button>--}}
                            <a href="{{route('trainee.my-page.my-page')}}" class="text-[#9F9FAA] bg-[#EDEDED] hover:bg-gray-300  focus:outline-none font-medium rounded-full text-sm sm:w-auto px-10 py-2.5 text-center">{{trans('system.form.button.cancel')}}</a>
                            <button type="submit" class="text-white bg-primary hover:bg-blue-700 focus:outline-none font-medium rounded-full text-sm  sm:w-auto px-10 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">{{trans('system.form.button.save')}}</button>
                        </div>
                    </div>
                </form>
            </div>

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
            $('#custom-reset').click(function() {
                // Reset only the specific fields
                $('#email').val('');
                $('#phone').val('');
                $('#mobile').val('');
            });


            $("#btn-get-information").click(function (e) {
                e.preventDefault();
                $(".loading").removeClass('hidden');
                $.ajax({
                    type: 'GET',
                    url: '/trainee/my-page/get-my-information',
                    success: function(data) {
                        if (data.success) {
                            let responses = data.data[0];
                            let fields = {
                                "full_name": responses['STD_FULL_NAME'],
                                "email": responses['STD_EMAIL'],
                                "telephone": responses['STD_TELPHONE'],
                                "mobile": responses['STD_MOBILE'],
                            };
                            // Loop through the fields and set their values if they're not empty
                            $.each(fields, function(fieldId, value) {
                                if (value) {
                                    $("#" + fieldId).val(value);
                                }
                            });

                            showToast('Your information has been retrieved successfully', 'success', 'green');
                        } else {
                            showToast('Failed to retrieve information: ' + data.data, 'error', 'red');
                        }
                    },
                    error: function(xhr) {
                        showToast('An error occurred: ' + xhr.statusText, 'error', 'red');
                    },
                    complete: function() {
                        $(".loading").addClass('hidden');
                    }
                });
            });
        });

    </script>
@endpush
