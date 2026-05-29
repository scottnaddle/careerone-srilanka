@extends('homepage.layouts.master')
@section('title', 'CGO - My page - Personal information')
@push('css')
{{--    <link rel="stylesheet" href="{{asset('css/select2/select2.css')}}">--}}
    <style>
        .avatar-wrapper {
            position: relative;
            height: 8rem;
            width: 8rem;
            overflow: hidden;
            transition: all .3s ease;

            &:hover {
                transform: scale(1.05);
                cursor: pointer;
            }

            &:hover .profile-pic {
                opacity: .5;
            }

            .profile-pic {
                height: 100%;
                width: 100%;
                transition: all .3s ease;
            }

            .upload-button {
                position: absolute;
                top: 0;
                left: 0;
                height: 100%;
                width: 100%;
            }
        }
        #passwordModal {
            z-index: 50;
        }
        #loading-overlay{
            position: fixed;
            z-index: 51;
        }
        .select2-container--default .select2-selection--single{
            height: 2.6rem !important;
        }
    </style>
@endpush

@section('content')
    <div id="loading-overlay"
        class="hidden  fixed top-0 left-0 right-0 bottom-0 w-full h-screen z-60 overflow-hidden bg-gray-700 opacity-75 flex flex-col items-center justify-center">
        <div class="loader ease-linear rounded-full border-4 border-t-4 border-gray-200 h-12 w-12 mb-4"></div>
        <h2 class="text-center text-white text-xl font-semibold">{{ __('main.loading_overlay_title') }}</h2>
        <p class="w-1/3 text-center text-white">{{ __('main.loading_overlay_description') }}</p>
    </div>
    <div class="my-6 flex flex-col gap-5">
        <p class="text-2xl text-[#464559] dark:text-white font-semibold">My personal information</p>
        <div class="bg-white dark:bg-[#1E1E1E] rounded-xl px-4 py-5 flex flex-col gap-4">
            <a class="text-xl text-[#464559] dark:text-white flex gap-4 items-center font-semibold capitalize hover:text-primary"
                href="{{ route('cgo.my-page.my-page') }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                </svg>
                {{ $user->fullName }}
            </a>
            @if (session()->has('success'))
                <div
                    class="alert alert-success text-green-600 dark:text-white font-semibold bg-green-200 px-4 py-2 rounded-xl">
                    {{ session()->get('success') }}
                </div>
            @endif
            @if ($errors->any())
                {!! implode(
                    '',
                    $errors->all(
                        '<div class="alert alert-danger text-red-600 dark:text-red font-semibold bg-red-200 px-4 py-2 rounded-xl">:message</div>',
                    ),
                ) !!}
            @endif
            <form class="flex flex-col lg:flex-row gap-6 px-6 py-5 lg:justify-between" method="post"
                id="form-personal-information" action="{{ route('cgo.my-page.personal-information.post') }}"
                enctype="multipart/form-data">
                @csrf
                <div class="flex flex-col gap-4 items-center">
                    <div class="avatar-wrapper shadow-custom-light dark:shadow-custom-dark rounded-full">
                        @if ($user->profile_image != '')
                            <img class="profile-pic object-cover" src="{{ asset($user->profile_image) }}" />
                        @else
                            <img class="profile-pic object-cover" src="{{ asset('images/user-default.svg') }}" />
                        @endif
                        <div class="upload-button flex flex-col justify-end items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-8 bg-gray-800 opacity-50 w-full">
                                <path stroke-linecap="round" class="stroke-[#91919A] hover:stroke-white"
                                    stroke-linejoin="round"
                                    d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                                <path stroke-linecap="round" class="stroke-[#91919A] hover:stroke-white"
                                    stroke-linejoin="round"
                                    d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                            </svg>
                        </div>
                        <input class="file-upload" type="file" accept="image/*" name="avatar" />
                    </div>
                    <div class="flex flex-col gap-1 items-center justify-center text-center">
                        <p class="text-2xl text-[#464559] font-semibold dark:text-white">{{ $user->fullName }}</p>
                        <p class="text-sm md:text-base text-[#91919A] dark:text-white">
                            <span>{{ $user->district->name }}</span> |
                            <span>{{ $user->institute->name }}</span>
                        </p>
                    </div>

                </div>
                <div class="w-full lg:w-[80%]">
                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <div>
                            <label for="first_name"
                                class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{trans('cgo.first_name')}} <span
                                    class="text-red-700">*</span></label>
                            <input type="text" id="first_name"
                                class="border border-[#EDEDED] text-[#464559] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                value="{{ $user->first_name }}" name="first_name" required />
                        </div>
                        <div>
                            <label for="last_name"
                                class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{trans('cgo.last_name')}} <span
                                    class="text-red-700">*</span></label>
                            <input type="text" id="last_name"
                                class="border border-[#EDEDED] text-[#464559] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                value="{{ $user->last_name }}" name="last_name" required />
                        </div>
                        <div>
                            <label for="phone"
                                class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{trans('system.form.telephone')}} <span
                                    class="text-red-700">*</span></label>
                            <input type="tel" id="phone"
                                class="border border-[#EDEDED] text-[#464559] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                value="{{ formatPhoneNumber($user->telephone) }}" name="telephone" required />
                        </div>
                        <div class="">
                            <label for="email"
                                class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{trans('system.form.email')}} <span
                                    class="text-red-700">*</span></label>
                            <input type="email"id="email"
                                class="border border-[#EDEDED] text-[#464559] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                value="{{ $user->email }}" name="email" required />
                            <small class="text-red-600">{{trans('trainee.my_page.alert_change_email')}}</small>
                        </div>
                        <div>
                            <label for="district" class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">District <span class="text-red-700">*</span></label>
                            <select id="district"
                                class="border border-[#EDEDED] text-[#464559] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                name="district" required>
                                <option value="">Choose a District</option>
                                @forelse($districts as $district)
                                    <option value="{{ $district->id }}" {{ $user->district_id == $district->id ? 'selected' : '' }}>
                                        {{ $district->name }}
                                    </option>
                                @empty
                                @endforelse
                            </select>
                            <small class="text-red-600">{{trans('general.alert_change_region')}}</small>
                        </div>

                        <div>
                            <label for="institute" class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">Institute <span class="text-red-700">*</span></label>
                            <select id="institute"
                                class="border border-[#EDEDED] text-[#464559] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                name="institute" required>
                                <option value="">Choose an Institute</option>
                                @forelse($institutes as $institute)
                                    <option value="{{ $institute->id }}" {{ $user->institute_id == $institute->id ? 'selected' : '' }}>
                                        {{ $institute->name }} ({{ $institute->reg_no }})
                                    </option>
                                @empty
                                @endforelse
                            </select>
                        </div>

                        {{--                        <div> --}}
                        {{--                            <label class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white" for="file_input">Attached file</label> --}}
                        {{--                            <input class="block w-full text-sm text-[#464559] border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-[#1E1E1E] dark:border-gray-600 dark:placeholder-gray-400" id="file_input" type="file" name="attachment_details"> --}}
                        {{--                        </div> --}}
                    </div>
                    <div class="flex justify-end gap-4">
                        <!-- Cancel Button -->
                        <button type="button"
                            class="text-[#9F9FAA] bg-[#EDEDED] hover:bg-gray-600 focus:ring-4 focus:outline-none font-medium rounded-full text-sm sm:w-auto px-10 py-2.5 text-center">
                            Cancel
                        </button>
                        <!-- Save Button triggers Modal -->
                        <button type="submit" id="openModal"
                            class="text-white bg-primary hover:bg-blue-700 focus:ring-4 focus:outline-none font-medium rounded-full text-sm sm:w-auto px-10 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Save
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
@push('js')
    <script src="{{ asset('js/select2.js') }}" type="module"></script>
    <script>
        $(document).ready(function() {
            $(document).ready(function () {
                $('#institute').select2({
                    placeholder: "Choose an Institute",
                    allowClear: true,
                    maximumSelectionLength: 0
                });

                // Lấy giá trị institute_id từ server
                let selectedInstituteId = {{$user->institute_id}};

                // Thiết lập giá trị ngay lập tức, không cần setTimeout
                if (selectedInstituteId) {
                    $('#institute').val(selectedInstituteId).trigger('change');
                }

            });


            var readURL = function(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('.profile-pic').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $(".file-upload").on('change', function() {
                readURL(this);
            });

            $(".upload-button").on('click', function() {
                $(".file-upload").click();
            });
        });

        $(document).ready(function () {
    $('#district').on('change', function () {
        const districtId = $(this).val();
        $('#institute').empty();
        if (districtId) {
            $.ajax({
                url: `/api/trainee/district/${districtId}/institutes`,
                type: 'GET',
                success: function (response) {
                    $('#institute').empty();
                    $('#institute').append('<option value="">Choose an Institute</option>');
                    response.forEach(function (institute) {
                        const selected = institute.id === '{{ $user->institute_id }}' ? 'selected' : '';
                        $('#institute').append(`<option value="${institute.id}" ${selected}>${institute.name} (${institute.reg_no})</option>`);
                    });
                },
                error: function () {
                    alert('There was an error while fetching institutes. Please try again.');
                }
            });
        } else {
            $('#institute').empty();
            $('#institute').append('<option value="">Choose an Institute</option>');
        }
    });
});

    </script>
@endpush
