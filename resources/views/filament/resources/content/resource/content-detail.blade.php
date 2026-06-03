
    <div>
        <style>
            .loader {
                border-top-color: #3498db;
                -webkit-animation: spinner 1.5s linear infinite;
                animation: spinner 1.5s linear infinite;
            }
            @-webkit-keyframes spinner {
                0% {
                    -webkit-transform: rotate(0deg);
                }

                100% {
                    -webkit-transform: rotate(360deg);
                }
            }

            @keyframes spinner {
                0% {
                    transform: rotate(0deg);
                }

                100% {
                    transform: rotate(360deg);
                }
            }
        </style>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <div id="loading-overlay"
             class=" hidden fixed top-0 left-0 right-0 bottom-0 w-full h-screen z-50 overflow-hidden bg-gray-700 opacity-75 flex flex-col items-center justify-center">
            <div class="loader ease-linear rounded-full border-4 border-t-4 border-gray-200 h-12 w-12 mb-4"></div>
            <h2 class="text-center text-white text-xl font-semibold">{{ __('main.loading_overlay_title') }}</h2>
            <p class="w-1/3 text-center text-white">{{ __('main.loading_overlay_description') }}</p>
        </div>
        <div class="flex flex-col gap-6 p-4 bg-white dark:bg-[#1E1E1E] rounded-xl my-4">
            <div class="flex justify-between">
                <a href="{{ url()->previous() }}"
                   class="text-gray-900 dark:bg-gray-950 dark:text-white border-gray-200 font-medium rounded-xl text-center inline-flex items-center" style="max-width: 60%">
                    <svg class="w-5 h-5 text-gray-800 dark:text-white mr-2" aria-hidden="true"
                         xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="m15 19-7-7 7-7" />
                    </svg>
                    <h3 class="text-lg font-semibold text-[#464559] dark:text-white text-left">{{ $content->title }}</h3>
                </a>
{{--                <div class="flex gap-4 items-center">--}}
{{--                    @foreach ($this->getHeaderActions() as $action)--}}
{{--                        {{ $action }}--}}
{{--                    @endforeach--}}
{{--                </div>--}}
                @php
                    $approvedStatuses = [
//                                        \App\Enums\StatusEnumsManagement::APPROVED_BY_PEER_REVIEW->value,
                        \App\Enums\StatusEnumsManagement::APPROVED_BY_ADMIN->value,
                        \App\Enums\StatusEnumsManagement::APPROVED_BY_ASSOCIATION->value,
                    ];
                @endphp
                <div class="flex flex-col">
                    <div class="mt-auto flex justify-end space-x-2 p-4">
                        @if($content->content_type == 'video')
                            <button class="btn-edit bg-blue-500 text-white px-4 py-2 rounded-xl flex items-center justify-center text-sm font-semibold" data-modal-target="default-modal" data-modal-toggle="default-modal"  data-title="{{$content->title}}" data-intro="{{$content->intro}}" data-source="{{ getYoutubeEmbedUrl($content->video_url) }}" data-slug="{{$content->slug}}" data-approval="{{ in_array($content->status, $approvedStatuses) ? 'true' : 'false' }}" data-status=" {{\App\Enums\StatusEnumsManagement::getStatusName($content->status)}}" data-reason="{{$content->reason}}">
                                Edit
                            </button>
                        @endif
                        @if ($content->status == \App\Enums\StatusEnumsManagement::APPROVED_BY_ADMIN->value)
                            <div class="mr-2">
                                <button type="button" wire:click="showApprovalModal"
                                        class="bg-red-600 text-white px-4 py-2 rounded-xl flex items-center justify-center text-sm font-semibold">
                                    {{ __('Reject') }}
                                </button>
                            </div>
                            <div>
                                <button type="button" wire:click="approveContentByExpert"
                                        class="bg-blue-500 text-white px-4 py-2 rounded-xl flex items-center justify-center text-sm font-semibold">
                                    {{ trans('admin/status.approved_by_association') }}
                                </button>
                            </div>
                        @elseif($content->status == \App\Enums\StatusEnumsManagement::REJECTED_BY_ADMIN->value)
                            <div class="mr-2">
                                <button type="button" wire:click="approveContent"
                                        class="bg-blue-500 text-white px-4 py-2 rounded-xl flex items-center justify-center text-sm font-semibold">
                                    {{ __('system.form.button.approve') }}
                                </button>
                            </div>

                        @else
                            <div class="mr-2">
                                <button type="button" wire:click="showApprovalModal"
                                        class="bg-red-600 text-white px-4 py-2 rounded-xl flex items-center justify-center text-sm font-semibold">
                                    {{ __('Reject') }}
                                </button>
                            </div>
                            <div>
                                <button type="button" wire:click="approveContent"
                                        class="bg-blue-500 text-white px-4 py-2 rounded-xl flex items-center justify-center text-sm font-semibold">
                                    {{ __('system.form.button.approve') }}
                                </button>
                            </div>
                        @endif
                    </div>

                </div>


            </div>
            @if($content->reason != '' && $content->status == \App\Enums\StatusEnumsManagement::REJECTED_BY_ADMIN->value)
                <div class="w-full">
                            <span class="dark:text-white font-semibold">
                                Reason for rejection:
                            </span><span class="dark:text-white">
                                 {{$content->reason}}
                            </span>
                </div>
            @endif
            <div id="default-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-60 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full" style="z-index: 110;">
                <div class="relative p-4 w-full max-w-2xl max-h-full">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow dark:bg-[#1E1E1E] dark:border dark:border-white px-4 py-8">
                        <!-- Modal header -->
                        <div class="flex items-center justify-between pb-4 border-b rounded-t">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white modal-title">
                                {{trans('system.information.content_management.video.form_title')}}
                            </h3>
                            <button type="button" class="close-upload-modal text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <form class="flex flex-col gap-6 mt-4 relative" enctype="multipart/form-data" method="post" action="{{route('cgo.informations.content-management.videos.post')}}">
                            <div class="loading hidden h-full w-full opacity-90 z-50 absolute flex items-center justify-center bg-gray-50 dark:bg-gray-800">
                                <div role="status">
                                    <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/></svg>
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                            @csrf
                            <input type="text" name="action" value="edit" class="hidden">
                            <input type="text" name="id" value="" class="hidden">
                            <div>
                                <label for="category" class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{trans('system.information.content_management.video.category')}} <span class="text-red-600">*</span></label>
                                <select id="category" class="bg-white dark:bg-[#1E1E1E] border border-[#EDEDED]  text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:border-white dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="category" required >
                                    <option value="">{{trans('system.information.content_management.video.choose_category')}}</option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="title" class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{trans('system.information.content_management.video.content_name')}} <span class="text-red-600">*</span></label>
                                <input type="text" id="title" class="bg-white dark:bg-[#1E1E1E] border border-[#EDEDED]  text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:border-white dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="title" required />
                            </div>
                            {{--                    <div class="w-full">--}}
                            {{--                        <label for="imageUpload" class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{trans('admin/dashboard.new_letter.thumbnail')}}<span class="text-red-600">*</span></label>--}}

                            {{--                        <input name="thumbnail"--}}
                            {{--                            id="imageUpload"--}}
                            {{--                            type="file"--}}
                            {{--                            accept="image/*"--}}
                            {{--                            class="block w-full text-sm text-gray-500--}}
                            {{--           file:mr-4 file:py-2 file:px-4--}}
                            {{--           file:rounded-full file:border-0--}}
                            {{--           file:text-sm file:font-semibold--}}
                            {{--           file:bg-blue-50 file:text-blue-700--}}
                            {{--           hover:file:bg-blue-100--}}
                            {{--           dark:file:bg-gray-700 dark:file:text-white dark:hover:file:bg-gray-600" required--}}
                            {{--                        >--}}

                            {{--                        <div id="previewContainer" class="mt-4 hidden">--}}
                            {{--                            <p class="text-sm text-gray-600 dark:text-gray-300 mb-2">Preview:</p>--}}
                            {{--                            <img id="previewImage" src="#" alt="Image preview" class="w-auto h-36 rounded shadow text-center" />--}}
                            {{--                        </div>--}}
                            {{--                    </div>--}}
                            <div>
                                <label for="url_video" class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{trans('system.information.content_management.video.url_video')}} <span class="text-red-600">*</span></label>
                                <input type="text" id="url_video" class="bg-white dark:bg-[#1E1E1E] border border-[#EDEDED] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:border-white dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="video_url" required />
                            </div>
                            <div>
                                <label for="introduction" class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{trans('system.information.content_management.video.content_introduction')}} <span class="text-red-600">*</span></label>
                                <textarea id="introduction" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-white dark:bg-[#1E1E1E] rounded-lg border border-[#EDEDED] focus:ring-blue-500 focus:border-blue-500  dark:border-white dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" name="intro" required></textarea>
                            </div>
                            <div class="grid grid-cols-2 gap-6">
                                <button type="button" data-modal-hide="default-modal" class="text-[#9F9FAA] bg-[#EDEDED] hover:bg-gray-600 focus:outline-none  font-medium rounded-full text-sm w-full sm:w-auto px-5 py-2.5 text-center close-upload-modal">{{trans('system.form.button.cancel')}}</button>
                                <button type="submit" class="text-white bg-primary hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    {{trans('system.form.button.submit')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <x-content-details :content="$content" :type="$type" />
            <x-content-comments :content="$content" :type="$type" />
            @if ($showModal)
                <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                    <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full relative">
                        <div class="mb-5 flex items-center justify-center" bis_skin_checked="1">
                            <div class="rounded-full fi-color-custom bg-custom-100 dark:bg-custom-500/20 fi-color-primary p-3" style="--c-100:var(--primary-100);--c-400:var(--primary-400);--c-500:var(--primary-500);--c-600:var(--primary-600);" bis_skin_checked="1">
                                  <svg class="fi-modal-icon h-6 w-6 text-custom-600 dark:text-custom-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"></path>
                                </svg>
                            </div>
                        </div>
                        <p class="text-center mb-4">
                            {{ __('Please write the reason for non-approval') }}</p>
                        <div class="mt-4">
                                <textarea wire:model="additionalComments" placeholder="Please provide additional comments"
                                          class="w-full h-32 p-2 border border-gray-300 rounded rounded-xl" maxlength="255"></textarea>
                        </div>
                        <div class="mt-4 flex">
                            <button type="button" wire:click="closeModal"
                                    class="bg-white text-gray-700 border mr-2 px-4 py-2 rounded rounded-xl w-1/2 text-sm font-semibold text-center">
                                {{ __('Cancel') }}
                            </button>
                            <button type="button" wire:click="rejectContent"
                                    class="bg-primary text-white px-4 py-2 rounded rounded-xl w-1/2 text-sm font-semibold text-center">
                                {{ __('Confirm') }}
                            </button>
                        </div>


                    </div>
                </div>
            @endif
        </div>

        <script>
            function toggleLoadingOverlay() {
                const loadingOverlay = document.getElementById('loading-overlay');
                if (loadingOverlay.classList.contains('hidden')) {
                    loadingOverlay.classList.remove('hidden');
                } else {
                    loadingOverlay.classList.add('hidden');
                }
            }

            @if($content->content_type == 'video')
            $(".btn-edit").click(function () {
                $("#default-modal form>.loading").removeClass('hidden');
                $("#default-modal .modal-title").html('Edit content');
                let slug = $(this).attr('data-slug');
                $.ajax({
                    type:'GET',
                    url:'/cgo/informations/content-management/videos/show/'+ slug,
                    success:function(data) {
                        $("#default-modal form input[name='action']").val('edit');
                        $("#default-modal form input[name='id']").attr('value', data.data.id)
                        $("#default-modal form input[name='title']").val(data.data.title);
                        $("#default-modal form input[name='video_url']").val(data.data.video_url);
                        $("#default-modal form textarea[name='intro']").text(data.data.intro);
                        $("#default-modal form select[name='category']").val(data.data.category_id);
                        $("#previewContainer").removeClass('hidden');
                        $("#default-modal #previewImage").attr('src', data.data.thumbnail);
                        $("#imageUpload").removeAttr('required');
                        $("#default-modal form>.loading").addClass('hidden');
                    }
                });
            });
            @endif
        </script>

    </div>
