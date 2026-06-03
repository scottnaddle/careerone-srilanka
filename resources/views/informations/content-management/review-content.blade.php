@extends('homepage.layouts.master')
@section('title', 'Information - Content management - Document')

@section('content')

    <body class="bg-gray-100 font-sans">
        <div class="mx-auto bg-white shadow-md rounded-lg overflow-hidden my-8">
            <div class="p-6">
                <!-- Header with back button -->
                <div class="flex items-center mb-6">
                    <button class="text-gray-600 mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <h1 class="text-lg font-medium text-gray-800">Digital Content Quality Assessment Checklist for Peer
                        Review of CCOs</h1>
                </div>

                <div class="flex flex-col md:flex-row gap-6 p-4 border rounded-lg bg-white shadow text-sm mb-4">

                    <div class="md:w-1/3">
                        <h2 class="font-semibold text-gray-800 mb-2">Rating Scale</h2>
                        <ul class="text-gray-700 space-y-1 border-r border-gray-300 pr-4">
                            <li>• Totally not meet the standards: 0</li>
                            <li>• Not rate the standard: 2.5</li>
                            <li>• Fair: 5</li>
                            <li>• Good: 7.5</li>
                            <li>• Excellent: 10</li>
                        </ul>
                        <p class="text-red-500 mt-2 text-xs">
                            ** When selecting "Very Poor" or "Poor", write a reason
                        </p>
                    </div>

                    <div class="md:w-1/2 ">
                        <h2 class="font-semibold text-gray-800 mb-2">Content Evaluation Results Criteria</h2>
                        <ul class="text-gray-700 space-y-1 ">
                            <li>• 50 points or less: Rework content</li>
                            <li>• 75 points or less: Re-register after supplementing the content for the evaluation opinion
                                (request additional CGO review)</li>
                            <li>• More than 75 points: Content publishing</li>
                        </ul>
                    </div>
                </div>

                <form>
                    <div class="mb-8">
                        <h2 class="text-base font-semibold text-gray-800 mb-4">1. Content Quality</h2>
                        <div class="mb-6" id="accuracy">
                            <p class="text-sm text-gray-700 mb-2">1. Accuracy: Does it reflect the latest information?</p>
                            <div class="flex items-center justify-between max-w-md">
                                <div class="flex flex-col items-center">
                                    <span class="text-xs text-gray-500 mb-1">0</span>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="accuracy" value="0" class="w-4 h-4 text-blue-600">
                                    </label>
                                </div>
                                <div class="flex flex-col items-center">
                                    <span class="text-xs text-gray-500 mb-1">2.5</span>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="accuracy" value="2.5" class="w-4 h-4 text-blue-600">
                                    </label>
                                </div>
                                <div class="flex flex-col items-center">
                                    <span class="text-xs text-gray-500 mb-1">5</span>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="accuracy" value="5" class="w-4 h-4 text-blue-600">
                                    </label>
                                </div>
                                <div class="flex flex-col items-center">
                                    <span class="text-xs text-gray-500 mb-1">7.5</span>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="accuracy" value="7.5" class="w-4 h-4 text-blue-600"
                                            checked>
                                    </label>
                                </div>
                                <div class="flex flex-col items-center">
                                    <span class="text-xs text-gray-500 mb-1">10</span>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="accuracy" value="10" class="w-4 h-4 text-blue-600">
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-6" id="credibility">
                            <p class="text-sm text-gray-700 mb-2">2. Credibility: Are the sources clear and credible?</p>
                            <div class="flex items-center justify-between max-w-md">
                                <div class="flex flex-col items-center">
                                    <span class="text-xs text-gray-500 mb-1">0</span>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="credibility" value="0"
                                            class="w-4 h-4 text-blue-600">
                                    </label>
                                </div>
                                <div class="flex flex-col items-center">
                                    <span class="text-xs text-gray-500 mb-1">2.5</span>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="credibility" value="2.5"
                                            class="w-4 h-4 text-blue-600" checked>
                                    </label>
                                </div>
                                <div class="flex flex-col items-center">
                                    <span class="text-xs text-gray-500 mb-1">5</span>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="credibility" value="5"
                                            class="w-4 h-4 text-blue-600">
                                    </label>
                                </div>
                                <div class="flex flex-col items-center">
                                    <span class="text-xs text-gray-500 mb-1">7.5</span>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="credibility" value="7.5"
                                            class="w-4 h-4 text-blue-600">
                                    </label>
                                </div>
                                <div class="flex flex-col items-center">
                                    <span class="text-xs text-gray-500 mb-1">10</span>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="credibility" value="10"
                                            class="w-4 h-4 text-blue-600">
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-6" id="coherence">
                            <p class="text-sm text-gray-700 mb-2">3. Coherence: Is the content logically connected and has
                                a consistent flow?</p>
                            <div class="flex items-center justify-between max-w-md">
                                <div class="flex flex-col items-center">
                                    <span class="text-xs text-gray-500 mb-1">0</span>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="coherence" value="0"
                                            class="w-4 h-4 text-blue-600">
                                    </label>
                                </div>
                                <div class="flex flex-col items-center">
                                    <span class="text-xs text-gray-500 mb-1">2.5</span>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="coherence" value="2.5"
                                            class="w-4 h-4 text-blue-600">
                                    </label>
                                </div>
                                <div class="flex flex-col items-center">
                                    <span class="text-xs text-gray-500 mb-1">5</span>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="coherence" value="5"
                                            class="w-4 h-4 text-blue-600">
                                    </label>
                                </div>
                                <div class="flex flex-col items-center">
                                    <span class="text-xs text-gray-500 mb-1">7.5</span>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="coherence" value="7.5"
                                            class="w-4 h-4 text-blue-600">
                                    </label>
                                </div>
                                <div class="flex flex-col items-center">
                                    <span class="text-xs text-gray-500 mb-1">10</span>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="coherence" value="10"
                                            class="w-4 h-4 text-blue-600">
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-6" id="clarity">
                            <p class="text-sm text-gray-700 mb-2">3. Clarity & Readability: Is it written in clear, concise
                                sentences that are easy to understand?</p>
                            <div class="flex items-center justify-between max-w-md">
                                <div class="flex flex-col items-center">
                                    <span class="text-xs text-gray-500 mb-1">0</span>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="clarity" value="0"
                                            class="w-4 h-4 text-blue-600">
                                    </label>
                                </div>
                                <div class="flex flex-col items-center">
                                    <span class="text-xs text-gray-500 mb-1">2.5</span>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="clarity" value="2.5"
                                            class="w-4 h-4 text-blue-600">
                                    </label>
                                </div>
                                <div class="flex flex-col items-center">
                                    <span class="text-xs text-gray-500 mb-1">5</span>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="clarity" value="5"
                                            class="w-4 h-4 text-blue-600">
                                    </label>
                                </div>
                                <div class="flex flex-col items-center">
                                    <span class="text-xs text-gray-500 mb-1">7.5</span>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="clarity" value="7.5"
                                            class="w-4 h-4 text-blue-600">
                                    </label>
                                </div>
                                <div class="flex flex-col items-center">
                                    <span class="text-xs text-gray-500 mb-1">10</span>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="clarity" value="10"
                                            class="w-4 h-4 text-blue-600">
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-8">
                        <h2 class="text-base font-semibold text-gray-800 mb-4">2. Design & UI/UX</h2>

                        <div class="mb-6" id="layout">
                            <p class="text-sm text-gray-700 mb-2">1. Layout: Are the components organized and readable?</p>
                            <div class="flex items-center justify-between max-w-md">
                                <div class="flex flex-col items-center">
                                    <span class="text-xs text-gray-500 mb-1">0</span>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="layout" value="0"
                                            class="w-4 h-4 text-blue-600">
                                    </label>
                                </div>
                                <div class="flex flex-col items-center">
                                    <span class="text-xs text-gray-500 mb-1">2.5</span>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="layout" value="2.5"
                                            class="w-4 h-4 text-blue-600">
                                    </label>
                                </div>
                                <div class="flex flex-col items-center">
                                    <span class="text-xs text-gray-500 mb-1">5</span>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="layout" value="5"
                                            class="w-4 h-4 text-blue-600">
                                    </label>
                                </div>
                                <div class="flex flex-col items-center">
                                    <span class="text-xs text-gray-500 mb-1">7.5</span>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="layout" value="7.5"
                                            class="w-4 h-4 text-blue-600">
                                    </label>
                                </div>
                                <div class="flex flex-col items-center">
                                    <span class="text-xs text-gray-500 mb-1">10</span>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="layout" value="10"
                                            class="w-4 h-4 text-blue-600">
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-6" id="visual">
                            <p class="text-sm text-gray-700 mb-2">2. Visual elements: Are colors, images, icons, tables and
                                graph etc. used appropriately?</p>
                            <div class="flex items-center justify-between max-w-md">
                                <div class="flex flex-col items-center">
                                    <span class="text-xs text-gray-500 mb-1">0</span>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="visual" value="0"
                                            class="w-4 h-4 text-blue-600">
                                    </label>
                                </div>
                                <div class="flex flex-col items-center">
                                    <span class="text-xs text-gray-500 mb-1">2.5</span>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="visual" value="2.5"
                                            class="w-4 h-4 text-blue-600">
                                    </label>
                                </div>
                                <div class="flex flex-col items-center">
                                    <span class="text-xs text-gray-500 mb-1">5</span>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="visual" value="5"
                                            class="w-4 h-4 text-blue-600">
                                    </label>
                                </div>
                                <div class="flex flex-col items-center">
                                    <span class="text-xs text-gray-500 mb-1">7.5</span>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="visual" value="7.5"
                                            class="w-4 h-4 text-blue-600">
                                    </label>
                                </div>
                                <div class="flex flex-col items-center">
                                    <span class="text-xs text-gray-500 mb-1">10</span>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="visual" value="10"
                                            class="w-4 h-4 text-blue-600">
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-6" id="arrangement">
                            <p class="text-sm text-gray-700 mb-2">3. Arrangement of core components: Do you have a
                                prioritized arrangement of core components, including headings, subheadings, and content?
                            </p>
                            <div class="flex items-center justify-between max-w-md">
                                <div class="flex flex-col items-center">
                                    <span class="text-xs text-gray-500 mb-1">0</span>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="arrangement" value="0"
                                            class="w-4 h-4 text-blue-600">
                                    </label>
                                </div>
                                <div class="flex flex-col items-center">
                                    <span class="text-xs text-gray-500 mb-1">2.5</span>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="arrangement" value="2.5"
                                            class="w-4 h-4 text-blue-600">
                                    </label>
                                </div>
                                <div class="flex flex-col items-center">
                                    <span class="text-xs text-gray-500 mb-1">5</span>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="arrangement" value="5"
                                            class="w-4 h-4 text-blue-600">
                                    </label>
                                </div>
                                <div class="flex flex-col items-center">
                                    <span class="text-xs text-gray-500 mb-1">7.5</span>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="arrangement" value="7.5"
                                            class="w-4 h-4 text-blue-600">
                                    </label>
                                </div>
                                <div class="flex flex-col items-center">
                                    <span class="text-xs text-gray-500 mb-1">10</span>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="arrangement" value="10"
                                            class="w-4 h-4 text-blue-600">
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-8">
                        <h2 class="text-base font-semibold text-gray-800 mb-4">3. Technical completeness</h2>

                        <!-- Question 1 -->
                        <div class="mb-6" id="error">
                            <p class="text-sm text-gray-700 mb-2">1. Error: Are there any typos or mistranslations?</p>
                            <div class="flex items-center justify-between max-w-md">
                                <div class="flex flex-col items-center">
                                    <span class="text-xs text-gray-500 mb-1">0</span>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="error" value="0"
                                            class="w-4 h-4 text-blue-600">
                                    </label>
                                </div>
                                <div class="flex flex-col items-center">
                                    <span class="text-xs text-gray-500 mb-1">2.5</span>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="error" value="2.5"
                                            class="w-4 h-4 text-blue-600">
                                    </label>
                                </div>
                                <div class="flex flex-col items-center">
                                    <span class="text-xs text-gray-500 mb-1">5</span>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="error" value="5"
                                            class="w-4 h-4 text-blue-600">
                                    </label>
                                </div>
                                <div class="flex flex-col items-center">
                                    <span class="text-xs text-gray-500 mb-1">7.5</span>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="error" value="7.5"
                                            class="w-4 h-4 text-blue-600">
                                    </label>
                                </div>
                                <div class="flex flex-col items-center">
                                    <span class="text-xs text-gray-500 mb-1">10</span>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="error" value="10"
                                            class="w-4 h-4 text-blue-600">
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-8">
                        <h2 class="text-base font-semibold text-gray-800 mb-4">4. Purpose and effectiveness</h2>

                        <div class="mb-6" id="goal">
                            <p class="text-sm text-gray-700 mb-2">1. Goal alignment: Is the content appropriate for the set
                                goal (Informational, promotional, etc.)?</p>
                            <div class="flex items-center justify-between max-w-md">
                                <div class="flex flex-col items-center">
                                    <span class="text-xs text-gray-500 mb-1">0</span>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="goal" value="0"
                                            class="w-4 h-4 text-blue-600">
                                    </label>
                                </div>
                                <div class="flex flex-col items-center">
                                    <span class="text-xs text-gray-500 mb-1">2.5</span>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="goal" value="2.5"
                                            class="w-4 h-4 text-blue-600">
                                    </label>
                                </div>
                                <div class="flex flex-col items-center">
                                    <span class="text-xs text-gray-500 mb-1">5</span>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="goal" value="5"
                                            class="w-4 h-4 text-blue-600">
                                    </label>
                                </div>
                                <div class="flex flex-col items-center">
                                    <span class="text-xs text-gray-500 mb-1">7.5</span>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="goal" value="7.5"
                                            class="w-4 h-4 text-blue-600">
                                    </label>
                                </div>
                                <div class="flex flex-col items-center">
                                    <span class="text-xs text-gray-500 mb-1">10</span>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="goal" value="10"
                                            class="w-4 h-4 text-blue-600">
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end mt-8">
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-6 rounded-md">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </body>

@endsection
@push('js')
    <script>
        $(document).ready(function() {
            $('input[type="radio"]').change(function() {
                var name_input = $(this).attr('name');
                var selectedValue = $(this).val();
                if (selectedValue == 0 || selectedValue == 2.5) {
                    $('#' + name_input + '').find('textarea').remove();
                    $('#' + name_input + '').append(`<div class="mt-2">
                                        <textarea placeholder="Write the reason..." class="w-full border border-gray-300 rounded-md p-2 text-sm" name="`+name_input+`" rows="3"></textarea>
                                    </div>`);
                }
                if(selectedValue >2.5){
                    $('#' + name_input + '').find('textarea').remove();
                }
            });
        });
    </script>
@endpush
