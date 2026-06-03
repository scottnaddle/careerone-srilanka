<?php

if (!function_exists('activeGuard')) {
    /**
     * Getting current guard
     *
     * @return string
     */
    function activeGuard(){

        foreach(array_keys(config('auth.guards')) as $guard){

            if(auth()->guard($guard)->check() && $guard != 'admin') return $guard;

        }
        return null;
    }
}
if (!function_exists('formatPhoneNumber')) {
    function formatPhoneNumber($phoneNumber) {
        // Remove any non-numeric characters except the leading +
        $cleaned = preg_replace('/[^\d]/', '', $phoneNumber);

        // Check if the cleaned number has the correct length
//        if (strlen($cleaned) != 11) {
//            return 'Invalid phone number length';
//        }

        // Extract parts of the phone number
        $countryCode = '0';
        $part1 = substr($cleaned, 1, 3); // Skip the leading digit
        $part2 = substr($cleaned, 4, 3);
        $part3 = substr($cleaned, 7, 4);

        // Format the phone number
        $formatted = sprintf('%s%s-%s-%s', $countryCode, $part1, $part2, $part3);

//        return $formatted;
        return $phoneNumber;
    }
}
if (!function_exists('convertDays')) {
    function convertDays($days) {
        // Map of short day names to full day names
        $dayMap = [
            'mon' => 'Monday',
            'tue' => 'Tuesday',
            'wed' => 'Wednesday',
            'thu' => 'Thursday',
            'fri' => 'Friday',
            'sat' => 'Saturday',
            'sun' => 'Sunday'
        ];

        // Convert the string to an array
        $daysArray = explode(',', $days);

        // Sort the array to ensure it's in the correct order
        $sortedDays = array_values(array_intersect(array_keys($dayMap), $daysArray));

        // Check if all days of the week are included
        if (count($sortedDays) === 7) {
            return "All day";
        }

        // Get the full day names
        $fullDays = array_map(function($day) use ($dayMap) {
            return $dayMap[$day];
        }, $sortedDays);

        // Check if the days are consecutive
        if (count($fullDays) > 1) {
            $firstDay = reset($fullDays);
            $lastDay = end($fullDays);
            return "$firstDay to $lastDay";
        }

        // If only one day is provided
        return reset($fullDays);
    }
}

