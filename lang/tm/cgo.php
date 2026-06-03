<?php

use function PHPSTORM_META\map;

return [

    /*
     * --------------------------------------------------------------------------
     * CGO மொழி வரிகள்
     * --------------------------------------------------------------------------
     *
     * CGO இல் பல்வேறு சந்தர்ப்பங்களில் பயன்படுத்தப்படும் மொழி வரிகள்
     */

    'menu' => [
        'home' => 'முகப்பு',
        'about_us' => 'எம்மைப்பற்றி',
        'career_guidance' => [
            'root' => 'தொழில் வழிகாட்டல்',
            'guidance'=>"ஆலோசனை",
            'career_test' => 'தொழில் சோதனை',
            'counseling' => [
                'root' => 'வழிகாட்டல்',
                'my_schedule' => 'எனது அட்டவணை',
                'counseling_list' => 'வழிகாட்டல்  பட்டியல்',
            ],
            'employment' => [
                'root' => 'வேலைவாய்ப்பு',
                'employment_policy' => 'தொடர்புடைய கொள்கைகள்',
                'news_letter' => 'செய்திமடல்',
            ],
            'job_information' => [
                'root' => 'வேலை/தொழில் தகவல்கள்',
                'job_information' => 'வேலை பார்வை (Job Outlook)',
                'career_expert_interview' => 'தொழில் நிபுணர் நேர்காணல்',
            ],
            'career_guidance' => 'தொழில் வழிகாட்டல்',
        ],
        'job_support' => [
            'root' => 'வேலை உதவி',
            'trainee_list' => 'பயிலுநர் பட்டியல்',
            'company_list' => 'தொழில்தருர் பட்டியல்',
            'job_list' => 'வேலை பட்டியல்',
            'ojt_list' => 'OJT பட்டியல்',
        ],
        'information' => [
            'root' => 'தகவல்கள்',
            'content_management' => [
                'root' => 'உள்ளடக்க முகாமைத்துவம்',
                'video' => 'வீடியோ',
                'document' => 'ஆவணம்',
                'resource' => 'வளம்',
                'peer_content_list' => 'சக மதிப்பாய்வு உள்ளடக்கப் பட்டியல்',
            ],
            'event' => 'நிகழ்வு',
            'qna' => 'கேள்வி மற்றும் பதில',
            'notice' => [
                'root' => 'அறிவித்தல்',
                'notice' => 'அறிவித்தல்',
                'faq' => 'அடிக்கடி கேட்கப்படும் கேள்விகள்',
            ]
        ]
    ],
    'career_guidance' => [
        'career_test' => [
            'title' => 'தொழில் சோதனை',
            'list' => 'தொழில் சோதனை பட்டியல்',
        ],
        'job_information' => [
            'root' => 'வேலை/தொழில் தகவல்கள்',
            'job_information' => 'வேலை பார்வை (Job Outlook)',
            'career_expert_interview' => [
                'root' => 'வேலை/தொழில் தகவல்கள்',
                'breadcum' => 'தொழில் நிபுணர் பேட்டி',
                'search' => 'தேடுக',
                'filterResults' => 'filterResults'
            ]
        ],
    ],
    'cgo_confirm' => 'Cgo Confirm',
    'counseling' => 'ஆலோசனை',
    'counseling_field' => 'வழிகாட்டல் துறை',
    'kind' => 'அன்பு',
    'friendly' => 'நட்பாக',
    'organized' => 'ஒழுங்கானது',
    'good_service' => 'சிறந்த சேவை',
    'detailed' => 'விரிவான',
    'weekly' => 'வாராந்த',
    'my_schedule' => 'எனது அட்டவணை',
    'counseling_list' => 'வழிகாட்டல்  பட்டியல்',
    'counseling_type' => 'வழிகாட்டல் வகை',
    'new_counseling' => 'புதிய வழிகாட்டல்',
    'search' => 'தேடுக',
    'status' => 'வழிகாட்டல் நிலை',
    'type' => 'வகை',
    'request' => 'கோரிக்கை',
    'requested' => 'கோரப்பட்டது',
    'confirm' => 'உறுதிசெய்யவும்',
    'completed' => 'பூர்த்திசெய்யப்பட்டது',
    'online' => 'ஆன்லைன்',
    'offline_cgo' => 'அகல்நிலை (Offline) CGO',
    'offline' => 'ஆஃப்லைன்',
    'consulting' => 'ஆலோசனை',
    'title' => 'தலைப்பு',
    'registration_date' => 'பதிவுத் திகதி',
    'consulting_date' => 'வழிகாட்டல் திகதி',
    'closing_date'=>'இறுதி திகதி',
    'counseling_date' => 'வழிகாட்டல் திகதி',
    'trainee_instruction' => 'பயிலுநர் அறிவுறுத்தல்',
    'trainee_name' => 'பயிலுநரின்  பெயர்',
    'feedback' => 'பின்னூட்டம் (Feedback)',
    'submit' => 'சமர்ப்பிக்கவும்',
    'description' => 'விளக்கம்',
    'first_name' => 'முதல் பெயர்',
    'last_name' => 'கடைசி பெயர்',
    'reject' => 'நிராகரிக்கவும்',
    'detail_information' => 'விரிவான தகவல்',
    'error_toastify' => 'எதோ தவறு ஏற்பட்டுள்ளது',
    'result' => 'முடிவு',
    'available_time' => 'கிடைக்கும் நேரம்',
    'deny' => 'மறுக்கவும்',
    'canceled' => 'ரத்து செய்யப்பட்டுள்ளது',
    'cancel' => 'ரத்து செய்யவும்',
    'no_dot' => 'இல.',
    'action' => 'நடவடிக்கை',
    'view_more' => 'மேலும் பார்க்க',
    'competition' => 'போட்டி',
    'job_fair' => 'வேலை கண்காட்சி',
    'announcement' => 'அறிவிப்பு',
    'notice' => 'அறிவித்தல்',
    'result_choice' => '{0} :count முடிவுகள்|{1} 1 முடிவு|[2,*] :count முடிவுகள்',
    'suggested_training_information' => 'Suggested Training Information',
    'schedule' => [
        'sun' => 'ஞாயிறு',
        'mon' => 'திங்கள்',
        'tue' => 'செவ்வாய்',
        'wed' => 'புதன்',
        'thu' => 'வியாழன்',
        'fri' => 'வெள்ளி',
        'sat' => 'சனி',
        'january' => 'ஜனவரி',
        'february' => 'ஃபெப்ரவரி',
        'schedule.march' => 'மார்ச்',
        'march' => 'மார்ச்',
        'april' => 'ஏப்ரல்',
        'may' => 'மே',
        'june' => 'ஜூன்',
        'july' => 'ஜூலை',
        'august' => 'ஆகஸ்ட்',
        'september' => 'செப்தெம்பர்',
        'october' => 'அக்டோபர்',
        'schedule.november' => 'நவம்பர் ',
        'november' => 'நவம்பர் ',
        'december' => 'திசெம்பர்',
    ],
    'pick_a_time' => 'நேரத்தைத் தேர்ந்தெடுக்கவும்',
    'hours.picker' => '{0}:count மணிநேரம்|{1} 1 மணிநேரம்|[2,*]:count மணிநேரம்',
    'minutes.picker' => 'minutes.picker',
    'counseling_cancel' => 'ஆலோசனை ரத்து',
    'none' => 'இல்லை',
    'more' => 'மேலும் காண்க',
    'filterResult' => ' filterResult ',
    'job_support' => [
        'trainee_list' => [
            'root' => 'பயிற்சியாளர் பட்டியல்',
            'updated' => 'புதுப்பிக்கப்பட்டது',
            'search' => 'தேடுக',
            'job_detail' => [
                'root' => 'வேலை விபரங்கள்',
                'title' => 'தலைப்பு',
                'job_type' => 'வேலை வகை',
                'discussion_available' => 'கலந்துரையாடல் கிடைக்கும்',
                'contract_type' => [
                    'contract_base' => 'ஒப்பந்த அடிப்படையிலான',
                    'permanent' => 'நிரந்தர',
                ],
                'sector' => 'தொழிற்துறை',
                'work_condition' => [
                    'root' => 'தொழில் நிபந்தனைகள்',
                    'working_day' => 'வேலை நாட்கள்',
                    'working_hour' => 'வேலை நேரம் (மணித்தியாலங்களில்)',
                    'salary_per_month' => 'மாத சம்பளம்'
                ],
                'application_requirements' => [
                    'root' => 'விண்ணப்ப தேவைகள்',
                    'gender' => [
                        'root' => 'பாலினம்',
                        'male' => 'ஆண்',
                        'female' => 'பெண்',
                        'na' => ' na ',
                    ],
                    'age_limitation' => 'வயது வரம்பு',
                    'required_work_experience' => 'தேவைப்படும் தொழில் அனுபவம்',
                    'required_skills' => 'தேவைப்படும் திறன்கள்',
                    'application_deadline' => [
                        'root' => 'விண்ணப்ப இறுதித் திகதி',
                        'select_date' => 'திகதியைத் தேர்ந்தெடுக்கவும்',
                    ],
                    'hr_information' => [
                        'root' => 'HR தகவல்கள்',
                        'name' => 'பெயர்',
                        'email' => 'மின்னஞ்சல்',
                        'contact_info' => 'தொடர்பு தகவல்கள்',
                        'about_the_role' => 'வகிபாக (role) விவரங்கள்',
                        'role' => 'வகிபாகம் (role)',
                    ]
                ],
                'match' => 'பொருந்தும்',
                'unmatch' => 'பொருந்தாது',
                'unmatch_confirm_modal' => [
                    'message' => 'இந்த பயிற்சியாளரை பொருந்தாதவனாக்க விரும்புகிறீர்களா?',
                    'confirm' => 'ஆம், நிச்சயமாக',
                    'cancel' => 'இல்லை, ரத்து செய்க'
                ],
                'not_limitation' => 'வரம்பில்லை',
            ],
            'ojt_match' => [
                'root' => 'பயிற்சியாளர் பட்டியல்',
                'breadcum' => 'OJT பொருத்தம்',
                'trainee_name' => 'பயிலுநரின் பெயர்',
                'search_position' => [
                    'root' => 'தேடல் நிலை',
                    'ojt_name_placeholder' => 'மின்சார பொறியாளர்',
                    'district' => 'மாவட்டம்',
                    'sector' => 'தொழிற்துறை',
                    'search' => 'தேடுக',
                    'filterResults' => ' filterResults ',
                    'filter' => [
                        'all' => 'அனைத்து',
                        'match' => 'பொருத்தம்',
                        'unmatch' => 'பொருந்தாது'
                    ],
                ],
                'table' => [
                    'label' => [
                        'company' => 'கம்பனி',
                        'ojt_title' => 'OJT தலைப்பு',
                        'district' => 'மாவட்டம்',
                        'nvq_level' => 'NVQ மட்டம்',
                        'number_of_recruitment' => 'ஆட்சேர்ப்பு எண்ணிக்கை',
                        'registration_date' => ' பதிவுத்  திகதி',
                        'closing_date'=>'இறுதி திகதி',
                        'status' => [
                            'root' => 'நிலை',
                            'close' => 'மூடப்பட்டது',
                            'progress' => 'முன்னேற்றம்',
                        ],
                        'ojt_match' => 'OJT பொருத்தம்'
                    ],
                ],
                'ojt_detail' => [
                    'root' => 'OJT விபரங்கள்',
                    'pageTitle' => 'OJT விவரங்கள்',
                    'title' => 'தலைப்பு',
                    'job_type' => 'வேலை வகை',
                    'discussion_available' => 'பேச்சுவார்த்தைக்கு கிடைக்கும்',
                    'contract_type' => [
                        'contract_base' => 'ஒப்பந்த அடிப்படையிலான',
                        'permanent' => 'நிரந்தர',
                    ],
                    'sector' => 'தொழிற்துறை',
                    'work_condition' => [
                        'root' => 'தொழில் நிபந்தனைகள்',
                        'working_day' => 'வேலை நாட்கள்',
                        'working_hour' => 'வேலை நேரம் (மணித்தியாலங்கள்) ',
                        'salary_per_month' => 'மாத சம்பளம்'
                    ],
                    'application_requirements' => [
                        'root' => 'விண்ணப்ப தேவைகள்',
                        'gender' => [
                            'root' => 'பாலினம்',
                            'male' => 'ஆண்',
                            'female' => 'பெண்',
                            'na' => ' na',
                        ],
                        'age_limitation' => 'வயது வரம்பு',
                        'required_work_experience' => 'தேவைப்படும் தொழில் அனுபவம்',
                        'required_skills' => 'தேவைப்படும் திறன்கள்',
                        'application_deadline' => [
                            'root' => 'விண்ணப்ப இறுதித் திகதி',
                            'select_date' => 'திகதியைத் தேர்ந்தெடுக்கவும்',
                        ],
                        'hr_information' => [
                            'root' => 'HR தகவல்கள்',
                            'name' => 'பெயர்',
                            'email' => 'மின்னஞ்சல்',
                            'contact_info' => 'தொடர்பு தகவல்கள்',
                            'about_the_role' => 'வகிபாக (role) விவரங்கள்',
                            'role' => 'வகிபாகம் (role)',
                        ]
                    ],
                    'match' => 'பொருந்தும்',
                    'unmatch' => 'பொருந்தாது',
                    'unmatch_confirm_modal' => [
                        'message' => 'இந்த பயிற்சியாளரை பொருந்தாதவனாக்க விரும்புகிறீர்களா?',
                        'confirm' => 'ஆம், நிச்சயமாக',
                        'cancel' => 'இல்லை, ரத்து செய்க'
                    ],
                    'not_limitation' => 'வரம்பில்லை',
                    'attached_file' => 'இணைக்கப்பட்ட கோப்பு'
                ]
            ],
            'job_match' => [
                'root' => 'பயிற்சியாளர் பட்டியல்',
                'breadcum' => 'வேலை பட்டியல்',
                'trainee_name' => 'பயிலுநரின்  பெயர்',
                'search_position' => [
                    'root' => 'தேடல் நிலை',
                    'job_name_placeholder' => 'வேலை',
                    'district' => 'மாவட்டம்',
                    'sector' => 'தொழிற்துறை',
                    'search' => 'தேடுக',
                    'filterResults' => ' filterResults ',
                    'filter' => [
                        'all' => 'அனைத்து',
                        'match' => 'பொருத்தம்',
                        'unmatch' => 'பொருந்தாது'
                    ],
                ],
                'table' => [
                    'label' => [
                        'company' => 'தொழில்தருநர்',
                        'job_title' => 'வேலை தலைப்பு',
                        'registration_date' => 'பதிவுத் திகதி',
                        'end_date' => 'முடிவு திகதி',
                        'applied' => 'விண்ணப்பிக்கப்பட்டது',
                        'matched' => 'பொருந்தியது',
                        'job_match' => 'வேலை பொருத்தம்',
                        'shortlist'=> 'சுருக்கப்பட்ட பட்டியல்'
                    ],
                ]
            ]
        ],
        'company_list' => [
            'root' => 'கம்பனி பட்டியல்',
            'search' => 'தேடுக',
            'filterResults' => 'முடிவுகள்',
            'no_record' => 'பதிவுகள் எதுவும் இல்லை!',
            'not_limitation' => 'கட்டுப்பாடு இல்லை',
            'filter' => [
                'district' => 'மாவட்டம்',
                'recently' => 'சமீபத்திய',
                'oldest' => 'பழைய',
                'company_information' => 'தொழில்தருநரின் தகவல்',
                'type_of_enterprise' => 'நிறுவன வகை',
            ],
            'jobLabel' => 'வேலைகள்',
            'job_list' => [
                'root' => 'வேலை பட்டியல்',
                'search' => 'தேடுக',
                'table' => [
                    'label' => [
                        'job_title' => 'வேலை தலைப்பு',
                        'company_name' => 'கம்பனி பெயர்',
                        'registration_date' => ' பதிவுத்  திகதி',
                        'closing_date'=>'இறுதி திகதி',
                        'end_date' => 'முடிவு திகதி',
                        'applied' => 'விண்ணப்பிக்கப்பட்டது',
                        'matched' => 'பொருந்தியது',
                        'job_match'=>'வேலை பொருத்தம்',
                    ]
                ],
                'job_detail' => [
                    'root' => 'வேலை விபரங்கள்',
                    'title' => 'தலைப்பு',
                    'job_type' => 'வேலை வகை',
                    'discussion_available' => 'கலந்துரையாடல் கிடைக்கும்',
                    'contract_type' => [
                        'contract_base' => 'ஒப்பந்த அடிப்படையிலான',
                        'permanent' => 'நிரந்தர',
                    ],
                    'sector' => 'தொழிற்துறை',
                    'work_condition' => [
                        'root' => 'தொழில் நிபந்தனைகள்',
                        'working_day' => 'வேலை நாட்கள்',
                        'working_hour' => 'வேலை நேரம் (மணித்தியாலங்களில்)',
                        'salary_per_month' => 'மாத சம்பளம்',
                        'select_date' => 'திகதியைத் தேர்ந்தெடுக்கவும்',
                    ],
                    'application_requirements' => [
                        'root' => 'விண்ணப்ப தேவைகள்',
                        'gender' => [
                            'root' => 'பாலினம்',
                            'male' => 'ஆண்',
                            'female' => 'பெண்',
                            'na' => ' na',
                        ],
                        'age_limitation' => 'வயது வரம்பு',
                        'required_work_experience' => 'தேவைப்படும் தொழில் அனுபவம்',
                        'required_skills' => 'தேவைப்படும் திறன்கள்',
                        'application_deadline' => [
                            'root' => 'விண்ணப்ப இறுதித் திகதி',
                            'select_date' => 'திகதியைத் தேர்ந்தெடுக்கவும்',
                        ],
                        'hr_information' => [
                            'root' => 'HR தகவல்கள்',
                            'name' => 'பெயர்',
                            'email' => 'மின்னஞ்சல்',
                            'contact_info' => 'தொடர்பு தகவல்கள்',
                            'about_the_role' => 'வகிபாக (role) விவரங்கள்',
                            'role' => 'வகிபாகம் (role)',
                        ]
                    ],
                    'match' => 'பொருந்தும்',
                    'unmatch' => 'பொருந்தாது',
                    'unmatch_confirm_modal' => [
                        'message' => 'இந்த பயிற்சியாளரை பொருந்தாதவனாக்க விரும்புகிறீர்களா?',
                        'confirm' => 'ஆம், நிச்சயமாக',
                        'cancel' => 'இல்லை, ரத்து செய்க'
                    ],
                    'not_limitation' => 'வரம்பில்லை',
                ]
            ]
        ],
        'job_list' => [
            'root' => 'வேலை பட்டியல்',
            'search' => 'தேடுக',
            'filterResult' => ' filterResult ',
            'searchPlaceholder' => 'searchPlaceholde',
            'filter' => [
                'sector' => 'தொழிற்துறை',
                'district' => 'மாவட்டம்',
                'recently' => 'சமீபத்திய',
                'oldest' => 'பழைய'
            ],
            'table' => [
                'label' => [
                    'job_title' => 'வேலை தலைப்பு',
                    'company_name' => 'கம்பனி பெயர்',
                    'registration_date' => ' பதிவுத்  திகதி',
                    'closing_date'=>'இறுதி திகதி',
                    'end_date' => 'முடிவு திகதி',
                    'applied' => 'விண்ணப்பிக்கப்பட்டது',
                    'matched' => 'பொருந்தியது',
                    'status' => 'நிலை'
                ]
            ],
            'job_detail' => [
                'root' => 'வேலை விபரங்கள்',
                'title' => 'தலைப்பு',
                'job_type' => 'வேலை வகை',
                'discussion_available' => 'கலந்துரையாடல் கிடைக்கும்',
                'contract_type' => [
                    'contract_base' => 'ஒப்பந்த அடிப்படையிலான',
                    'permanent' => 'நிரந்தர',
                ],
                'sector' => 'தொழிற்துறை',
                'work_condition' => [
                    'root' => 'தொழில் நிபந்தனைகள்',
                    'working_day' => 'வேலை நாட்கள்',
                    'working_hour' => 'வேலை நேரம் (மணித்தியாலங்களில்)',
                    'salary_per_month' => 'மாத சம்பளம்',
                    'select_date' => 'திகதியைத் தேர்ந்தெடுக்கவும்',
                ],
                'application_requirements' => [
                    'root' => 'விண்ணப்ப தேவைகள்',
                    'gender' => [
                        'root' => 'பாலினம்',
                        'male' => 'ஆண்',
                        'female' => 'பெண்',
                        'na' => ' na ',
                    ],
                    'age_limitation' => 'வயது வரம்பு',
                    'required_work_experience' => 'தேவைப்படும் தொழில் அனுபவம்',
                    'required_skills' => 'தேவைப்படும் திறன்கள்',
                    'application_deadline' => [
                        'root' => 'விண்ணப்ப இறுதித் திகதி',
                        'select_date' => 'திகதியைத் தேர்ந்தெடுக்கவும்',
                    ],
                    'hr_information' => [
                        'root' => 'HR தகவல்கள்',
                        'name' => 'பெயர்',
                        'email' => 'மின்னஞ்சல்',
                        'contact_info' => 'தொடர்பு தகவல்கள்',
                        'about_the_role' => 'வகிபாக (role) விவரங்கள்',
                        'role' => 'வகிபாகம் (role) ',
                    ]
                ],
                'match' => 'பொருந்தும்',
                'unmatch' => 'பொருந்தாது',
                'unmatch_confirm_modal' => [
                    'message' => 'இந்த பயிற்சியாளரை பொருந்தாதவனாக்க விரும்புகிறீர்களா?',
                    'confirm' => 'ஆம், நிச்சயமாக',
                    'cancel' => 'இல்லை, ரத்து செய்க'
                ],
                'not_limitation' => 'வரம்பில்லை',
            ],
            'candidate_list' => [
                'title' => 'தேர்வுநாடி பட்டியல்',
                'search' => 'தேடுக',
                'filterResult' => 'முடிவுகள்',
                'no_record' => 'பதிவு இல்லை',
                'filter' => [
                    'all_type' => 'எல்லா வகைகள்',
                    'candidate' => 'தேர்வுநாடி',
                    'job_match' => 'வேலை பொருத்தம்'
                ],
                'modal' => [
                    'title' => 'Resume',
                ],
                'updated' => 'புதுப்பிக்கப்பட்டது',
                'job_title' => 'வேலை தலைப்பு'
            ],
        ],
        'ojt_list' => [
            'root' => 'OJT பட்டியல்',
            'search' => 'தேடுக',
            'filterResults' => 'முடிவுகள் ',
            'no_record' => 'பதிவு இல்லை!',
            'not_limitation' => 'வரம்பில்லை',
            'filter' => [
                'nvq_level' => 'NVQ மட்டம்',
                'district' => 'மாவட்டம்',
                'sector' => 'தொழிற்துறை',
                'company' => 'கம்பனி',
                'sort' => 'வரிசைப்படுத்துக',
                'status' => 'நிலை',
                'progress' => 'முன்னேற்றம்',
                'cancel' => 'ரத்து செய்யவும்',
                'recently' => 'சமீபத்தில்',
                'oldest' => 'பழையது',
                'completed'=>'முடிக்கப்பட்டது',
            ],
            'table' => [
                'label' => [
                    'company' => 'கம்பனி',
                    'ojt_title' => 'OJT தலைப்பு',
                    'district' => 'மாவட்டம்',
                    'nvq_level' => 'NVQ மட்டம்',
                    'number_of_recruitment' => 'ஆட்சேர்ப்பு எண்ணிக்கை',
                    'registration_date' => ' பதிவுத்  திகதி',
                    'closing_date'=>'இறுதி திகதி',
                    'required_work_experience' => 'தேவைப்படும் தொழில் அனுபவம்',
                    'required_skills' => 'தேவைப்படும் திறன்கள்',
                    'status' => [
                        'root' => 'நிலை',
                        'close' => 'மூடுக',
                        'progress' => 'முன்னேற்றம்',
                    ],
                    'ojt_match' => 'OJT பொருத்தம்'
                ],
                'trainee_match_button' => 'பயிலுநர் பொருத்த பொத்தான்',
                'list_matched' => 'பொருத்தமாக்கபட்ட பட்டியல்',
                'list_applied' => 'விண்ணப்பித்த பட்டியல்',
            ],
            'mobileFilter' => [
                'district' => 'மாவட்டம்',
                'nvq_level' => 'NVQ மட்டம்',
                'sector' => 'தொழிற்துறை',
                'readmore' => 'மேலும் படிக்க',
                'apply' => 'விண்ணப்பிக்கவும்',
                'reset' => 'மீளமைவு (reset)'
            ],
            'trainee_match' => [
                'root' => 'பயிலுநர் பொருத்தம்',
                'trainee_apply' => 'பயிற்சியாளர் விண்ணப்பிக்கவும்',
                'search' => 'தேடுக',
                'filterResults' => ' filterResults ',
                'updated' => 'புதுப்பிக்கப்பட்டது',
                'ojt_match_button' => 'OJT பொருத்தம்',
                'filter' => [
                    'all' => 'அனைத்தும்',
                    'keep' => 'வைத்துக்கொள்க',
                    'unkeep' => 'வைக்கவில்லை'
                ],
                'trainee_information' => [
                    'root' => 'பயிலுநர் தகவல்',
                    'basic_information' => 'அடிப்படைத் தகவல்',
                    'about_me' => 'என்னைப் பற்றி',
                    'education' => 'கல்வி',
                    'certificate' => 'சான்றிதழ்',
                    'experience' => 'அனுபவம்',
                    'expertise' => 'நிபுணத்துவம்',
                    'language' => 'மொழி',
                    'match_button' => 'பொருத்த பொத்தான்',
                    'unmatch_button' => 'பொருந்தாத பொத்தான்'
                ]
            ],
            'list_matched' => [
                'root' => 'OJT பொருத்தம்',
                'search' => 'தேடுக',
                'filterResults' => 'முடிவுகள்',
                'updated' => 'புதுப்பிக்கப்பட்டது',
                'trainee_information' => 'பயிலுநர் தகவல்',
                'ojt_match' => 'OJT பொருத்தம்',
                'ojt_apply' => 'OJT விண்ணப்பம்'
            ],
            'ojt_detail' => [
                'age_limitation' => 'வயது வரம்பு',
                'not_limitation' => 'வரம்பில்லை',
                'require_work_experience' => 'தேவையான தொழில் அனுபவம்',
                'required_skills' => 'தேவைப்படும் திறன்கள்',
                'application_deadline' => 'விண்ணப்ப இறுதித் திகதி',
                'application_requirements' => 'விண்ணப்ப தேவைகள்',
                'gender' => [
                    'root' => 'பாலினம்',
                    'male' => 'ஆண்',
                    'female' => 'பெண்',
                    'na' => ' na ',
                ],
                'inquires' => [
                    'root' => 'உசாவுகைகள் (Inquiries)',
                    'hr_name' => 'HR பெயர்',
                    'hr_email' => 'HR மின்னஞ்சல்',
                    'hr_contact_info' => 'HR தொடர்பு தகவல்'
                ]
            ]
        ]
    ],
    'change_cgo' => 'CGO ஐ மாற்றவும்',
    'select_cgo' => 'CGO ஐ தேர்ந்தெடுக்கவும்',
    'note_change_cgo' => 'குறிப்பு: CGO பயனரைக் மாற்றுவது இந்த வழிகாட்டி கோரிக்கையை ரத்து செய்யும்',
    'confirm_counseling' => 'ஆலோசனையை உறுதி செய்யவும்',
    'tvec_information' => 'TVEC தகவல்',
    'choose_tvec_information' => 'வழிகாட்டுதலுக்காக சில தகவல்களைத் தேர்ந்தெடுக்கவும்',
    'select_institute' => 'நிறுவகம்(களை) தேர்ந்தெடுக்கவும்',
    'select_tvec_course' => 'TVEC பாடநெறியை (களைத்) தேர்ந்தெடுக்கவும்',
    'select_nvq_course' => 'NVQ பாடநெறியைத் (களைத்) தேர்ந்தெடுக்கவும்',
    'go_to_tvec_site' => 'TVEC தேடல் தகவல் தளத்திற்குச் செல்லவும்',
    'done' => 'முடிந்தது (Done)',
    'reset' => 'மீட்டமைக்க (Reset)',
    'close' => 'மூடுக',
    'institutes' => 'நிறுவனங்கள்',
    'nvq_courses' => 'NVQ படிப்புகள்',
    'tvec_courses' => 'TVEC படிப்புகள்',
    'requested_information' => 'கோரப்பட்ட தகவல்',
    'requested_date' => 'கோரப்பட்ட திகதி',
    'location' => 'அமைவிடம்',
    'institute' => 'நிறுவகம்',
    'cancel_message' => 'இந்த வேட்பாளர் கோரிக்கையை ஒப்புக்கொள்ளவில்லை என்றால், தயவுசெய்து காரணம் குறிப்பிடவும்.',
    'feedback_message' => 'இது கீழ்காணும் பயிற்சியாளர் கருத்து',
    'no_information' => 'தகவல் இல்லை',
    'guidance_field' => 'வழிகாட்டல் துறை',
    'date' => 'தேதி',
    'trainee_nic' => 'பயிலுநரின்  தேசிய அடையாள அட்டை இல',
    'trainee_mobile' => 'பயிலுநரின்  செல்லிடைப்பேசி இல. (Mobile no.)',
    'trainee_email' => 'பயிலுநரின் மின்னஞ்சல்',
    'trainee_information' => 'பயிலுநரின் தகவல்',
    'temporary_save' => 'தற்காலிகமாக சேமிக்கவும்',
    'job_matched' => 'வேலை பொருந்தியது',
    'job_applied' => 'வேலை விண்ணப்பித்தது',
    'Trainee Institute' => 'பயிலுநரின் நிறுவகம்',
    'Select a title' => 'தலைப்பைத் தேர்ந்தெடுக்கவும்',
    'Details' => 'விபரங்கள்',
    'cgo_final' => 'CGO இறுதி முடிவு',
    'TVET Courses' => 'TVET பாடநெறிகள்',
    'Search by institute name or registration number...' => 'நிறுவகத்தின் பெயர் அல்லது பதிவு இலக்கம் மூலம் தேடவும்...',
    'Search by course name or registration number...' => 'பாடநெறியின் பெயர் அல்லது பதிவு இலக்கம் மூலம் தேடவும்...',
    'No.' => 'இல.',
    'Get the latest news' => 'சமீபத்திய செய்திகளைப் பெறவும்',
    'Technical and Vocational Education Training'=> 'தொழில்நுட்ப, தொழிற் கல்வி மற்றும் பயிற்சி',
    'Register' => 'பதிவு செய்யுங்கள்',
    'Register a new Guidance' => 'புதிய வழிகாட்டல்',
    'User Manual' => 'பயனர் கையேடு',
    'Monthly' => 'மாதாந்த',
    'Previous Month' => 'முந்தைய மாதம்',
    'Next Month' => 'அடுத்த மாதம்',
];
