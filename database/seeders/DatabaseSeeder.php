<?php

namespace Database\Seeders;

use App\Models\NewLetter;
use App\Models\NewsletterCategory;
use App\Models\TraineeMatch;
use App\Models\TvetType;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call(ProvinceSeeder::class);
        $this->call(DistrictSeeder::class);
        $this->call(DivisionalSecretariatsSeeder::class);
        $this->call(SyncDataSeeder::class);
        // $this->call(InstituteSeeder::class);
        $this->call(CategorySystemSeeder::class);
//        $this->call(FaqSeeder::class);
        // $this->call(TvetHeadquaterSeeder::class);
//        $this->call(CareerTestTraineeResultsSeeder::class);
//        $this->call(CgoUserSeeder::class);
//        $this->call(EventsTableSeeder::class);
//        $this->call(QnASeeder::class);
        // $this->call(NVQLevelSeeder::class);
        // $this->call(OccupationSeeder::class);
//        $this->call(TraineeUserSeeder::class);
//        $this->call(CgoCounselingSeeder::class);
        // $this->call(CgoCounselingHistorySeeder::class);
        $this->call(SectorSeeder::class);
//        $this->call(CoBusinessSeeder::class);
//        $this->call(EnterpriseSeeder::class);
//        $this->call(CompanySeeder::class);
//        $this->call(CompanyRecruiterSeeder::class);
//        $this->call(JobSeeder::class);
//        $this->call(TraineeUserCVSeeder::class);
//        $this->call(ContentSeeder::class);
//        $this->call(TraineeApplySeeder::class);
//        $this->call(TraineeMatchSeeder::class);
//        $this->call(OJTSeeder::class);
        $this->call(CareerTestSeeder::class);
        $this->call(CounselingFieldSeeder::class);


         $this->call(PolicyCategorySeeder::class);
//        $this->call(PolicySeeder::class);
        $this->call(NewsletterCategorySeeder::class);
//        $this->call(JobInformationSeeder::class);
        // $this->call(TvetTypeSeeder::class);
        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(UsersTableSeeder::class);
        // $this->call(AdminUserSeeder::class);
//        $this->call(CareerExpertInterviewSeeder::class);
        $this->call(CareerGuidanceCategorySeeder::class);
//        $this->call(CareerGuidanceSeeder::class);
        $this->call(MenuTableSeeder::class);
//        $this->call(BannersTableSeeder::class);
//        $this->call(NoticeSeeder::class);
        //  Artisan::call('shield:generate --all');
    }
}