if (!function_exists('getSumaryTraining')) {
    function getSumaryTraining($traineeId, $getFromAPI = false) {
        // Fetch trainee user details
        $traineeUser = \App\Models\TraineeUser::find($traineeId);

        if (!$traineeUser) {
            return '<p class="text-sm dark:text-white">Trainee not found.</p>';
        }
        if ($getFromAPI == true) {
            // Initialize the service to fetch training information
            $traineeInformationService = new \App\Services\Trainee\TraineeInformationService();
            $trainingInformations = $traineeInformationService->getTrainingHistoryInformation($traineeUser->nic);
            $trainingCertificates = $traineeInformationService->getTrainingHistoryCertificates($traineeUser->nic);

            // If service request fails, try fetching data from local database
            if (isset($trainingInformations['error'])) {
                return '<p class="text-sm dark:text-white">Service available. Please try again</p>';
            }

            // If service request succeeds but no message data is available
            if ($trainingInformations['message'] == 'No Information.' || empty($trainingInformations['message'])) {
                return '<p class="text-sm dark:text-white">No training information found.</p>';
            }

            // Parse the response data
            $informations = $trainingInformations['message'];
            $certificateInformations = $trainingCertificates['message'];
//            return buildTrainingSummaryTable($informations, $certificateInformations, true); // Pass 'true' for API response
            return prepareInformationData($informations, $certificateInformations, true);
        }else {
            $trainingInformations = \App\Models\TraineeTrainingHistory::where('trainee_id', $traineeId)->first();
            if (!$trainingInformations) {
                return '<p class="text-sm dark:text-white">No training information found.</p>';
            }

            $informations = json_decode($trainingInformations->content);
            $certificateInformations = json_decode($trainingInformations->nvq_content);
//            return buildTrainingSummaryTable($informations, $certificateInformations);
            return prepareInformationData($informations, $certificateInformations);
        }

    }

    function prepareInformationData($traineeTrainingHistory, $certificateInformations, $isApiResponse = false) {
        // if (empty($traineeTrainingHistory) || empty($certificateInformations)) {
        //     return $traineeTrainingHistory;
        // }
        if (empty($certificateInformations)) {
            $certificateInformations =[];
        }
        foreach ($traineeTrainingHistory as &$history) {
            foreach ($certificateInformations as $certificate) {
                $historyInstituteRegNo = $isApiResponse ? $history['INSTITUTE']['INSTITUTE_REG_NO'] ?? null : $history->INSTITUTE->INSTITUTE_REG_NO ?? null;
                $historyNcsCode = $isApiResponse ? $history['NVQ_QUALIFICATION']['NCS_CODE'] ?? null : $history->NVQ_QUALIFICATION->NCS_CODE ?? null;
                $certificateInstituteRegNo = $isApiResponse ? $certificate['INSTITUTE_REG_NO'] : $certificate->INSTITUTE_REG_NO;
                $certificateNcs = $isApiResponse ? $certificate['NCS_CODE'] : $certificate->NCS_CODE;
                if ($certificateInstituteRegNo == $historyInstituteRegNo && $certificateNcs == $historyNcsCode) {
                    if ($isApiResponse) {
                        $history['NVQ_QUALIFICATION']['QUALIFICATION_CODE'] = $certificate['QUALIFICATION_CODE'] ?? null;
                        $history['NVQ_QUALIFICATION']['QUALIFICATION_VERSION'] = $certificate['QUALIFICATION_VERSION'] ?? null;
                        $history['NVQ_QUALIFICATION']['QUALIFICATION_NAME'] = $certificate['QUALIFICATION_NAME'] ?? null;
                        $history['NVQ_QUALIFICATION']['EFFECTIVE_DATE'] = $certificate['EFFECTIVE_DATE'] ?? null;
                        $history['NVQ_QUALIFICATION']['QUALIFICATION_LEVEL'] = $certificate['QUALIFICATION_LEVEL'] ?? null;
                    } else {
                        $history->NVQ_QUALIFICATION->QUALIFICATION_CODE = $certificate->QUALIFICATION_CODE ?? null;
                        $history->NVQ_QUALIFICATION->QUALIFICATION_VERSION = $certificate->QUALIFICATION_VERSION ?? null;
                        $history->NVQ_QUALIFICATION->QUALIFICATION_NAME = $certificate->QUALIFICATION_NAME ?? null;
                        $history->NVQ_QUALIFICATION->EFFECTIVE_DATE = $certificate->EFFECTIVE_DATE ?? null;
                        $history->NVQ_QUALIFICATION->QUALIFICATION_LEVEL = $certificate->QUALIFICATION_LEVEL ?? null;
                    }
                }
            }
        }

        return buildTrainingSummaryTable($traineeTrainingHistory, $isApiResponse);
    }
    /**
     * Helper function to build the training summary table.
     */
    function buildTrainingSummaryTable($informations, $isApiResponse = false) {
        $summaryTable = '<table class="text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th class="text-sm font-semibold text-left text-gray-700 dark:text-white p-1">Institute name</th>
                    <th class="text-sm font-semibold text-left text-gray-700 dark:text-white p-1">Course name</th>
                    <th class="text-sm font-semibold text-left text-gray-700 dark:text-white p-1">NVQ Qualification</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-600">';
        if ($informations != 'No Information.') {
            // Loop through the information and build the table rows
            foreach ($informations as $information) {
                $courseName = $isApiResponse
                    ? $information['COURSE']['COURSE_NAME'] . ' (' . $information['COURSE']['START_DATE'] . ' - ' . $information['COURSE']['END_DATE'] . ')'
                    : $information->COURSE->COURSE_NAME;
                $instituteName = $isApiResponse
                    ? $information['INSTITUTE']['INSTITUTE_NAME'] : $information->INSTITUTE->INSTITUTE_NAME;

                $nvqQualification = $isApiResponse
                    ? $information['NVQ_QUALIFICATION']['QUALIFICATION_NAME'] . ' (' . $information['NVQ_QUALIFICATION']['QUALIFICATION_LEVEL'] .'-'. $information['NVQ_QUALIFICATION']['EFFECTIVE_DATE'] . ')'
                    : $information->NVQ_QUALIFICATION->QUALIFICATION_NAME . ' (' . $information->NVQ_QUALIFICATION->QUALIFICATION_LEVEL .'-'. $information->NVQ_QUALIFICATION->EFFECTIVE_DATE  . ')';


                $summaryTable .= '<tr>
                <td class="text-sm text-gray-900 dark:text-white text-left p-1 border-r border-gray-300">' . $instituteName . '</td>
                <td class="text-sm text-gray-900 dark:text-white text-left p-1 border-r border-gray-300">' . $courseName . '</td>
                <td class="text-sm text-gray-900 dark:text-white text-left p-1">' . $nvqQualification . '</td>
            </tr>';
            }

        }

        $summaryTable .= '</tbody></table>';

        return $summaryTable;
    }
}

