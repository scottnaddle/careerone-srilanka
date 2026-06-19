<?php

namespace App\Jobs;

use App\Models\TraineeUser;
use App\Models\Portfolio;
use App\Models\TraineeTrainingHistory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CreatePortfoliosJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $nicList;

    /**
     * Create a new job instance.
     *
     * @param array $nicList
     */
    public function __construct(array $nicList)
    {
        $this->nicList = $nicList;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->nicList as $nic) {
            try {
                // Find the trainee by NIC
                $trainee = TraineeUser::where('nic','ILIKE', $nic)->first();

                if (!$trainee) {
                    Log::warning("Can not find trainee: {$nic}");
                    continue;
                }

                // Check if the Portfolio already exists
                if (Portfolio::where('trainee_id', $trainee->id)->exists()) {
                    Log::info("Portfolio existed trainee NIC: {$nic}");
                    continue;
                }

                // Get the training history information
                $traineeTraining = TraineeTrainingHistory::where('trainee_id', $trainee->id)->first();

                $tvecEducations = [];
                $nvqEducations = [];

                // TVEC
                if ($traineeTraining && !empty($traineeTraining->content)) {
                    try {
                        $trainingContent = json_decode($traineeTraining->content);
                        if (json_last_error() === JSON_ERROR_NONE && is_array($trainingContent)) {
                            foreach ($trainingContent as $trainingInformation) {
                                if (isset($trainingInformation->INSTITUTE, $trainingInformation->COURSE)) {
                                    $tvecEducations[] = [
                                        'institute' => $trainingInformation->INSTITUTE->INSTITUTE_NAME ?? 'N/A',
                                        'industry_sector' => $trainingInformation->COURSE->INDUSTRY_SECTOR ?? 'N/A',
                                        'course_name' => $trainingInformation->COURSE->COURSE_NAME ?? 'N/A',
                                        'from' => $trainingInformation->COURSE->START_DATE ?? null,
                                        'to' => $trainingInformation->COURSE->END_DATE ?? null,
                                    ];
                                }
                            }
                        }
                    } catch (\Exception $e) {
                        Log::error("Not found NIC {$nic}: {$e->getMessage()}");
                    }
                }

                // NVQ
                if ($traineeTraining && !empty($traineeTraining->nvq_content)) {
                    try {
                        $nvqContent = json_decode($traineeTraining->nvq_content);
                        if (json_last_error() === JSON_ERROR_NONE && is_array($nvqContent)) {
                            foreach ($nvqContent as $nvqInformation) {
                                $nvqEducations[] = [
                                    'qualification_name' => $nvqInformation->QUALIFICATION_NAME ?? 'N/A',
                                    'effective_date' => $nvqInformation->EFFECTIVE_DATE ?? null,
                                    'level' => $nvqInformation->QUALIFICATION_LEVEL ?? 'N/A',
                                ];
                            }
                        }
                    } catch (\Exception $e) {
                        Log::error("Lỗi xử lý NVQ cho NIC {$nic}: {$e->getMessage()}");
                    }
                }

                // Create a new portfolio
                Portfolio::create([
                    'trainee_id' => $trainee->id,
                    'data' => [
                        'fullname' => $trainee->fullName ?? '',
                        'avatar' => $trainee->profile_image ?? 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80',
                        'cover_photo' => 'https://images.unsplash.com/photo-1605379399642-870262d3d051?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80',
                        'description' => '',
                        'summary' => getNewestTrainingInformationOfTrainee($trainee->id),
                        'basic_information' => [
                            'fullname' => $trainee->fullName ?? '',
                            'email' => $trainee->email ?? '',
                            'phone' => $trainee->mobile ?? '',
                            'address' => $trainee->contact_address ?? '',
                        ],
                        'about_me' => '',
                        'tvec_educations' => $tvecEducations,
                        'nvq_educations' => $nvqEducations,
                        'educations' => [],
                        'ojt_experiences' => [],
                        'experiences' => [],
                        'skills' => [],
                        'languages' => [],
                        'evidences' => [],
                    ],
                ]);

                Log::info("Create portfolio successfully for trainee NIC: {$nic}");
            } catch (\Exception $e) {
                Log::error("Error on handle trainee with NIC {$nic}: {$e->getMessage()}");
            }
        }
    }
}
