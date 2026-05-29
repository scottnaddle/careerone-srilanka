<?php

use function PHPSTORM_META\map;

return [

    /*
     * --------------------------------------------------------------------------
     * CGO Language Lines
     * ---------------------- ----------------------------------------------------
     *
     * The following language lines are used during CGO for various
     */

    'menu' => [
        'home' => 'Home',
        'about_us' => 'About us',
        'career_guidance' => [
            'root' => 'Career guidance',
            'guidance'=>"Guidance",
            'career_test' => 'Career test',
            'counseling' => [
                'root' => 'Guidance',
                'my_schedule' => 'My schedule',
                'counseling_list' => 'Guidance list',
            ],
            'employment' => [
                'root' => 'Employment',
                'employment_policy' => 'Related policies',
                'news_letter' => 'Newsletter',
            ],
            'job_information' => [
                'root' => 'Job/Career information',
                'job_information' => 'Job information',
                'career_expert_interview' => 'Career expert interviews',
            ],
            'career_guidance' => 'Career guidance',
        ],
        'job_support' => [
            'root' => 'Job support',
            'trainee_list' => 'Trainee list',
            'company_list' => 'Company list',
            'job_list' => 'Job list',
            'ojt_list' => 'OJT list',
        ],
        'information' => [
            'root' => 'Information',
            'content_management' => [
                'root' => 'Content management',
                'video' => 'Video',
                'document' => 'Document',
                'resource' => 'Resource',
                'peer_content_list' => 'Peer review content list',
            ],
            'event' => 'Events',
            'qna' => 'Q&A',
            'notice' => [
                'root' => 'Notice',
                'notice' => 'Notice',
                'faq' => 'FAQ',
            ]
        ]
    ],
    'career_guidance' => [
        'career_test' => [
            'title' => 'Career test',
            'list' => 'Career test list',
        ],
        'job_information' => [
            'root' => 'Job/Career information',
            'job_information' => 'Job information',
            'career_expert_interview' => [
                'root' => 'Job/Career information',
                'breadcum' => 'Career expert interviews',
                'search' => 'Search',
                'filterResults' => 'Results'
            ]
        ],
    ],
    'cgo_confirm' => 'Cgo Confirm',
    'counseling' => 'Guidance',
    'counseling_field' => 'Guidance Field',
    'kind' => 'Kind',
    'friendly' => 'Friendly',
    'organized' => 'Organized',
    'good_service' => 'Good Service',
    'detailed' => 'Detailed',
    'weekly' => 'Weekly',
    'my_schedule' => 'My Schedule',
    'counseling_list' => 'Guidance list',
    'counseling_type' => 'Guidance Type',
    'new_counseling' => 'New Guidance',
    'search' => 'Search',
    'status' => 'Guidance status',
    'type' => 'Type',
    'request' => 'Request',
    'requested' => 'Requested',
    'confirm' => 'Confirm',
    'completed' => 'Completed',
    'online' => 'Online Guidance',
    'offline_cgo' => 'Offline CGO',
    'offline' => 'Offline Guidance',
    'consulting' => 'Consulting',
    'title' => 'Title',
    'registration_date' => 'Registration Date',
    'closing_date'=>'Closing Date',
    'consulting_date' => 'Consulting Date',
    'counseling_date' => 'Guidance Date',
    'trainee_instruction' => 'Trainee Instruction',
    'trainee_name' => 'Trainee Name',
    'feedback' => 'Feedback',
    'submit' => 'Submit',
    'description' => 'Description',
    'first_name' => 'First Name',
    'last_name' => 'Last Name',
    'reject' => 'Reject',
    'detail_information' => 'Detailed Information',
    'error_toastify' => 'Something went wrong',
    'result' => 'Result',
    'cgo_final'=>'CGO Final Result',
    'available_time' => 'Available Time',
    'deny' => 'Deny',
    'canceled' => 'Cancelled',
    'cancel' => 'Cancel',
    'no_dot' => 'No.',
    'action' => 'Action',
    'view_more' => 'View more',
    'competition' => 'Competition',
    'job_fair' => 'Job Fair',
    'announcement' => 'Announcement',
    'notice' => 'Notice',
    'result_choice' => '{0} :count Results|{1} 1 Result|[2,*] :count Results',
    'suggested_training_information' => 'Suggested Training Information',
    'schedule' => [
        'sun' => 'Sun',
        'mon' => 'Mon',
        'tue' => 'Tue',
        'wed' => 'Wed',
        'thu' => 'Thu',
        'fri' => 'Fri',
        'sat' => 'Sat',
        'january' => 'January',
        'february' => 'February',
        'schedule.march' => 'March',
        'march' => 'March',
        'april' => 'April',
        'may' => 'May',
        'june' => 'June',
        'july' => 'July',
        'august' => 'August',
        'september' => 'September',
        'october' => 'October',
        'schedule.november' => 'November',
        'november' => 'November',
        'december' => 'December',
    ],
    'pick_a_time' => 'Pick a time',
    'hours.picker' => '{0}:count Hours|{1} 1 Hour|[2,*]:count Hours',
    'minutes.picker' => ':minutes Minutes',
    'counseling_cancel' => 'Guidance Cancelled',
    'none' => 'None',
    'more' => 'More',
    'filterResult' => 'Results',
    'job_support' => [
        'trainee_list' => [
            'root' => 'Trainee list',
            'updated' => 'Updated',
            'search' => 'Search',
            'job_detail' => [
                'root' => 'Job details',
                'title' => 'Title',
                'job_type' => 'Job type',
                'discussion_available' => 'Discussion Available',
                'contract_type' => [
                    'contract_base' => 'Contract-based',
                    'permanent' => 'Permanent',
                ],
                'sector' => 'Job category',
                'work_condition' => [
                    'root' => 'Work condition',
                    'working_day' => 'Working day',
                    'working_hour' => 'Working hour',
                    'salary_per_month' => 'Salary per month'
                ],
                'application_requirements' => [
                    'root' => 'Application Requirements',
                    'gender' => [
                        'root' => 'Gender',
                        'male' => 'Male',
                        'female' => 'Female',
                        'na' => 'N/A',
                    ],
                    'age_limitation' => 'Age limitation',
                    'required_work_experience' => 'Required work experience',
                    'required_skills' => 'Required skills',
                    'application_deadline' => [
                        'root' => 'Application deadline',
                        'select_date' => 'Select date',
                    ],
                    'hr_information' => [
                        'root' => 'HR Information',
                        'name' => 'Name',
                        'email' => 'Email',
                        'contact_info' => 'Contact info',
                        'about_the_role' => 'About the role',
                        'role' => 'Role',
                    ]
                ],
                'match' => 'Match',
                'unmatch' => 'Unmatch',
                'unmatch_confirm_modal' => [
                    'message' => 'Are you sure you want to unmatch this trainee?',
                    'confirm' => "Yes, I'm sure",
                    'cancel' => 'No, cancel'
                ],
                'not_limitation' => 'No limitation',
            ],
            'ojt_match' => [
                'root' => 'Trainee list',
                'breadcum' => 'OJT match',
                'trainee_name' => 'Trainee name',
                'search_position' => [
                    'root' => 'Search Position',
                    'ojt_name_placeholder' => 'Electrician',
                    'district' => 'District',
                    'sector' => 'Job category',
                    'search' => 'Search',
                    'filterResults' => 'Results',
                    'filter' => [
                        'all' => 'All',
                        'match' => 'Match',
                        'unmatch' => 'Unmatch'
                    ],
                ],
                'table' => [
                    'label' => [
                        'company' => 'Company',
                        'ojt_title' => 'OJT title',
                        'district' => 'District',
                        'nvq_level' => 'NVQ Level',
                        'number_of_recruitment' => 'Number Of Recruitments',
                        'registration_date' => 'Registration Date',
                        'closing_date'=>'Closing Date',
                        'status' => [
                            'root' => 'Status',
                            'close' => 'Closed',
                            'progress' => 'In Progress'
                        ],
                        'ojt_match' => 'OJT Match'
                    ],
                ],
                'ojt_detail' => [
                    'root' => 'OJT Match',
                    'pageTitle' => 'OJT Detail',
                    'title' => 'Title',
                    'job_type' => 'Job type',
                    'discussion_available' => 'Discussion Available',
                    'contract_type' => [
                        'contract_base' => 'Contract-based',
                        'permanent' => 'Permanent',
                    ],
                    'sector' => 'Job catagory',
                    'work_condition' => [
                        'root' => 'Work condition',
                        'working_day' => 'Working day',
                        'working_hour' => 'Working hour',
                        'salary_per_month' => 'Salary per month'
                    ],
                    'application_requirements' => [
                        'root' => 'Application Requirements',
                        'gender' => [
                            'root' => 'Gender',
                            'male' => 'Male',
                            'female' => 'Female',
                            'na' => 'N/A',
                        ],
                        'age_limitation' => 'Age limitation',
                        'required_work_experience' => 'Required work experience',
                        'required_skills' => 'Required skills',
                        'application_deadline' => [
                            'root' => 'Application deadline',
                            'select_date' => 'Select date',
                        ],
                        'hr_information' => [
                            'root' => 'Inquiries',
                            'name' => 'Name',
                            'email' => 'Email',
                            'contact_info' => 'Contact info',
                            'job_role' => 'About the role',
                            'role' => 'Role',
                        ],
                    ],
                    'match' => 'Match',
                    'unmatch' => 'Unmatch',
                    'unmatch_confirm_modal' => [
                        'message' => 'Are you sure you want to unmatch this trainee?',
                        'confirm' => "Yes, I'm sure",
                        'cancel' => 'No, cancel'
                    ],
                    'not_limitation' => 'No limitation',
                    'attached_file' => 'Attached file'
                ]
            ],
            'job_match' => [
                'root' => 'Job match',
                'breadcum' => 'List Job',
                'trainee_name' => 'Trainee name',
                'search_position' => [
                    'root' => 'Search Position',
                    'job_name_placeholder' => 'Job',
                    'district' => 'District',
                    'sector' => 'Job catagory',
                    'search' => 'Search',
                    'filterResults' => 'Results',
                    'filter' => [
                        'all' => 'All',
                        'match' => 'Match',
                        'unmatch' => 'Unmatch'
                    ],
                ],
                'table' => [
                    'label' => [
                        'company' => 'Company',
                        'job_title' => 'Job title',
                        'registration_date' => 'Registration Date',
                        'end_date' => 'Closing date',
                        'applied' => 'Applied',
                        'matched' => 'Matched',
                        'job_match' => 'Job Match',
                        'shortlist'=>'Shortlist'
                    ],
                ]
            ]
        ],
        'company_list' => [
            'root' => 'Company list',
            'search' => 'Search',
            'filterResult' => 'Results',
            'searchPlaceholder' => 'Search',
            'no_record' => 'No record!',
            'filter' => [
                'district' => 'District',
                'recently' => 'Recent',
                'oldest' => 'Old',
                'company_information' => 'Company information',
                'type_of_enterprise' => 'Type of Enterprise',
            ],
            'jobLabel' => 'Jobs',
            'job_list' => [
                'root' => 'Company list',
                'search' => 'Search',
                'table' => [
                    'label' => [
                        'job_title' => 'Job title',
                        'company_name' => 'Company name',
                        'registration_date' => 'Registration date',
                        'closing_date'=>'Closing Date',
                        'end_date' => 'Closing date',
                        'applied' => 'Applied',
                        'matched' => 'Matched'
                    ]
                ],
                'job_detail' => [
                    'root' => 'Job details',
                    'title' => 'Title',
                    'job_type' => 'Job type',
                    'discussion_available' => 'Discussion Available',
                    'contract_type' => [
                        'contract_base' => 'Contract-based',
                        'permanent' => 'Permanent',
                    ],
                    'sector' => 'Job catagory',
                    'work_condition' => [
                        'root' => 'Work condition',
                        'working_day' => 'Working day',
                        'working_hour' => 'Working hour',
                        'salary_per_month' => 'Salary per month',
                        'select_date' => 'Select date',
                    ],
                    'application_requirements' => [
                        'root' => 'Application Requirements',
                        'gender' => [
                            'root' => 'Gender',
                            'male' => 'Male',
                            'female' => 'Female',
                            'na' => 'N/A',
                        ],
                        'age_limitation' => 'Age limitation',
                        'required_work_experience' => 'Required work experience',
                        'required_skills' => 'Required skills',
                        'application_deadline' => [
                            'root' => 'Application deadline',
                            'select_date' => 'Select date',
                        ],
                        'hr_information' => [
                            'root' => 'HR Information',
                            'name' => 'Name',
                            'email' => 'Email',
                            'contact_info' => 'Contact info',
                            'about_the_role' => 'About the role',
                            'role' => 'Role',
                        ]
                    ],
                    'match' => 'Match',
                    'unmatch' => 'Unmatch',
                    'unmatch_confirm_modal' => [
                        'message' => 'Are you sure you want to unmatch this trainee?',
                        'confirm' => "Yes, I'm sure",
                        'cancel' => 'No, cancel'
                    ],
                    'not_limitation' => 'No limitation',
                ]
            ]
        ],
        'job_list' => [
            'root' => 'Job list',
            'search' => 'Search',
            'filterResult' => 'Results',
            'searchPlaceholder' => 'Job',
            'filter' => [
                'sector' => 'Job catagory',
                'district' => 'District',
                'recently' => 'Recent',
                'oldest' => 'Old'
            ],
            'table' => [
                'label' => [
                    'job_title' => 'Job title',
                    'company_name' => 'Company name',
                    'registration_date' => 'Registration date',
                    'closing_date'=>'Closing Date',
                    'end_date' => 'Closing date',
                    'applied' => 'Applied',
                    'matched' => 'Matched',
                    'status' => 'Status',
                    'job_match'=>'Job Match'
                ]
            ],
            'job_detail' => [
                'root' => 'Job details',
                'title' => 'Title',
                'job_type' => 'Job type',
                'discussion_available' => 'Discussion Available',
                'contract_type' => [
                    'contract_base' => 'Contract-based',
                    'permanent' => 'Permanent',
                ],
                'sector' => 'Job category',
                'work_condition' => [
                    'root' => 'Work condition',
                    'working_day' => 'Working day',
                    'working_hour' => 'Working hour',
                    'salary_per_month' => 'Salary per month',
                    'select_date' => 'Select date',
                ],
                'application_requirements' => [
                    'root' => 'Application Requirements',
                    'gender' => [
                        'root' => 'Gender',
                        'male' => 'Male',
                        'female' => 'Female',
                        'na' => 'N/A',
                    ],
                    'age_limitation' => 'Age limitation',
                    'required_work_experience' => 'Required work experience',
                    'required_skills' => 'Required skills',
                    'application_deadline' => [
                        'root' => 'Application deadline',
                        'select_date' => 'Select date',
                    ],
                    'hr_information' => [
                        'root' => 'HR Information',
                        'name' => 'Name',
                        'email' => 'Email',
                        'contact_info' => 'Contact info',
                        'about_the_role' => 'About the role',
                        'role' => 'Role',
                    ]
                ],
                'match' => 'Match',
                'unmatch' => 'Unmatch',
                'unmatch_confirm_modal' => [
                    'message' => 'Are you sure you want to unmatch this trainee?',
                    'confirm' => "Yes, I'm sure",
                    'cancel' => 'No, cancel'
                ],
                'not_limitation' => 'No limitation',
            ],
            'candidate_list' => [
                'title' => 'Candidate list',
                'search' => 'Search',
                'filterResult' => 'Results',
                'no_record' => 'No record!',
                'filter' => [
                    'all_type' => 'Type',
                    'candidate' => 'Candidate',
                    'job_match' => 'Job match'
                ],
                'modal' => [
                    'title' => 'Resume',
                ],
                'updated' => 'Updated',
                'job_title' => 'Job title'
            ],
        ],
        'ojt_list' => [
            'root' => 'OJT Information',
            'search' => 'Search',
            'filterResults' => 'Results',
            'no_record' => 'No record!',
            'not_limitation' => 'Not limit',
            'filter' => [
                'nvq_level' => 'NVQ Level',
                'district' => 'District',
                'sector' => 'Job category',
                'company' => 'Select company',
                'sort' => 'Sort by',
                'status' => 'Status',
                'progress' => 'Progress',
                'cancel' => 'Cancel',
                'recently' => 'Recent',
                'completed'=>'Completed',
                'oldest' => 'Old'
            ],
            'table' => [
                'label' => [
                    'company' => 'Company',
                    'ojt_title' => 'OJT title',
                    'district' => 'District',
                    'nvq_level' => 'NVQ Level',
                    'number_of_recruitment' => 'Number Of Recruitments',
                    'registration_date' => 'Registration Date',
                    'closing_date'=>'Deadline',
                    'required_work_experience' => 'Required work experience',
                    'required_skills' => 'Required skills',
                    'status' => [
                        'root' => 'Status',
                        'close' => 'Closed',
                        'progress' => 'In Progress',
                    ],
                    'ojt_match' => 'OJT match'
                ],
                'trainee_match_button' => 'Trainee match',
                'list_matched' => 'Matched List ',
                'list_applied' => 'Applied List ',
            ],
            'mobileFilter' => [
                'district' => 'District',
                'nvq_level' => 'NVQ Level',
                'sector' => 'Job catagory',
                'readmore' => 'Read more',
                'apply' => 'Apply',
                'reset' => 'Reset'
            ],
            'trainee_match' => [
                'root' => 'Trainee Match',
                'trainee_apply' => 'Trainee Apply',
                'search' => 'Search',
                'filterResults' => 'Results',
                'updated' => 'Updated',
                'ojt_match_button' => 'OJT Match',
                'filter' => [
                    'all' => 'All',
                    'keep' => 'Keep',
                    'unkeep' => 'Unkeep'
                ],
                'trainee_information' => [
                    'root' => 'Trainee Information',
                    'basic_information' => 'Basic Information',
                    'about_me' => 'About me',
                    'education' => 'Education',
                    'certificate' => 'Certificate',
                    'experience' => 'Experience',
                    'expertise' => 'Expertise',
                    'language' => 'Language',
                    'match_button' => 'Match',
                    'unmatch_button' => 'Unmatch'
                ]
            ],
            'list_matched' => [
                'root' => 'OJT Matched',
                'search' => 'Search',
                'filterResults' => 'Results',
                'updated' => 'Updated',
                'trainee_information' => 'Trainee information',
                'ojt_match' => 'OJT match',
                'ojt_apply' => 'OJT Apply'
            ],
            'ojt_detail' => [
                'age_limitation' => 'Age limitation',
                'not_limitation' => 'Not limitation',
                'require_work_experience' => 'Require work experience',
                'required_skills' => 'Required skills',
                'application_deadline' => 'Application deadline',
                'application_requirements' => 'Application requirements',
                'gender' => [
                    'root' => 'Gender',
                    'male' => 'Male',
                    'female' => 'Female',
                    'na' => 'N/A',
                ],
                'inquires' => [
                    'root' => 'Inquires',
                    'hr_name' => 'HR name',
                    'hr_email' => 'HR email',
                    'hr_contact_info' => 'HR contact info',
                ]
            ]
        ]
    ],
    'change_cgo' => 'Change CGO',
    'select_cgo' => 'Select CGO',
    'note_change_cgo' => 'Note: Changing the CGO User will cancel this request for guidance',
    'confirm_counseling' => 'Confirm Counseling',
    'tvec_information' => 'TVEC Information',
    'choose_tvec_information' => 'Choose some informations for guidance',
    'select_institute' => 'Select institute(s)',
    'select_tvec_course' => 'Select TVEC Course(s)',
    'select_nvq_course' => 'Select NVQ Course(s)',
    'go_to_tvec_site' => 'Go to TVEC Search information site',
    'done' => 'Done',
    'reset' => 'Reset',
    'close' => 'Close',
    'institutes' => 'Institutes',
    'nvq_courses' => 'NVQ Courses',
    'tvec_courses' => 'TVEC Courses',
    'requested_information' => 'Requested Information',
    'requested_date' => 'Requested date',
    'location' => 'Location',
    'institute' => 'Institute',
    'cancel_message' => 'Please write the reason for not approving the following candidate.',
    'feedback_message' => 'This is feedback from the following Trainee',
    'no_information' => 'No information',
    'guidance_field' => 'Guidance Field',
    'date' => 'Date',
    'trainee_nic' => 'Trainee NIC',
    'trainee_mobile' => 'Trainee\'s mobile',
    'trainee_email' => 'Trainee\'s email',
    'trainee_information' => 'Trainee\'s information',
    'temporary_save' => 'Temporary Save',
    'job_matched' => 'Job Matched',
    'job_applied' => 'Job Applied',
    'Trainee Institute' => 'Trainee Institute',
    'Select a title' => 'Select a title',
    'Details' => 'Details',
    'TVET Courses' => 'TVET Courses',
    'Search by institute name or registration number...' => 'Search by institute name or registration number...',
    'Search by course name or registration number...' => 'Search by course name or registration number...',
    'No.' => 'No.',
    'Get the latest news' => 'Get the latest news',
    'Technical and Vocational Education Training'=> 'Technical and Vocational Education Training',
    'Register' => 'Register',
    'Register a new Guidance' => 'Register a new Guidance',
    'User Manual' => 'User Manual',
    'Monthly' => 'Monthly',
    'Previous Month' => 'Previous Month',
    'Next Month' => 'Next Month',
];