//if (!function_exists('getNewestTrainingInformationOfTrainee')) {
//    function getNewestTrainingInformationOfTrainee($traineeId) {
//        // Fetch trainee user details
//        $traineeUser = \App\Models\TraineeUser::find($traineeId);
//
//        if (!$traineeUser) {
//            return '<p class="text-sm dark:text-white">Trainee not found.</p>';
//        }
//
//        // Initialize the service to fetch training information
//        $traineeInformationService = new \App\Services\Trainee\TraineeInformationService();
//        $trainingInformations = $traineeInformationService->getTrainingHistoryInformation($traineeUser->nic);
//
//        // If service request fails, try fetching data from local database
//        if (isset($trainingInformations['error'])) {
//            $trainingInformations = \App\Models\TraineeTrainingHistory::where('trainee_id', $traineeId)->first();
//            if (!$trainingInformations) {
//                return '<p class="text-sm dark:text-white">No training information found.</p>';
//            }
//
//            $informations = json_decode($trainingInformations->content);
//            // return buildTrainingSummaryTable($informations);
//            $lastInformation = end($informations);
//            $institute = $lastInformation->INSTITUTE->INSTITUTE_NAME;
//            $course = $lastInformation->COURSE->COURSE_NAME;
//            $nvqQualification = $lastInformation->NVQ_QUALIFICATION->QUALIFICATION_NAME . ' (' . $lastInformation->NVQ_QUALIFICATION->QUALIFICATION_LEVEL .'-'. $lastInformation->NVQ_QUALIFICATION->EFFECTIVE_DATE . ')';
//            return $institute.' | '.$nvqQualification;
//            return $institute.' | '.$course. ' | '.$nvqQualification;
//        }
//
//        // If service request succeeds but no message data is available
//        if (!isset($trainingInformations['message']) || empty($trainingInformations['message'])) {
//            return '<p class="text-sm dark:text-white">No training information available.</p>';
//        }
//
//        // Parse the response data
//        $informations = $trainingInformations['message'];
//        if ($informations != 'No Information.') {
//            $lastInformation = end($informations);
//            $institute = $lastInformation['INSTITUTE']['INSTITUTE_NAME'];
//            $nvqQualification = $lastInformation['NVQ_QUALIFICATION']['QUALIFICATION_NAME'] . ' (' . $lastInformation['NVQ_QUALIFICATION']['QUALIFICATION_LEVEL'] .'-'. $lastInformation['NVQ_QUALIFICATION']['EFFECTIVE_DATE'] . ')';
//
//            return $institute.' | '.$lastInformation['COURSE']['COURSE_NAME'].' | ' .$nvqQualification;
//        }
//
//    }
//}

