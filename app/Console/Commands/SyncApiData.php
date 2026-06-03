<?php

namespace App\Console\Commands;

use App\Models\HeadOfficeModel;
use Illuminate\Console\Command;
use App\Services\Admin\api\ExternalApiService;
use App\Models\Institute;
use App\Models\ReqCourse;
use App\Models\NvqCourses;
use App\Models\NVQLevel;
use App\Models\NvqQualification;
use App\Models\Package;
use App\Models\TvetType;

class SyncApiData extends Command
{
    protected $signature = 'sync:apidata';

    protected $description = 'Sync API data with the database';

    private $apiService;

    public function __construct(ExternalApiService $apiService)
    {
        parent::__construct();
        $this->apiService = $apiService;
    }
    public function handle()
    {
        \Log::info('🔄 Starting synchronization from TVEC (API4)');
         //Đồng bộ dữ liệu head_office
         $headOfficesData = $this->apiService->getApiDataHeadOffices();
         if ($headOfficesData) {
             if (is_array($headOfficesData)) {
                 TvetType::updateOrInsert(
                     ['head_office_code' =>'TVEC'],
                     [
                         'head_office_name' => 'Tertiary & Vocational Education Commission',
                     ]
                 );
                 foreach ($headOfficesData as $headOffice) {
                     if (is_array($headOffice)) {
                         TvetType::updateOrInsert(
                             ['head_office_code' => $headOffice['message']['HEAD_OFFICE_CODE']],
                             [
                                 'head_office_name' => $headOffice['message']['HEAD_OFFICE_NAME'],
                             ]
                         );
                     } else {
                         $this->error('Invalid head office data format.');
                     }
                 }
                 TvetType::updateOrInsert(
                    ['head_office_code' =>'WOHO'],
                    [
                        'head_office_name' => 'Without Head Office',
                    ]
                 );
                 $this->info('Head office data synced successfully');
             } else {
                 $this->error('Invalid data format received from API.');
             }
         } else {
             $this->error('No data received from API or invalid response structure.');
         }
        // Đồng bộ dữ liệu INSTITUTE
        $instituteData = $this->apiService->getApiDataInstitute();
        if ($instituteData) {
            if (is_array($instituteData)) {
                foreach ($instituteData as $institute) {
                    if (is_array($institute)) {
                        Institute::updateOrInsert(
                            ['reg_no' => $institute['message']['INSTITUTE_REG_NO']],
                            [
                                'name' => $institute['message']['INSTITUTE_NAME'],
                                'dist_id' => $institute['message']['DISTRICT_CODE'],
                                'district_name' => $institute['message']['DISTRICT_NAME'],
                                'address' => $institute['message']['ADDRESS'],
                                'phone' => $institute['message']['TELEPHONE'],
                                'valid_from' => $institute['message']['VALID_FROM'],
                                'valid_to' => $institute['message']['VALID_TO'],
                                'ds_id' => $institute['message']['DS_DIVISION'],
                                'ownership' => $institute['message']['OWNERSHIP'],
                                'active_status' => $institute['message']['ACTIVE_STATUS'],
                                'institute_head_office' => !empty($institute['message']['INSTITUTE_HEAD_OFFICE']) ? $institute['message']['INSTITUTE_HEAD_OFFICE'] : 'WOHO',
                            ]
                        );
                    } else {
                        $this->error('Invalid institute data format.');
                    }
                }
                //New institute is not in TVET
                Institute::updateOrInsert(
                    ['reg_no' => 'P01/0000'],
                    [
                        'name' => 'Other (Non-TVET Institute)',
                        'dist_id' => null,
                        'district_name' => null,
                        'address' => null,
                        'phone' => '0111111111',
                        'valid_from' => '2024-02-27',
                        'valid_to' => '2050-02-26',
                        'ds_id' => null,
                        'ownership' => null,
                        'active_status' => 'Active',
                        'institute_head_office' => 'WOHO',
                    ]
                );

                $this->info('Institute data synced successfully');
            } else {
                $this->error('Invalid data format received from API.');
            }
        } else {
            $this->error('No data received from API or invalid response structure.');
        }

        // Đồng bộ dữ liệu REG_COURSES
        $regCoursesData = $this->apiService->getApiDataREGCOURSES();
        if ($regCoursesData) {
            if (is_array($regCoursesData)) {
                foreach ($regCoursesData as $course) {
                    if (is_array($course)) {
                        ReqCourse::updateOrInsert(
                            ['course_id' => $course['message']['COURSE_ID']],
                            [
                                'institute_reg_no' => $course['message']['INSTITUTE_REG_NO'],
                                'institute_name' => $course['message']['INSTITUTE_NAME'],
                                'district_code' => $course['message']['DISTRICT_CODE'],
                                'course_name' => $course['message']['COURSE_NAME'],
                                'course_duration' => $course['message']['COURSE_DURATION'],
                                'course_mode' => $course['message']['COURSE_MODE'],
                                'course_medium' => $course['message']['COURSE_MEDIUM'],
                                'entry_qualification' => $course['message']['ENTRY_QUALIFICATION'],
                               'industry_sector' => !empty($institute['message']['INDUSTRY_SECTOR']) ? $institute['message']['INDUSTRY_SECTOR'] : '',
                            ]
                        );
                    } else {
                        $this->error('Invalid RegCourses data format.');
                    }
                }
                $this->info('RegCourses data synced successfully');
            } else {
                $this->error('Invalid data format received from API.');
            }
        } else {
            $this->error('No RegCourses data received from API or invalid response structure.');
        }
        // Đồng bộ dữ liệu NVQ_COURSES
        $nvqCoursesData = $this->apiService->getApiDataNVQCOURSES();
        if ($nvqCoursesData) {
            if (is_array($nvqCoursesData)) {
                foreach ($nvqCoursesData as $nvqCourse) {
                    if (is_array($nvqCourse)) {
                        NvqCourses::updateOrInsert(
                            ['course_id' => $nvqCourse['message']['COURSE_ID']],
                            [
                                'course_name' => $nvqCourse['message']['COURSE_NAME'],
                                'level' => $nvqCourse['message']['NVQ_LEVELS'],
                                'ncs_code' => $nvqCourse['message']['NCS_CODE'],
                                'ncs_name' => $nvqCourse['message']['NCS_NAME'],
                                'reg_no' => $nvqCourse['message']['INSTITUTE_REG_NO'],
                                'industry_sector' => !empty($institute['message']['INDUSTRY_SECTOR']) ? $institute['message']['INDUSTRY_SECTOR'] : '',
                            ]
                        );
                    } else {
                        $this->error('Invalid NVQ Courses data format.');
                    }
                }
                $this->info('NVQ Courses data synced successfully');
            } else {
                $this->error('Invalid data format received from API.');
            }
        }

        // Đồng bộ dữ liệu NVQ
        $packagesData = $this->apiService->getApiDataPACKAGES();
        if ($packagesData) {
            if (is_array($packagesData)) {
                foreach ($packagesData as $package) {
                    if (is_array($package)) {
                        NVQLevel::updateOrInsert(
                            ['code' => $package['message']['PACKAGE_CODE']],
                            [
                                'name' => $package['message']['PACKAGE_NAME'],
                                'version' => $package['message']['PACKAGE_VERSION'],
                                'level' => $package['message']['PACKAGE_LEVEL'],
                                'ncs_code' => $package['message']['NCS_CODE'],
                                'ncs_name' => $package['message']['NCS_NAME'],
                            ]
                        );
                    } else {
                        $this->error('Invalid NVQ data format.');
                    }
                }
                $this->info('NVQ data synced successfully');
            } else {
                $this->error('Invalid data format received from API.');
            }
        } else {
            $this->error('No NVQ data received from API or invalid response structure.');
        }

        // Đồng bộ dữ liệu PACKAGE
        $packagesData = $this->apiService->getApiDataPACKAGES();
        if ($packagesData) {
            if (is_array($packagesData)) {
                foreach ($packagesData as $package) {
                    if (is_array($package)) {
                        NvqQualification::updateOrInsert(
                            ['nvq_id' => $package['message']['PACKAGE_CODE']],
                            [
                                'nvq_name' => $package['message']['PACKAGE_NAME'],
                                'version' => $package['message']['PACKAGE_VERSION'],
                                'nvq_level' => $package['message']['PACKAGE_LEVEL'],
                                'ncs_code' => $package['message']['NCS_CODE'],
                                'ncs_name' => $package['message']['NCS_NAME']??'',
                            ]
                        );
                    } else {
                        $this->error('Invalid Packages data format.');
                    }
                }
                $this->info('Packages data synced successfully');
            } else {
                $this->error('Invalid data format received from API.');
            }
        } else {
            $this->error('No Packages data received from API or invalid response structure.');
        }

        \Log::info('✅ Synchronization from TVEC (API4) completed.');
    }
}
