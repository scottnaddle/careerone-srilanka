<?php

namespace Database\Seeders;

use App\Models\CompanyRecruiter;
use App\Models\Job;
use App\Models\TraineeApply;
use App\Models\TraineeUser;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TraineeApplySeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		$faker = Faker::create();

		for ($i = 0; $i < 200; $i++) {
            $traineeId = $faker->randomElement(TraineeUser::pluck('id')->toArray());
            $jobId = $faker->randomElement(Job::pluck('id')->toArray());

            $existingRecords = TraineeApply::where('trainee_id', $traineeId)
                ->where('job_id', $jobId)
                ->get();

            if ($existingRecords->count() >= 2) {
                continue;
            }

            $existingApplyTypes = $existingRecords->pluck('apply_type')->toArray();

            $possibleApplyTypes = ['apply', 'job_match'];
            $availableApplyTypes = array_diff($possibleApplyTypes, $existingApplyTypes);

            if (empty($availableApplyTypes)) {
                continue;
            }
            $create_at = $faker->dateTimeBetween('-1 years', 'now');

            $applyType = $faker->randomElement($availableApplyTypes);
            TraineeApply::create([
                'trainee_id' => $traineeId,
                'job_id' => $jobId,
                'apply_time' => now(),
                'read' => null,
                'selected' => null,
                'selected_by' => null,
                'apply_type' => $applyType,
                'created_at' => $create_at,
                'updated_at' => $create_at,
            ]);

		}
	}
}
