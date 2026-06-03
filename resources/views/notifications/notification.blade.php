@extends('homepage.layouts.master')
@section('title', 'Notification')
@push('css')
    <style>
        .nav-tab-title h1 {
            color: #464559;
            text-align: right;

            /* 30px/Semibold */
            font-family: Poppins;
            font-size: 30px;
            font-style: normal;
            font-weight: 600;
            line-height: 36px;
            /* 120% */
        }

        .tab-container {
            display: flex;
            padding: 20px 16px 48px 16px;
            flex-direction: column;
            gap: 24px;
            border-radius: 8px;
            background: #FFF;
            overflow: hidden;
        }

        /* css for tab switcher */

        .tab-switch {
            position: relative;
        }

        .tab-switch:after {
            content: "";
            position: absolute;
            width: 50%;
            top: 0;
            transition: left cubic-bezier(0.18, 1.14, 0.5, 1.18) 0.5s;
            border-radius: 10px;
            box-shadow: 0 2px 15px 0 rgba(0, 0, 0, .1);
            background-color: #4984F6;
            height: 100%;
            z-index: 0;
        }

        .tab-switch.left:after {
            left: 0;
        }

        .tab-switch.right:after {
            left: 50%;
        }
    </style>
@endpush
@section('content')
    <div class="flex flex-col gap-9 mt-6">
        <div class="flex nav-tab-title dark:text-white"></div>
        <div
            class="tab-container card mb-2 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <div class="tab_reel">
                <div class="tab_panel_notice">
                    <div
                        class="bg-white dark:bg-[#1E1E1E] shadow-custom-light dark:shadow-custom-dark rounded-xl gap-6 flex flex-col">
                        <div class="relative overflow-x-auto">
                            <table class="w-full text-left rtl:text-right table-auto">
                                <thead class="bg-[#F5F7FA] dark:bg-[#282828] dark:text-white text-center">
                                    <tr>
                                        <th scope="col"
                                            class="px-2 md:px-4 py-1 md:py-2.5 text-primary dark:text-white font-semibold text-base">
                                            {{ __('cgo.no_dot') }}
                                        </th>
                                        <th scope="col"
                                            class="px-2 md:px-4 py-1 md:py-2.5 text-primary dark:text-white font-semibold text-base">
                                            {{ trans('system.notifications') }}
                                        </th>
                                        <th scope="col"
                                            class="px-2 md:px-4 py-1 md:py-2.5 text-primary dark:text-white font-semibold text-base">
                                            {{ __('Time') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($paginatedNotifications as $index => $notification)
                                    @php
                                        $isRead = $notification->read_at !== null;
                                        $url = $notification->data['message']['href'] ?? '#';

                                        $messageKey = $notification->data['message']['key'] ??  $notification->data['message']['message'];
                                        $messageParams = $notification->data['message']['params'] ?? [];

                                        $translatedMessage = __($messageKey, $messageParams);
                                    @endphp
                                    <tr class="dark:bg-[#1E1E1E] border-b border-[#F8F8F8] dark:border-gray-700 text-center
                                        {{ $isRead ? 'bg-white' : 'bg-gray-100 dark:bg-gray-800' }}" onclick="markAsRead(this, '{{ $notification->id }}')">
                                        <td class="px-2 md:px-4 text-sm text-[#464559] dark:text-white">
                                            {{ ($paginatedNotifications->currentPage() - 1) * $paginatedNotifications->perPage() + $index + 1 }}
                                        </td>
                                        <td align="left" class="px-2 md:px-4 text-sm text-[#464559] dark:text-white">
                                            <a href="{{ $url }}" class="block w-full h-full">
                                                <div class="flex items-center py-1 md:py-3 px-2 md:px-4">
                                                    <div class="flex-shrink-0">
                                                        {!! $notification->data['message']['icon'] ?? '' !!}
                                                    </div>
                                                    <div class="w-full ps-3">
                                                        <div class="text-gray-500 text-sm mb-1.5 dark:text-white">
                                                            {{ $translatedMessage }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </td>
                                        <td align="left" class="px-2 md:px-4 text-sm text-[#201F36] max-w-80 dark:text-white whitespace-nowrap overflow-hidden text-ellipsis">
                                            {{ \Carbon\Carbon::parse($notification->created_at)->locale(App::getLocale())->diffForHumans() }}
                                        </td>
                                    </tr>
                                @endforeach


                                </tbody>
                            </table>

                        </div>
                    </div>
                    <div class=" mt-3">
                        {{ $paginatedNotifications->links() }}
                    </div>
                </div>
            </div>
        </div>


    </div>

@endsection

@push('js')
@endpush
