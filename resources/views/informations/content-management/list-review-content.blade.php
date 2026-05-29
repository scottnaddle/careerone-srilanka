@extends('homepage.layouts.master')
@section('title', 'Information - Content management - List Review Content')

@section('content')
    <div class="pt-6 min-h-screen">
        <div class="bg-white rounded-xl shadow p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Content waiting list</h2>
                <div>
                    <select class="px-4 py-2 border rounded-lg text-sm text-gray-600">
                        <option>Status</option>
                    </select>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left text-gray-600">
                    <thead class="bg-[#F5F7FA] dark:bg-[#282828] dark:text-white text-center shadow-md">
                        <tr>
                            <th class="px-4 py-3 text-primary dark:text-white font-semibold text-base whitespace-nowrap">
                                Title</th>
                            <th class="px-4 py-3 text-primary dark:text-white font-semibold text-base whitespace-nowrap">
                                Category</th>
                            <th class="px-4 py-3 text-primary dark:text-white font-semibold text-base whitespace-nowrap">
                                Content type</th>
                            <th class="px-4 py-3 text-primary dark:text-white font-semibold text-base whitespace-nowrap">
                                Request date</th>
                            <th class="px-4 py-3 text-primary dark:text-white font-semibold text-base whitespace-nowrap">
                                Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Row -->
                        @foreach ($contentNotApprovsal as $val)
                            <tr
                                class="bg-white dark:bg-[#1E1E1E] border-b border-[#F8F8F8] dark:border-gray-700 text-center hover:bg-blue-100 dark:hover:bg-gray-700">
                                <td scope="row" class="px-4 py-6 font-semibold text-sm  w-1/6 text-left">
                                   <a href="{{route('cgo.informations.content-management.content-detail',$val)}}">{{ $val->title }}</a>
                                </td>
                                <td class="px-4 py-6 font-semibold text-sm  w-1/6">{{ $val->content_type }}</td>
                                <td class="px-4 py-6 font-semibold text-sm  w-1/6">{{ $val->content_type }}</td>
                                <td class="px-4 py-6 font-semibold text-sm  w-1/6">{{ $val->created_at }}</td>
                                <td class="px-4 py-6 font-semibold text-sm  w-1/6">
                                    @if ($val->status == \App\Enums\StatusEnumsManagement::APPROVED->value)
                                        <span
                                            class="inline-flex items-center px-3 py-1 min-w-[100px] rounded-lg text-sm font-medium bg-[#E9F5FF] text-[#4984F6]">
                                            ● Approved
                                        </span>
                                    @elseif($val->status == \App\Enums\StatusEnumsManagement::NON_APPROVAL->value)
                                        <span
                                            class="inline-flex items-center px-3 py-1 min-w-[100px] rounded-lg text-sm font-medium bg-red-100 text-red-600">
                                            ● Reject
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-3 py-1 w-[100px] rounded-lg text-sm font-medium bg-gray-200 text-gray-700">
                                            ● Request
                                        </span>
                                    @endif

                                </td>
                            </tr>
                        @endforeach


                        <!-- Add more rows below as needed -->
                        {{-- <tr class="bg-white dark:bg-[#1E1E1E] border-b border-[#F8F8F8] dark:border-gray-700 text-center hover:bg-blue-100 dark:hover:bg-gray-700">
              <td class="px-4 py-3">How to Write a Standout Resume and Cover Letter in 2025</td>
              <td class="px-4 py-3">Resume/Cover Letter Writing Tips</td>
              <td class="px-4 py-3">Document</td>
              <td class="px-4 py-3">2025-04-28</td>
              <td class="px-4 py-3">
                <span class="inline-flex items-center px-3 py-1 min-w-[100px] rounded-lg text-sm font-medium bg-red-100 text-red-600">
                  ● Reject
                </span>
              </td>
            </tr>

            <tr class="bg-white dark:bg-[#1E1E1E] border-b border-[#F8F8F8] dark:border-gray-700 text-center hover:bg-blue-100 dark:hover:bg-gray-700">
              <td class="px-4 py-3">How to Write a Standout Resume and Cover Letter in 2025</td>
              <td class="px-4 py-3">Resume/Cover Letter Writing Tips</td>
              <td class="px-4 py-3">Document</td>
              <td class="px-4 py-3">2025-04-28</td>
              <td class="px-4 py-3">
                <span class="inline-flex items-center px-3 py-1 w-[100px] rounded-lg text-sm font-medium bg-gray-200 text-gray-700">
                  ● Request
                </span>
              </td>
            </tr> --}}
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="pt-6">{{ $contentNotApprovsal->appends(request()->query())->onEachSide(1)->links() }}</div>

        </div>
    </div>


@endsection
@push('js')
@endpush
@push('css')
    <style>
        .custom-background-title {
            border-radius: 8px;
            background-color: #FFF;
        }
    </style>
@endpush
