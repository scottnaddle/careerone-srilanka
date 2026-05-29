<?php

namespace App\Services\Trainee;

use App\Models\TraineeTrainingHistory;
use App\Models\NVQLevel;
use App\Models\Institute;
use App\Models\Sector;
use App\Models\ReqCourse;
use App\Models\TraineeNVQ;
use App\Models\TraineeInstitute;
use App\Models\TraineeSector;
use App\Models\TraineeRegCourse;
use App\Models\TraineeUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\Trainee\TraineeInformationService;
use Exception;

class TraineeTrainingSyncService
{
    protected $traineeInformationService;

    public function __construct(TraineeInformationService $traineeInformationService)
    {
        $this->traineeInformationService = $traineeInformationService;
    }

    public function syncTraineeTrainingInformation($user)
    {
        // dd($user);
        try {
            // Fetch trainee training information
            $traineeTrainingInformations = $this->traineeInformationService->getTrainingHistoryInformation($user->nic);
            $traineeBasicInformation = $this->traineeInformationService->getTraineeInformation($user->nic);
            $traineeHistoryCertificates = $this->traineeInformationService->getTrainingHistoryCertificates($user->nic);
            if ($traineeTrainingInformations['message'] !== 'No Information.') {
                // Delete existing training history data for this trainee
                TraineeTrainingHistory::where('trainee_id', $user->id)->delete();
                TraineeNVQ::where('trainee_id', $user->id)->delete();
                TraineeInstitute::where('trainee_id', $user->id)->delete();
                TraineeSector::where('trainee_id', $user->id)->delete();
                TraineeRegCourse::where('trainee_id', $user->id)->delete();

                // Save trainee training history
                $traineeTrainingHistory = new TraineeTrainingHistory();
                $traineeTrainingHistory->trainee_id = $user->id;
                $traineeTrainingHistory->content = json_encode($traineeTrainingInformations['message']);
                if ($traineeHistoryCertificates['message'] !== 'No Information.') {
                    $traineeTrainingHistory->nvq_content = json_encode($traineeHistoryCertificates['message']);
                }
                $traineeTrainingHistory->save();

                \Log::info("------------------Start syncing trainee information for NIC: " . $user->nic.'-----------------');
                \Log::info("Syncing trainee information for NIC: " . $user->nic);
                foreach ($traineeTrainingInformations['message'] as $item) {

//                    $this->syncNVQInformation($item, $user->id);
                    $this->syncInstituteInformation($item, $user->id);
                    $this->syncSectorInformation($item, $user->id);
                    $this->syncCourseInformation($item, $user->id);
                    if ($traineeBasicInformation['message'] != 'No Information.'){
                        $this->syncUserInformation($traineeBasicInformation['message'][0], $user->id);
                    }
                }
                //Because now TVEC change getting certificate to API 7
                if ($traineeHistoryCertificates['message'] !== 'No Information.') {
                    \Log::info("Syncing trainee certificates for NIC: " . $user->nic);
                    foreach ($traineeHistoryCertificates['message'] as $certificate) {

                        $this->syncNVQInformation($certificate, $user->id);
                    }
                }

                \Log::info("------------------End syncing trainee information for NIC: " . $user->nic.'------------------');
            }
        } catch (\Exception $e) {
            \Log::error('Error syncing trainee training information: ' . $e->getMessage());
        }
    }

    private function syncNVQInformation($item, $traineeId)
    {
        $nvq = NVQLevel::where(DB::raw('LOWER(code)'), strtolower($item['QUALIFICATION_CODE']))->first();
        if ($nvq) {
            $traineeNvq = new TraineeNVQ();
            $traineeNvq->trainee_id = $traineeId;
            $traineeNvq->nvq_id = $nvq->id;
            $traineeNvq->effective_date = $item['EFFECTIVE_DATE'];
            $traineeNvq->course_mode = $item['COURSE_MODE'];
            $traineeNvq->save();
        }
    }

    private function syncInstituteInformation($item, $traineeId)
    {
        $institute = Institute::where(DB::raw('LOWER(reg_no)'), strtolower($item['INSTITUTE']['INSTITUTE_REG_NO']))->first();
        if ($institute) {
            $traineeInstitute = new TraineeInstitute();
            $traineeInstitute->trainee_id = $traineeId;
            $traineeInstitute->institute_id = $institute->id;
            $traineeInstitute->start_date = $item['COURSE']['START_DATE'];
            $traineeInstitute->end_date = $item['COURSE']['END_DATE'];
            $traineeInstitute->save();
        }
    }

    private function syncSectorInformation($item, $traineeId)
    {
        $sector = Sector::where(DB::raw('LOWER(name)'), strtolower($item['COURSE']['INDUSTRY_SECTOR']))->first();
        if ($sector) {
            $traineeSector = new TraineeSector();
            $traineeSector->trainee_id = $traineeId;
            $traineeSector->sector_id = $sector->id;
            $traineeSector->start_date = $item['COURSE']['START_DATE'];
            $traineeSector->end_date = $item['COURSE']['END_DATE'];
            $traineeSector->save();
        }
    }

    private function syncCourseInformation($item, $traineeId)
    {
        $course = ReqCourse::where(DB::raw('LOWER(institute_reg_no)'), strtolower($item['INSTITUTE']['INSTITUTE_REG_NO']))
            ->where(DB::raw('LOWER(course_name)'), strtolower($item['COURSE']['COURSE_NAME']))
            ->first();

        if ($course) {
            $traineeRegCourse = new TraineeRegCourse();
            $traineeRegCourse->trainee_id = $traineeId;
            $traineeRegCourse->reg_course_id = $course->id;
            $traineeRegCourse->batch_no = $item['COURSE']['BATCH_NO'];
            $traineeRegCourse->start_date = $item['COURSE']['START_DATE'];
            $traineeRegCourse->end_date = $item['COURSE']['END_DATE'];
            $traineeRegCourse->save();
        }
    }

    private function syncUserInformation($item, $traineeId)
    {
        $trainee = TraineeUser::where('id', $traineeId)->first();

        if ($trainee) {
            if (!is_null($item['STD_FULL_NAME'])) {
                $trainee->full_name = $item['STD_FULL_NAME'];
            }
            if (!is_null($item['STD_FIRST_NAME'])) {
                $trainee->first_name = $item['STD_FIRST_NAME'];
            }
            if (!is_null($item['STD_SURNAME'])) {
                $trainee->std_surname = $item['STD_SURNAME'];
            }
            if (!is_null($item['STD_INITIALS'])) {
                $trainee->std_initials = $item['STD_INITIALS'];
            }
            if (!is_null($item['STD_GENDER'])) {
                $trainee->gender = getCodeIdByStringEn('gender', $item['STD_GENDER']);
            }
            if (!is_null($item['STD_PERMANANT_ADDRESS'])) {
                $trainee->permanant_address = $item['STD_PERMANANT_ADDRESS'];
            }
            if (!is_null($item['STD_CONTACT_ADDRESS'])) {
                $trainee->contact_address = $item['STD_CONTACT_ADDRESS'];
            }
            if (!is_null($item['STD_TELPHONE'])) {
                $trainee->telephone = $item['STD_TELPHONE'];
            }
            if (!is_null($item['STD_MOBILE'])) {
                $trainee->mobile = $item['STD_MOBILE'];
            }
            // if (!is_null($item['STD_EMAIL'])) {
            //     $trainee->email = $item['STD_EMAIL'];
            // }

            $trainee->save();
        }
    }

}
