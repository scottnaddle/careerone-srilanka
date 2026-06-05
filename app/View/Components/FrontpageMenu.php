<?php

namespace App\View\Components;

use App\Models\CareerGuidanceCategory;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FrontpageMenu extends Component
{
    public $items;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $contentCategories = CareerGuidanceCategory::all();
        $contentCategoryMenuItems = [];
        foreach ($contentCategories as $category) {
            $contentCategoryMenuItems[] = [
                'label' => $category->name,
                'link' => '/career-guidance/career-information/contents/' . base64_encode($category->id)
            ];
        }
        $jobInfoChildren = array_merge(
            $contentCategoryMenuItems,
            [
                ['label' => trans('system.menu.career_guidance.job_information.job_outlook'), 'link' => route('career-guidance.career-information.job-information')],
            ],
            [
                ['label' => trans('cgo.menu.career_guidance.job_information.career_expert_interview'), 'link' => route('career-guidance.career-information.career-expert-interview')],
            ]
        );
        //Define menu item for each user type
        switch (activeGuard()) {
            case '':
                $this->items = [
                    ['label' => 'Home', 'link' => '/'],
                    [
                        'label' => trans('system.menu.about_us'),
                        'children' => [
                            ['label' => trans('system.menu.about_career_platform'), 'link' => route('homepage.about-us')],
                            ['label' => trans('system.menu.contact_us'), 'link' => route('homepage.contact-us')],
                        ],
                    ],
                    [
                        'label' => trans('cgo.menu.career_guidance.root'),
                        'children' => [
                            [
                                'label' => trans('cgo.menu.career_guidance.employment.root'),
                                'children' => [
                                    ['label' => trans('cgo.menu.career_guidance.employment.employment_policy'), 'link' => route('career-guidance.employment.employment-policy')],
                                    ['label' => trans('cgo.menu.career_guidance.employment.news_letter'), 'link' => route('career-guidance.employment.newsletter')],
                                ]
                            ],
//                            [
//                                'label' => trans('cgo.menu.career_guidance.job_information.root'),
//                                'children' => [
//                                    ['label' => trans('system.menu.career_guidance.job_information.job_outlook'), 'link' => route('career-guidance.career-information.job-information')],
////                                    ['label' => trans('system.menu.career_guidance.job_information.soft_skills'), 'link' => route('career-guidance.career-information.soft-skills')],
////                                    ['label' => trans('system.menu.career_guidance.job_information.success_stories_of_graduates'), 'link' => route('career-guidance.career-information.success-stories-of-graduates')],
//                                    $contentCategoryMenuItems,
//                                    ['label' => trans('cgo.menu.career_guidance.job_information.career_expert_interview'), 'link' => route('career-guidance.career-information.career-expert-interview')],
//                                ]
//                            ],
                            [
                                'label' => trans('cgo.menu.career_guidance.job_information.root'),
                                'children' => $jobInfoChildren
                            ],
//                            ['label' => trans('system.menu.career_guidance.job_information.employment_supporting'), 'link' => route('career-guidance.career-guide.career-guide')],
                        ],
                    ],
                    [
                        'label' => trans('system.menu.information.root'),
                        'children' => [
                            ['label' => trans('system.menu.information.event'), 'link' => route('get-public-event')],
                            ['label' => trans('system.menu.information.qna'), 'link' => route('informations.qnas.list')],
                            ['label' => trans('system.menu.information.notice.notice'), 'link' => route('notices.index', ['#notice'])],
                        ],
                    ],
                ];
                break;
            case 'cgo':
                $this->items = [
                    ['label' => 'Home', 'link' => '/'],
                    [
                        'label' => trans('system.menu.about_us'),
                        'children' => [
                            ['label' => trans('system.menu.about_career_platform'), 'link' => route('homepage.about-us')],
                            ['label' => trans('system.menu.contact_us'), 'link' => route('homepage.contact-us')],
                        ],
                    ],
                    [
                        'label' => trans('cgo.menu.career_guidance.root'),
                        'children' => [
                            ['label' => trans('cgo.menu.career_guidance.career_test'), 'link' => route('cgo.career-guidance.career-test.list')],
                            ['label' => trans('cgo.menu.career_guidance.counseling.root'), 'link' => route('cgo.career-guidance.counseling.counseling-list')],
                            [
                                'label' => trans('cgo.menu.career_guidance.employment.root'),
                                'children' => [
                                    ['label' => trans('cgo.menu.career_guidance.employment.employment_policy'), 'link' => route('career-guidance.employment.employment-policy')],
                                    ['label' => trans('cgo.menu.career_guidance.employment.news_letter'), 'link' => route('career-guidance.employment.newsletter')],
                                ]
                            ],
//                            [
//                                'label' => trans('cgo.menu.career_guidance.job_information.root'),
//                                'children' => [
//                                    ['label' => trans('system.menu.career_guidance.job_information.job_outlook'), 'link' => route('career-guidance.career-information.job-information')],
//                                    ['label' => trans('cgo.menu.career_guidance.job_information.career_expert_interview'), 'link' => route('career-guidance.career-information.career-expert-interview')],
//                                ]
//                            ],
                            [
                                'label' => trans('cgo.menu.career_guidance.job_information.root'),
                                'children' => $jobInfoChildren
                            ],
//                            ['label' => trans('system.menu.career_guidance.job_information.employment_supporting'), 'link' => route('career-guidance.career-guide.career-guide')],
                        ],
                    ],
                    [
                        'label' => trans('cgo.menu.job_support.root'),
                        'children' => [
                            ['label' => trans('cgo.menu.job_support.trainee_list'), 'link' => route('cgo.job-support.trainee-list.list')],
                            ['label' => trans('cgo.menu.job_support.company_list'), 'link' => route('cgo.job-support.company-list.list')],
                            ['label' => trans('cgo.menu.job_support.job_list'), 'link' => route('cgo.job-support.job-list.list')],
                            ['label' => trans('cgo.menu.job_support.ojt_list'), 'link' => route('cgo.job-support.ojt-list.list')],
                        ],
                    ],
                    [
                        'label' => trans('system.menu.information.root'),
                        'children' => [
                            [
                                'label' => trans('cgo.menu.information.content_management.root'),
                                'children' => [
                                    ['label' => trans('cgo.menu.information.content_management.document'), 'link' => route('cgo.informations.content-management.documents.list')],
                                    ['label' => trans('cgo.menu.information.content_management.video'), 'link' => route('cgo.informations.content-management.videos.list')],
//                                    ['label' => trans('cgo.menu.information.content_management.resource'), 'link' => route('cgo.informations.content-management.resource.list')],
//                                    ['label' => trans('cgo.menu.information.content_management.peer_content_list'), 'link' => route('cgo.informations.content-management.peer-review.list')],
                                ]
                            ],
                            ['label' => trans('system.menu.information.event'), 'link' => route('informations.events.event')],
                            ['label' => trans('system.menu.information.qna'), 'link' => route('informations.qnas.list')],
                            ['label' => trans('system.menu.information.notice.notice'), 'link' => route('notices.index', ['#notice'])],
                        ],
                    ],
                ];
                break;
            case 'company':
                $this->items = [
                    ['label' => 'Home', 'link' => '/'],
                    [
                        'label' => trans('system.menu.about_us'),
                        'children' => [
                            ['label' => trans('system.menu.about_career_platform'), 'link' => route('homepage.about-us')],
                            ['label' => trans('system.menu.contact_us'), 'link' => route('homepage.contact-us')],
                        ],
                    ],
                    [
                        'label' => trans('company.menu.job_support.root'),
                        'children' => [
                            ['label' => trans('company.menu.job_support.job_list'), 'link' => route('company.job-support.job-vacancy.list')],
                            ['label' => trans('company.menu.job_support.trainee_list'), 'link' => route('company.job-support.trainee-list.list')],
                            ['label' => trans('company.OJT Vacancy Management'), 'link' => route('company.job-support.ojt-list.list')],
                            [
                                'label' => trans('cgo.menu.career_guidance.job_information.root'),
                                'children' => $jobInfoChildren
                            ],
                            [
                                'label' => trans('company.menu.job_support.employment.root'),
                                'children' => [
                                    ['label' => trans('company.menu.job_support.employment.employment_policy'), 'link' => route('career-guidance.employment.employment-policy')],
                                    ['label' => trans('company.menu.job_support.employment.news_letter'), 'link' => route('career-guidance.employment.newsletter')],
                                ],
                            ],
                        ],
                    ],
                    [
                        'label' => trans('company.menu.information.root'),
                        'children' => [
//                            [
//                                'label' => trans('company.menu.information.content_management.root'),
//                                'children' => [
//                                    ['label' => trans('company.menu.information.content_management.video'), 'link' => route('company.informations.content-management.videos.list')],
//                                    ['label' => trans('company.menu.information.content_management.document'), 'link' => route('company.informations.content-management.documents.list')],
//                                ]
//                            ],
                            ['label' => trans('system.menu.information.event'), 'link' => route('informations.events.event')],
                            ['label' => trans('system.menu.information.qna'), 'link' => route('informations.qnas.list')],
                            ['label' => trans('system.menu.information.notice.notice'), 'link' => route('notices.index', ['#notice'])],
                        ],
                    ],
                ];
                break;
            case 'trainee':
                $this->items = [
                    ['label' => 'Home', 'link' => '/'],
                    [
                        'label' => trans('system.menu.about_us'),
                        'children' => [
                            ['label' => trans('system.menu.about_career_platform'), 'link' => route('homepage.about-us')],
                            ['label' => trans('system.menu.contact_us'), 'link' => route('homepage.contact-us')],
                        ],
                    ],
                    [
                        'label' => trans('trainee.menu.career_guidance.root'),
                        'children' => [
                            ['label' => trans('trainee.menu.career_guidance.career_test'), 'link' => route('trainee.career-guidance.career-test.list')],
                            ['label' => trans('trainee.menu.career_guidance.counseling'), 'link' => route('trainee.career-guidance.counseling.counseling-history')],
                            ['label' => trans('trainee.menu.career_guidance.portfolio.portfolio'), 'link' => route('trainee.career-guidance.portfolio.get-portfolio')],
                            [
                                'label' => trans('trainee.menu.career_guidance.employment.root'),
                                'children' => [
                                    ['label' => trans('trainee.menu.career_guidance.employment.employment_policy'), 'link' => route('career-guidance.employment.employment-policy')],
                                    ['label' => trans('trainee.menu.career_guidance.employment.news_letter'), 'link' => route('career-guidance.employment.newsletter')],
                                ]
                            ],
//                            [
//                                'label' => trans('trainee.menu.career_guidance.job_career_information.root'),
//                                'children' => [
//                                    ['label' => trans('trainee.menu.career_guidance.job_career_information.job_information'), 'link' => route('career-guidance.career-information.job-information')],
//                                    ['label' => trans('trainee.menu.career_guidance.job_career_information.career_expert_interview'), 'link' => route('career-guidance.career-information.career-expert-interview')],
//                                ]
//                            ],
                            [
                                'label' => trans('trainee.menu.career_guidance.job_career_information.root'),
                                'children' => $jobInfoChildren
                            ],
//                            ['label' => trans('system.menu.career_guidance.job_information.employment_supporting'), 'link' => route('career-guidance.career-guide.career-guide')],
                        ],
                    ],
                    [
                        'label' => trans('trainee.menu.job_support.root'),
                        'children' => [
                            ['label' => trans('trainee.menu.job_support.company_list'), 'link' => route('trainee.job-support.company.company-list')],
                            ['label' => trans('trainee.menu.job_support.job_list'), 'link' => route('trainee.job-support.job-list.job-list')],
                            ['label' => trans('trainee.menu.job_support.ojt_list'), 'link' => route('trainee.job-support.ojt.ojt-list')],
                        ],
                    ],
                    [
                        'label' => trans('trainee.menu.information.root'),
                        'children' => [
                            ['label' => trans('trainee.menu.information.event'), 'link' => route('get-public-event')],
                            ['label' => trans('trainee.menu.information.qna'), 'link' => route('informations.qnas.list')],
                            ['label' => trans('system.menu.information.notice.notice'), 'link' => route('notices.index', ['#notice'])],
                        ],
                    ],
                ];
                break;
        }

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.frontpage-menu');
    }
}
