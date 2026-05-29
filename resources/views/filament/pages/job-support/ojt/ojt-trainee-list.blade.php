<div class="mb-6 flex flex-col">
    <p class="text-2xl text-[#464559] dark:text-white font-semibold"></p>
    <div class="py-6">
        <x-breadcrumb :items="[
            ['label' => 'Admin', 'url' =>'/admin/overview'],
            ['label' => 'Job Support', 'url' => '#'],
            ['label' => 'OJT List', 'url' => '/admin/o-j-t-s'],
            ['label' => 'Candidate list', 'url' => '#'],
        ]" />
    </div>

    <div class="bg-white dark:bg-[#1E1E1E] rounded-xl px-4 py-5 flex flex-col gap-5">
        <form method="get" action="{{ url()->current() }}">
            <div class="flex gap-4 flex-row">
                <div class="w-full flex gap-4">
                    <div class="flex items-center gap-4 w-full">
                        <input type="text" name="search"
                               class="flex-grow px-4 py-2 border border-gray-300 rounded-lg text-[#91919A] font-medium"
                               value="{{ request()->query('search') }}" placeholder="{{ __('general.Trainee name') }}">
                    </div>
                </div>
                <div class="w-fit"><button type="submit"
                                           class="flex-1 px-4 py-2 bg-blue-500 text-white rounded-full">Search</button></div>

            </div>
        </form>
        <div class="flex flex-col gap-4">
            <div class="flex flex-col gap-5 dark:divide-white">
                @forelse ($this->ojtData->applyData as $apply)
                    <div
                        class="flex gap-5 lg:flex-row justify-between lg:px-5 py-2 md:py-3 trainee-apply border-b border-[#F8F8F8] hover:bg-blue-100 dark:hover:bg-gray-700 rounded-xl">
                        <div class="flex gap-6 items-center">
                            @if ($apply->traineeMatched?->profile_image)
                                <img class="w-16 h-16 rounded-full"
                                    src="{{ asset($apply->traineeMatched?->profile_image) }}" alt="user photo">
                            @else
                                <img class="w-16 h-16 rounded-full" src="{{ asset('images/user-default.svg') }}"
                                    alt="user photo">
                            @endif
                            <div class="flex flex-col gap-1">
                                <p class="flex gap-3 items-center flex-wrap dark:text-white">


                                <a href="{{ route('filament.admin.resources.trainees.view', ['record' => $apply->traineeMatched]) }}"
                                    class="ajax-call open-cv text-primary font-semibold hover:text-blue-700 dark:hover:text-white">
                                    {{ $apply->traineeMatched?->fullName }}
                                </a>
                                    |
                                        <span class="text-sm px-2.5 py-1 rounded shadow-xs text-white bg-primary">
                                                    {{ \App\Enums\TypeTraineeApply::getNameByKey($apply->apply_type) }}
                                            @if($apply->apply_type == 'ojt_match')
                                                {{ getCGOName($apply->traineeMatched?->id, $this->ojt->id, 'ojt') }} @endif
                                                </span>

{{--                                    <span class="text-[#464559] dark:text-white">|</span>--}}
{{--                                    <span--}}
{{--                                        class="text-[#464559] dark:text-white">{{ \Carbon\Carbon::parse($apply->traineeMatched->created_at)->diffForHumans() }}</span>--}}
                                    {{--                                        @foreach ($apply->apply_types as $apply_type) --}}
                                    {{--                                            <span class="text-sm px-2.5 py-1 rounded shadow-xs text-white {{ $apply_type == 'apply' ? 'bg-blue-800' : 'bg-primary' }}"> --}}
                                    {{--                                            {{ \App\Enums\TypeTraineeApply::getNameByKey($apply_type) }} --}}
                                    {{--                                        </span> --}}
                                    {{--                                        @endforeach --}}

                                </p>
                                <p class="text-[#706F81]  gap-3 dark:text-white flex flex-wrap">
                                    {!! getNewestTrainingInformationOfTrainee($apply->traineeMatched->id) !!}
                                </p>
{{--                                <p class="text-sm text-[#706F81] dark:text-white">--}}
{{--                                    @if (optional($this->ojt)->id)--}}
{{--                                        Updated {{ $apply->traineeMatched->updated_at->diffForHumans() }}--}}
{{--                                    @else--}}
{{--                                        ojt Title: {{ $apply->ojt->title }}--}}
{{--                                    @endif--}}

{{--                                </p>--}}
                            </div>
                        </div>
                        <div class="flex flex-col gap-6 items-end">
{{--                            @if($apply->apply_type == 'ojt_match') Matched -  @endif--}}
{{--                            @if($apply->apply_type == 'apply') Applied -  @endif--}}
                            <span
                                class="text-sm text-primary flex gap-1 items-center font-semibold read-cv {{ empty($apply->read) ? 'hidden' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="17"
                                    viewBox="0 0 16 17" fill="none">
                                    <path
                                        d="M4.66665 8.50008L7.99998 11.8334L14.6666 5.16675M1.33331 8.50008L4.66665 11.8334M7.99998 8.50008L11.3333 5.16675"
                                        stroke="#4984F6" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                                Read
                            </span>
                            <div class="flex gap-2">
                                <span
                                    class="text-sm text-primary px-2 py-1 bg-[#E9F5FF] rounded-xl font-semibold  {{ empty($apply->selected) || !empty($apply->employeed) ? 'hidden' : '' }} selected-cv">Selected</span>
                                <span
                                    class="text-sm text-primary px-2 py-1 bg-[#E9F5FF] rounded-xl font-semibold  {{ empty($apply->employeed) ? 'hidden' : '' }} employeed-trainee">Employeed</span>
                            </div>
                        </div>
                    </div>
                    @empty
                        <div class="flex flex-col gap-4 justify-center items-center p-4">
                            <img src="{{ asset('/images/empty-box.png') }}" class="opacity-50 h-32" alt="Empty">
                            <p class="dark:text-white">{{ trans('cgo.job_support.company_list.no_record') }}</p>
                        </div>
                    @endforelse

            </div>
            <div class="mt-6">
                {{ $this->ojtData->applyData->onEachSide(1)->links() }}
            </div>
        </div>

    </div>
</div>