if (!function_exists('getNewestTrainingInformationOfTrainee')) {
    function getNewestTrainingInformationOfTrainee($traineeId) {
        // Fetch trainee user details
        $traineeUser = \App\Models\TraineeUser::find($traineeId);

        if (!$traineeUser) {
//            return '<p class="text-sm dark:text-white">Trainee not found.</p>';
            return '';
        }

        // Only get information from DB
        $trainingInformations = \App\Models\TraineeTrainingHistory::where('trainee_id', $traineeId)->first();
        if (!$trainingInformations) {
//            return '<p class="text-sm dark:text-white">No training information found.</p>';
            return '';
        }

        $informations = json_decode($trainingInformations->content);
        $nvqInformations = json_decode($trainingInformations->nvq_content);
        $latestInformation = null;
        foreach ($informations as $information) {
            if (!isset($information->COURSE->END_DATE)) {
                continue;
            }
            $endDate = strtotime($information->COURSE->END_DATE);
            if (!$latestInformation || $endDate > strtotime($latestInformation->COURSE->END_DATE)) {
                $latestInformation = $information;
            }
        }
        // If no information has a valid END_DATE, pick the first one
        if (!$latestInformation && count($informations) > 0) {
            $latestInformation = $informations[0];
        }
        if ($nvqInformations != '' && count($nvqInformations) > 0 && $latestInformation != '') {
            foreach ($nvqInformations as $nvqInformation) {
                if ($nvqInformation->INSTITUTE_REG_NO == $latestInformation->INSTITUTE->INSTITUTE_REG_NO && $nvqInformation->NCS_CODE == $latestInformation->NVQ_QUALIFICATION->NCS_CODE) {
                    $latestInformation->NVQ_QUALIFICATION->QUALIFICATION_CODE = $nvqInformation->QUALIFICATION_CODE;
                    $latestInformation->NVQ_QUALIFICATION->QUALIFICATION_VERSION = $nvqInformation->QUALIFICATION_VERSION;
                    $latestInformation->NVQ_QUALIFICATION->QUALIFICATION_NAME = $nvqInformation->QUALIFICATION_NAME;
                    $latestInformation->NVQ_QUALIFICATION->EFFECTIVE_DATE = $nvqInformation->EFFECTIVE_DATE;
                }
            }
            $institute = $latestInformation?->INSTITUTE?->INSTITUTE_NAME;
            $course = $latestInformation?->COURSE?->COURSE_NAME;
//            $nvqQualification = $latestInformation?->NVQ_QUALIFICATION?->QUALIFICATION_NAME . ' (' . $latestInformation?->NVQ_QUALIFICATION?->QUALIFICATION_LEVEL .'-'. $latestInformation?->NVQ_QUALIFICATION?->EFFECTIVE_DATE . ')';
            $nvqQualification = $latestInformation?->NVQ_QUALIFICATION?->QUALIFICATION_NAME ?? 'Unknown Qualification';

            $level = $latestInformation?->NVQ_QUALIFICATION?->QUALIFICATION_LEVEL ?? '';
            $effectiveDate = $latestInformation?->NVQ_QUALIFICATION?->EFFECTIVE_DATE ?? '';

            if ($level || $effectiveDate) {
                $nvqQualification .= ' (' . $level . ($level && $effectiveDate ? '-' : '') . $effectiveDate . ')';
            }
            return $institute.' | '.$nvqQualification;
//            return $institute.' | '.$course. ' | '.$nvqQualification;
        }elseif($latestInformation != '' && $nvqInformations == null) {
            $institute = $latestInformation?->INSTITUTE?->INSTITUTE_NAME;
            $course = $latestInformation?->COURSE?->COURSE_NAME;
            return $institute.' | '.$course;
        }else {
            return '<p class="text-sm dark:text-white">No training information found.</p>';
            return '';
        }

    }
}


