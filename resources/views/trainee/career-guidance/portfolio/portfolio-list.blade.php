@extends('homepage.layouts.master')
@section('title', 'Portfolio')
@section('content')
{{--    <p class="text-2xl mt-4 text-[#464559] font-semibold dark:text-white">Portfolio</p>--}}
    <div class="py-6">
        <x-breadcrumb :items="[
                ['label' =>__('system.menu.home'), 'url' => route('homepage')],
                ['label' => __('cgo.menu.career_guidance.root'), 'url' => '#'],
                ['label' => __('trainee.menu.career_guidance.portfolio.portfolio'), 'url' => '#']
            ]" />
    </div>
    <div class="flex flex-col gap-4 md:gap-6 mb-6 bg-white dark:bg-[#1E1E1E] rounded-xl shadow-custom-light shadow-custom-dark p-4 min-h-72 justify-between">
        @if(session()->has('success'))
            <div class="alert alert-success text-green-600 dark:text-white font-semibold bg-green-200 px-4 py-2 rounded-xl">
                {{ session()->get('success') }}
            </div>
        @endif
        @if($errors->any())
            {!! implode('', $errors->all('<div class="alert alert-danger text-red-600 dark:text-red font-semibold bg-red-200 px-4 py-2 rounded-xl">:message</div>')) !!}
        @endif
        <div class="flex flex-col gap-4">
            @forelse($portfolios as $key => $portfolio)
                <div class="flex gap-2 shadow-custom-light dark:shadow-custom-dark py-2 rounded-xl items-center dark:border-white border border-gray-300 px-4">
                    <img src="{{asset('images/profile.png')}}" class="w-20" alt="Portfolio">
                    <div class="flex flex-col gap-2 w-full">
                        @if($user->public_portfolio == 1)
                        <span class="bg-primary text-white text-xs font-medium px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 w-fit">{{ trans('general.Allow others to view') }}</span>
                        @endif
                        <a href="{{route('trainee.career-guidance.portfolio.preview-portfolio', ['pid' => $portfolio->id])}}" target="_blank" class="text-sm md:text-base text-[#201F36] dark:text-white font-semibold">{{ trans('general.My Portfolio')}}</a>
                        <div class="flex flex-col md:flex-row gap-4 justify-between w-full">
                            <span class="text-xs md:text-sm text-[#91919A] dark:text-white">{{ trans('general.Updated')}}: {{date('Y-m-d H:i:s', strtotime($portfolio->updated_at))}}</span>
                            <div class="flex justify-end gap-4">
                                <a href="{{route('trainee.career-guidance.portfolio.export-portfolio', ['pid' => $portfolio->id])}}" target="_blank" class="text-primary text-xs md:text-sm flex items-center gap-1 hover:underline"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                    </svg>
                                      PDF </a>
                                <a href="{{route('trainee.career-guidance.portfolio.preview-portfolio', ['pid' => $portfolio->id, 'lang' => app()->getLocale() ?? 'en'])}}" target="_blank" class="text-primary text-xs md:text-sm flex items-center gap-1 hover:underline"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg> {{ trans('general.View')}} </a>
                                <a href="{{route('trainee.career-guidance.portfolios.edit')}}" target="_blank" class="text-primary text-xs md:text-sm flex items-center gap-1 hover:underline"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                     {{trans('system.form.button.edit')}}</a>
                                <button data-modal-target="delete-modal" data-modal-toggle="delete-modal" data-portfolio-id="{{$portfolio->id}}" class="text-red-600 text-xs md:text-sm flex items-center gap-1 btn-delete"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg> {{ trans('general.Delete')}}
                                </button>
                            </div>

                        </div>
                    </div>

                </div>
            @empty
                <div class="flex flex-col gap-4 justify-center items-center">
                    <img src="{{asset('/images/empty-box.png')}}" class="opacity-50 h-32" alt="Empty">
                    <p class="dark:text-white"> {{ trans("general.You haven't had any Portfolio")}}</p>
                    <div class="flex flex-col lg:flex-row lg:justify-between gap-4">
                        <a href="{{route('trainee.career-guidance.portfolios.create')}}" target="_blank" class="text-white w-full xl:w-fit bg-[#4984F6] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-full
     px-3 py-3 md:px-12 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 md:text-xl font-medium">{{ trans("general.Create a new Portfolio")}}
                        </a>
                    </div>
                </div>
            @endforelse
                <div>
                    <i class="dark:text-white text-sm">{{trans('general.A well-prepared portfolio helps you track your growth and demonstrates your expertise to potential employers.')}}</i>
                </div>
        </div>
{{--        @if(count($portfolios) > 0)--}}
{{--            {{$portfolios->onEachSide(1)->links()}}--}}
{{--        @endif--}}
    </div>

    <div id="delete-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-[#1E1E1E] dark:border dark:border-white px-4 py-8">
                <!-- Modal header -->
                <div class="flex items-center justify-between pb-4 border-b rounded-t">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white text-center">
                        {{trans('system.delete_modal.title')}}
                    </h3>
                    <button type="button" class="close-modal text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="delete-modal">
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
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400 text-center">{{trans('system.delete_modal.content')}}</h3>
                    <div class="flex justify-center gap-4">
                        <a href="" class="confirm-delete text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                            {{trans('system.delete_modal.yes')}}
                        </a>
                        <button data-modal-hide="delete-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">{{trans('system.delete_modal.no')}}</button>
                    </div>

                </div>
            </div>
        </div>
    </div>

@stop
@push('js')
    <script>
        $(document).ready(function () {
            $(".btn-delete").click(function (e) {
                e.preventDefault();
                $(".confirm-delete").attr('href', '');
                let id = $(this).attr('data-portfolio-id');
                let url = '/trainee/career-guidance/portfolio/delete-portfolio?pid='+id;
                $(".confirm-delete").attr('href', url);
            });
        });
    </script>
@endpush
