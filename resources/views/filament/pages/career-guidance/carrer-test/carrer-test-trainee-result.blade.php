<x-filament-panels::page>
<div>
    <div
        class="flex flex-col gap-4 md:gap-6 my-6 bg-white dark:bg-[#1E1E1E] rounded-xl shadow-custom-light shadow-custom-dark p-4">
{{--        <p class="text-2xl mt-4 text-[#464559] font-semibold dark:text-white">{{__('admin/career_test.career_test.title')}}</p>--}}

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
{{--        @php--}}
{{--            $careerTestList = $this->getCareerTestTraineeResult();--}}
{{--            $results = $careerTestList['results'];--}}
{{--            $count = $careerTestList['count'];--}}
{{--            $careerTestTypes = $careerTestList['career_test_types'];--}}
{{--            $institutes=$careerTestList['institute'];--}}
{{--        @endphp--}}
{{--        <form method="get" action="{{ url()->current() }}" id="filter-form" method="GET">--}}

{{--            <div class="flex gap-4 flex-col md:flex-row">--}}
{{--                <div class="w-full flex gap-4">--}}
{{--                    --}}
{{--                    <select id="sector" name="carrer_type_type"--}}
{{--                        class="flex-1 px-4 py-2 w-1/4 border border-gray-300 rounded-lg text-[#706F81]">--}}
{{--                        <option value="">{{__('admin/career_test.career_test.career_test_type')}}</option>--}}
{{--                        @foreach ($careerTestTypes as $careerTestType)--}}
{{--                            <option value="{{ $careerTestType->id }}" @selected(request()->query('carrer_type_type') == $careerTestType->id)>--}}
{{--                                {{ $careerTestType->test_name }}--}}
{{--                            </option>--}}
{{--                        @endforeach--}}
{{--                    </select>--}}
{{--                    <select id="institute" name="institute"--}}
{{--                    class="flex-1 px-4 py-2 w-1/4 border border-gray-300 rounded-lg text-[#706F81]">--}}
{{--                    <option value="">{{__('admin/career_test.career_test.institute')}}</option>--}}
{{--                    @foreach ($institutes as $institute)--}}
{{--                        <option value="{{ $institute->id }}" @selected(request()->query('institute') == $institute->id)>--}}
{{--                            {{ $institute->name }}--}}
{{--                        </option>--}}
{{--                    @endforeach--}}
{{--                </select>--}}
{{--                <input type="month" name="period"--}}
{{--                class="flex-grow px-4 py-2 border border-gray-300 rounded-lg text-[#706F81] font-medium"--}}
{{--                value="{{ request()->query('period') }}" placeholder="Period">--}}
{{--         --}}

{{--                </div>--}}
{{--                <div class="w-fit"><button type="submit"--}}
{{--                        class="flex-1 px-4 py-2 bg-blue-500 text-white rounded-full">{{__('admin/career_test.career_test.search')}}</button></div>--}}
{{--            </div>--}}

{{--        </form> --}}
       {{$this->table}}
    </div></div>
    </x-filament-panels::page>