if (!function_exists('getInstitutes')) {
    function getInstitutes($traineeId, $newest = false) {
        $summary = '';
        $trainingHistory = \App\Models\TraineeTrainingHistory::where('trainee_id', $traineeId)->first();

        if (!$trainingHistory) {
            return '<p class="text-sm dark:text-white">No institute information.</p>';
        }

        $informations = json_decode($trainingHistory->content);

        // Display the newest information only if $newest is true
        if ($newest) {
            $latestInstitute = end($informations);
            $summary .= '<span class="text-sm dark:text-white text-[#706F81]">'
                . $latestInstitute->INSTITUTE->INSTITUTE_NAME . ' ('
                . $latestInstitute->INSTITUTE->DISTRICT_NAME . ')</span>';
        } else {
            // Display all information if $newest is false
            foreach ($informations as $information) {
                $summary .= '<span class="text-sm dark:text-white text-[#706F81]">- '
                    . $information->INSTITUTE->INSTITUTE_NAME . ' ('
                    . $information->INSTITUTE->DISTRICT_NAME . ')</span>';
            }
        }

        return '<div class="flex flex-col gap-1 justify-center">' . $summary . '</div>';
    }
}
if (!function_exists('checkSkillPassportInformation')) {
    function checkSkillPassportInformation($nic) {
        $traineeInformationService = new \App\Services\Trainee\TraineeInformationService();
        $response = $traineeInformationService->checkSkillPassportInformation($nic)['message'] ?? '';
        if ($response == "Y") {
            $html = '<img src="/images/skills-passport.png" class="object-cover h-full" alt="Skill passport card">';
            return $html;
        }
    }}

if (!function_exists('getLanguageColumn')) {
    /**
     * Get the appropriate column name based on the language.
     *
     * @param string|null $language
     * @return string
     */
    function getLanguageColumn($language = null): string {
        // Use the application locale if language is not passed
        if (!$language) {
            $language = \Illuminate\Support\Facades\App::getLocale();
        }

        // Define the column name based on the language
        return match ($language) {
            'en' => 'code_name_en',
            'tm' => 'code_name_tm',
            'sn' => 'code_name_sn',
            default => 'code_name_en', // Fallback to English
        };
    }
}

if (!function_exists('getCodeList')) {
    /**
     * Fetch the list of codes by module and language.
     *
     * @param string $module
     * @param string|null $language
     * @return \Illuminate\Support\Collection
     */
    function getCodeList($module, $language = null) {
        $languageColumn = getLanguageColumn($language);

        // Fetch the records based on the module and the language column
        return \App\Models\CodeManagement::select('code_id', $languageColumn . ' as code_name')
            ->whereRaw('LOWER(module) = ?', [strtolower($module)])
            ->where('status', 1) // Only fetch active codes
            ->get();
    }
}

if (!function_exists('getCodeNameByCodeId')) {
    /**
     * Fetch the code name by module and code ID.
     *
     * @param string $module
     * @param int $code_id
     * @param string|null $language
     * @return string|null
     */
    function getCodeNameByCodeId($module, $code_id, $language = null) {
        $languageColumn = getLanguageColumn($language);

        // Fetch the record based on the module and code_id
        $result = \App\Models\CodeManagement::select($languageColumn . ' as code_name')
            ->whereRaw('LOWER(module) = ?', [strtolower($module)])
            ->where('code_id', $code_id)
            ->first();
        // Return the code name or null if not found
        return $result ? $result->code_name : null;
    }
}


if (!function_exists('getCodeIdByStringEn')) {
    /**
     * Fetch the code ID by module and code name (case-insensitive comparison).
     *
     * @param string $module
     * @param int $string
     * @return int|null
     */
    function getCodeIdByStringEn($module, $string) {
        $result = \App\Models\CodeManagement::select('code_id')
            ->whereRaw('LOWER(module) = ?', [strtolower($module)])
            ->whereRaw('LOWER(code_name_en) LIKE ?', ['%' . strtolower($string) . '%'])
            ->first();

        // Return the code ID or null if not found
        return $result ? $result->code_id : null;
    }
}

