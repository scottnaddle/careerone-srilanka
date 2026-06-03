@if(!$peerItem->hasUserResponded(Auth::guard('cgo')->id()))
    <div class="flex flex-col gap-6 p-4 bg-white dark:bg-[#1E1E1E] rounded-xl">
    <div class="flex flex-col lg:flex-row py-4 rounded-xl border border-[#D4D4D4] dark:border-white divide-x">
        <div class="w-full lg:w-1/3 px-4">
            <p class="dark:text-white text-lg font-semibold">{{trans('general.Rating Scale')}}</p>
            <ul class="list-disc list-inside dark:text-white">
                <li class="dark:text-white text-[#464559]">
                    {{trans('general.Totally not meet the Standards')}}: 0
                </li>
                <li class="dark:text-white text-[#464559]">
                    {{trans('general.Not meet the standards')}}: 2.5
                </li>
                <li class="dark:text-white text-[#464559]">
                    {{trans('general.Fair')}}: 5
                </li>
                <li class="dark:text-white text-[#464559]">
                    {{trans('general.Good')}}: 7.5
                </li>
                <li class="dark:text-white text-[#464559]">
                    {{trans('general.Excellent')}}: 10
                </li>
            </ul>
            <p class="text-red-600">** {{trans('general.If you selected "totally not meet the standards" or "not meet the standards", write a reason.')}}</p>
        </div>
        <div class="w-full lg:w-2/3 px-4">
            <p class="dark:text-white text-lg font-semibold">{{trans('general.Content Evaluation Results Criteria')}}</p>
            <ul class="list-disc list-inside dark:text-white">
                <li class="dark:text-white text-[#464559]">
                    {{trans('general.50 points or less: Rework content')}}
                </li>
                <li class="dark:text-white text-[#464559]">
                    {{trans('general.Less than 75 points: Based on the evaluator’s opinion, revise the content (request additional CGO review)')}}
                </li>
                <li class="dark:text-white text-[#464559]">
                    {{trans('general.If 75 points or more: Publish the content')}}
                </li>
            </ul>
        </div>
    </div>
    <div class="flex gap-4 flex-col">
        @php
            $language = app()->getLocale() ?? 'en';
        @endphp
        <div>
            <form class="flex flex-col gap-4 px-4" action="{{route('cgo.informations.content-management.peer-review.submitResponse')}}" method="post">
                @csrf
                <input type="text" class="hidden" value="{{$peerItem->id}}" name="peer_id">
                @foreach($questionList[$language] as $topicId => $question)
                    <p class="font-semibold text-lg dark:text-white">{{$question['topic']}}</p>
                    @foreach($question['q'] as $questionId =>  $q)
                        <div class="flex flex-col gap-2">
                            <p class="dark:text-white text-[#201F36]">{{$questionId+1}}. {{$q}}</p>
                            <div class="flex gap-6 lg:gap-16 items-center">
                                <div class="flex items-center flex-col">
                                    <label for="radio-{{$topicId}}-{{$questionId}}-0" class=" text-sm font-medium text-[#706F81] dark:text-white">0</label>
                                    <input id="radio-{{$topicId}}-{{$questionId}}-0" type="radio" value="0" name="{{$topicId}}-{{$questionId}}" class="w-4 h-4 text-blue-600 bg-white border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" required>
                                </div>
                                <div class="flex items-center flex-col">
                                    <label for="radio-{{$topicId}}-{{$questionId}}-1" class=" text-sm font-medium text-[#706F81] dark:text-white">2.5</label>
                                    <input id="radio-{{$topicId}}-{{$questionId}}-1" type="radio" value="2.5" name="{{$topicId}}-{{$questionId}}" class="w-4 h-4 text-blue-600 bg-white border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" required>
                                </div>
                                <div class="flex items-center flex-col">
                                    <label for="radio-{{$topicId}}-{{$questionId}}-2" class=" text-sm font-medium text-[#706F81] dark:text-white">5</label>
                                    <input id="radio-{{$topicId}}-{{$questionId}}-2" type="radio" value="5" name="{{$topicId}}-{{$questionId}}" class="w-4 h-4 text-blue-600 bg-white border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" required>
                                </div>
                                <div class="flex items-center flex-col">
                                    <label for="radio-{{$topicId}}-{{$questionId}}-3" class=" text-sm font-medium text-[#706F81] dark:text-white">7.5</label>
                                    <input id="radio-{{$topicId}}-{{$questionId}}-3" type="radio" value="7.5" name="{{$topicId}}-{{$questionId}}" class="w-4 h-4 text-blue-600 bg-white border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" required>
                                </div>
                                <div class="flex items-center flex-col">
                                    <label for="radio-{{$topicId}}-{{$questionId}}-4" class=" text-sm font-medium text-[#706F81] dark:text-white">10</label>
                                    <input id="radio-{{$topicId}}-{{$questionId}}-4" type="radio" value="10" name="{{$topicId}}-{{$questionId}}" class="w-4 h-4 text-blue-600 bg-white border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" required>
                                </div>
                            </div>
                            <div>
                                            <textarea
                                                name="reason-{{$topicId}}-{{$questionId}}"
                                                data-topic-id="{{$topicId}}"
                                                data-question-id="{{$questionId}}"
                                                class="reason-textarea block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                style="display: none" rows="4"
                                                placeholder="Write the reason..."></textarea>
                            </div>
                        </div>
                    @endforeach
                @endforeach
                <div class="flex justify-end w-full mt-4">
                    <button type="submit"
                            class="w-fit text-white bg-[#4984F6] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-full
                            text-base px-12 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">{{ __('system.form.button.submit') }}</button>
                </div>
            </form>
        </div>

    </div>
</div>
@else
    <div class="flex flex-col lg:flex-row py-4 rounded-xl border border-[#D4D4D4] dark:border-white divide-x">
        <div class="w-full lg:w-1/3 px-4">
            <p class="dark:text-white text-lg font-semibold text-center">{{trans('general.Your Rating Scale')}}</p>
            <p class="text-center py-6">
                <span class="border border-[#D4D4D4] dark:border-white rounded-full px-4 py-2.5 text-5xl font-semibold text-primary dark:text-white">{{$peerItem->getCurrentUserResult()['result']}}</span>
                </p>
        </div>
        <div class="w-full lg:w-2/3 px-4">
            <p class="dark:text-white text-lg font-semibold">{{trans('general.Your Comment')}}</p>
            <ul class="list-disc list-inside dark:text-white">
                @php
                    $details = $peerItem->getCurrentUserResult()['details'];
                    $details = json_decode($details, true);
                @endphp
                @if (is_array($details))
                    @foreach($details as $key => $value)

                        @if(\Str::startsWith($key, 'reason-') && !empty($value))
                            <li class="dark:text-white text-[#464559]">
                                {{ $value }}
                            </li>
                        @endif
                    @endforeach
                @else
                    No comment
                @endif

            </ul>
        </div>
    </div>
@endif