if (! function_exists('getYoutubeEmbedUrl')) {
    function getYoutubeEmbedUrl($url)
    {
        // Define a regex pattern to identify if it's a YouTube URL
        $pattern = '/^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.?be)\/.+$/i';

        // Check if the URL is a YouTube URL
        if (preg_match($pattern, $url)) {
            // Extract the video ID
            $videoIdPattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i';
            preg_match($videoIdPattern, $url, $matches);

            // Return the embed URL if a valid video ID is found
            if (isset($matches[1])) {
                return 'https://www.youtube.com/embed/' . $matches[1];
            }
        }

        // Return the original URL if it's not a valid YouTube URL
        return $url;
    }
}

if (! function_exists('getCGOName')) {
    function getCGOName($trainee_id, $job_id, $type = 'job')
    {
        if ($type == 'ojt') {
            $traineeMatch = \App\Models\OjtTraineeApply::where('trainee_id', $trainee_id)->where('ojt_id', $job_id)->where('apply_type',\App\Enums\TypeTraineeApply::OJT_MATCH)->first();

            if ($traineeMatch) {
                return trans('system.information.event.by'). ' '.$traineeMatch->matchedBy->fullName;
            }else {
                return '';
            }
        }
        $traineeMatch = \App\Models\TraineeMatch::where('trainee_id', $trainee_id)->where('job_id', $job_id)->first();
        if ($traineeMatch) {
            return trans('system.information.event.by'). ' '.$traineeMatch->matchedBy->fullName;
        }else {
            return '';
        }
    }
}

if (! function_exists('getCGOIdMatchedTraineeToOJT')) {
    function getCGOIdMatchedTraineeToOJT($trainee_id, $ojt_id)
    {
        $traineeMatch = \App\Models\OJTMatch::where('trainee_id', $trainee_id)->where('ojt_id', $ojt_id)->first();
        if ($traineeMatch) {
            return $traineeMatch->matched_by;
        }else {
            return '';
        }
    }
}

if (! function_exists('getCGOIdMatchedTraineeToJob')) {
    function getCGOIdMatchedTraineeToJob($trainee_id, $job_id)
    {
        $traineeMatch = \App\Models\TraineeMatch::where('trainee_id', $trainee_id)->where('job_id', $job_id)->first();
        if ($traineeMatch) {
            return $traineeMatch->created_by;
        }else {
            return '';
        }
    }
}
if (! function_exists('getCGOIdMatchedTraineeToOJT')) {
    function getCGOIdMatchedTraineeToOJT($trainee_id, $ojt_id)
    {
        $traineeMatch = \App\Models\OjtTraineeApply::where('trainee_id', $trainee_id)->where('ojt_id', $ojt_id)->first();
        if ($traineeMatch) {
            return $traineeMatch->created_by;
        }else {
            return '';
        }
    }
}
if (! function_exists('getTimeApply')) {
    function getTimeApply($trainee_id, $job_id, $type = 'job', $apply_type = 'job_match')
    {
        if ($type == 'job') {
            $apply = \App\Models\TraineeApply::where('trainee_id', $trainee_id)->where('job_id', $job_id)->where('apply_type', 'ILIKE', $apply_type)->first();
        }else{
            $apply = \App\Models\OjtTraineeApply::where('trainee_id', $trainee_id)->where('ojt_id', $job_id)->first();
        }
        if ($apply) {
            return $apply->created_at;
        }
    }
}

if (! function_exists('getInstituteName')) {
    function getInstituteName($institute_id){
        $institute =  \App\Models\Institute::where('id', $institute_id)->first();
        $name = '';
        if ($institute) {
            $name = $institute->name;
        }
        return $name;
    }
}
if (!function_exists('ray')) {
    function ray(...$args) {
        return $args;
    }
}
if (!function_exists('saveImageAsWebp')) {
    function saveImageAsWebp($imageFile, $folder, $name = null)
    {
        $filename = $name ?? pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
        $fileNameToStore = $filename . '.webp';
        $storagePath = storage_path('app/public/' . $folder);

        if (!file_exists($storagePath)) {
            mkdir($storagePath, 0755, true);
        }

        $image = \Intervention\Image\Facades\Image::make($imageFile)->encode('webp', 80);
        $image->save($storagePath . '/' . $fileNameToStore);

        return 'storage/' . $folder . '/' . $fileNameToStore;
    }
}
