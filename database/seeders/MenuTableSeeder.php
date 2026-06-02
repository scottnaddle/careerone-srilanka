<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            $menu = DB::table(config('filament-menu-builder.tables.menus'))->insertGetId([
                'name' => 'Main Menu',
                'is_visible' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table(config('filament-menu-builder.tables.menu_locations'))->insert([
                'menu_id' => $menu,
                'location' => 'header',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $navigationGroups = $this->getNavigationGroups();

            foreach ($navigationGroups as $group) {
                $groupItemId = $this->insertMenuItem($menu, $group['label'], $group['icon'], $group['capability'], null, '#', $group['order']);
                foreach ($group['items'] as $item) {
                    if (isset($item['subItems'])) {
                        $this->insertSubItems($menu, $groupItemId, $item['subItems']);
                    } else {
                        $this->insertMenuItem($menu, $item['title'], null, $item['capability'] ?? null, $groupItemId, $item['url']);
                    }
                }
            }
        });
    }
    private function getNavigationGroups(): array
    {
        return [
            [
                'label' => 'menu.dashboard',
                'icon' => 'dashboard-icon',
                'capability' => 'admin',
                'order' => 1,
                'items' => [
                    ['title' => 'menu.overview', 'url' => '/admin/overview', 'capability' => 'admin'],
                    ['title' => 'menu.cgo_performance', 'url' => '/admin/cgo-performance', 'capability' => 'admin'],
                    ['title' => 'menu.institute_performance', 'url' => '/admin/institute-performance', 'capability' => 'admin'],
                    ['title' => 'menu.company_performance', 'url' => '/admin/company-performance', 'capability' => 'admin'],
                    //                    ['title' => 'menu.log_performance', 'url' => '/admin/log-performance'],
                ],
            ],
            [
                'label' => 'menu.career_guidance',
                'icon' => 'career-guidance-icon',
                'capability' => 'admin',
                'order' => 2,
                'items' => [
                    ['title' => 'menu.career_test', 'url' => '/admin/career-tests', 'capability' => 'admin'],
                    ['title' => 'menu.counseling', 'url' => '/admin/counselings', 'capability' => 'admin'],
                ],
            ],
            [
                'label' => 'menu.job_support',
                'icon' => 'support',
                'capability' => 'admin',
                'order' => 3,
                'items' => [
                    ['title' => 'menu.job_posting', 'url' => '/admin/jobs', 'capability' => 'admin'],
                    ['title' => 'menu.ojt_list', 'url' => '/admin/o-j-t-s', 'capability' => 'admin'],
                    ['title' => 'menu.company_list', 'url' => '/admin/company-jobs', 'capability' => 'admin'],
                ],
            ],
            [
                'label' => 'menu.information',
                'icon' => 'content',
                'capability' => 'admin',
                'order' => 4,
                'items' => [
                    [
                        'title' => 'menu.information',
                        'url' => '#',
                        'subItems' => [
                            [
                                'title' => 'menu.content',
                                'url' => '#',
                                'capability' => 'admin',
//                                'subItems' => [
//                                    ['title' => 'menu.content_list', 'url' => '/admin/information/content/content-lists', 'capability' => 'admin'],
//                                    ['title' => 'menu.content_approval_list', 'url' => '/admin/information/content/content-appoval-lists'],
//                                ],
                                'subItems' => [
                                    ['title' => 'menu.video', 'url' => '/admin/content/videos', 'capability' => 'admin'],
                                    ['title' => 'menu.document', 'url' => '/admin/content/documents'],
//                                    ['title' => 'menu.resource', 'url' => '/admin/resources'],
                                ],
                            ],
                            [
                                'title' => 'menu.events',
                                'url' => '',
                                'capability' => 'admin',
                                'subItems' => [
                                    ['title' => 'menu.event_list', 'url' => '/admin/information/content/event-lists', 'capability' => 'admin'],
                                    ['title' => 'menu.event_approval_list', 'url' => '/admin/information/content/event-approval-lists'],
                                    // ['title' => 'menu.event_rejected_list', 'url' => '/admin/information/event-list-rejecteds'],
                                ],
                            ],
                            ['title' => 'menu.q_and_a', 'url' => '/admin/information/q-as'],
                            ['title' => 'menu.notice', 'url' => '/admin/information/notice'],
                            [
                                'title' => 'menu.faq',
                                'url' => '/admin/information/f-a-qs',
                                'subItems' => [
                                    ['title' => 'menu.faq', 'url' => '/admin/information/f-a-qs'],
                                    ['title' => 'menu.faq_article', 'url' => '/admin/information/f-a-q-articles'],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            [
                'label' => 'menu.membership',
                'icon' => 'membership-icon',
                'capability' => '',
                'order' => 5,
                'items' => [
                    [
                        'title' => 'menu.membership',
                        'url' => '#',
                        'subItems' => [
                            [
                                'title' => 'menu.trainee',
                                'url' => '/admin/trainees',
                            ],
                            [
                                'title' => 'menu.cgo',
                                'url' => '#',
                                'subItems' => [
                                    ['title' => 'menu.cgo_list', 'url' => '/admin/c-g-o-s'],
                                    ['title' => 'menu.approved_cgo_details', 'url' => '/admin/approved-c-g-o-details'],
                                    ['title' => 'menu.cgo_approval_list', 'url' => '/admin/cgo-approval-list'],
                                ],
                            ],
                            [
                                'title' => 'menu.company',
                                'url' => '#',
                                'subItems' => [
                                    ['title' => 'menu.company_list', 'url' => '/admin/companies'],
                                    ['title' => 'menu.company_approval_list', 'url' => '/admin/company-approval-list'],
                                ],
                            ],
                            [
                                'title' => 'menu.administrator',
                                'url' => '#',
                                'subItems' => [
                                    ['title' => 'menu.administrator_list', 'url' => '/admin/administrators'],
                                    ['title' => 'menu.administrator_approval_list', 'url' => '/admin/administrator-approval-list'],
                                ],
                            ],
                            [
                                'title' => 'menu.company_recruiter',
                                'url' => '#',
                                'subItems' => [
                                    ['title' => 'menu.company_recruiter_list', 'url' => '/admin/company-recruiters'],
                                    ['title' => 'menu.company_recruiter_approval_list', 'url' => '/admin/company-recruiter-approvals'],
                                ],
                            ],
                            [
                                'title' => 'menu.reactive_account_list',
                                'url' => '/admin/user-re-actives',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'label' => 'menu.system_management',
                'icon' => 'heroicon-o-cog-6-tooth',
                'capability' => '',
                'order' => 6,
                'items' => [
                    [
                        'title' => 'menu.information',
                        'url' => '#',
                        'subItems' => [
                            ['title' => 'menu.emergency-user-reset', 'url' => '/admin/emergency-user-reset', 'capability' => 'super_admin'],
                            [
                                'title' => 'menu.manage_role',
                                'url' => '/admin/c-g-o-s',
                                'subItems' => [
                                    ['title' => 'menu.role', 'url' => '/admin/shield/roles'],
                                    ['title' => 'menu.member', 'url' => '/admin/admin-roles'],
                                ],
                            ],
                            ['title' => 'menu.menu', 'url' => '/admin/menus'],
                            ['title' => 'menu.institute', 'url' => '/admin/api/institutes'],
                            ['title' => 'menu.nvq_course', 'url' => '/admin/api/n-v-q-courses'],
                            ['title' => 'menu.nvq_level', 'url' => '/admin/api/packages'],
                            ['title' => 'menu.req_course', 'url' => '/admin/api/r-e-q-courses'],
                            ['title' => 'menu.head_office', 'url' => '/admin/head-offices'],
                            ['title' => 'menu.code_management', 'url' => '/admin/code-managements'],
                            ['title' => 'menu.language_management', 'url' => '/admin/translation-manager'],
                            ['title' => 'menu.sector_management', 'url' => '/admin/sectors'],
                        ],
                    ],
                ],
            ],
            [
                'label' => 'menu.general_information_management',
                'icon' => 'icons8-info',
                'capability' => '',
                'order' => 7,
                'items' => [
                    ['title' => 'information', 'url' => '#', 'subItems' => [
                    [
                        'title' => 'menu.banner_management',
                        'url' => '/admin/banners',
                    ],
                    [
                        'title' => 'menu.popup_management',
                        'url' => '/admin/popups',
                    ],
                    [
                        'title' => 'menu.policy_management',
                        'url' => '#',
                        'subItems' => [
                            ['title' => 'menu.policy_category', 'url' => '/admin/policy-categories'],
                            ['title' => 'menu.policy', 'url' => '/admin/policies'],
                        ],
                    ],
                    [
                        'title' => 'menu.job_information_management',
                        'url' => '/admin/job-informations',
                    ],
//                    [
//                        'title' => 'menu.type_of_enterprise_management',
//                        'url' => '/admin/enterprises',
//                    ],
                    [
                        'title' => 'menu.newsletter_management',
                        'url' => '#',
                        'subItems' => [
                            ['title' => 'menu.newsletter_category', 'url' => '/admin/newsletter-categories'],
                            ['title' => 'menu.newsletter', 'url' => '/admin/newsletters'],
                        ],
                    ],
                    [
                        'title' => 'menu.career_guide_management',
                        'url' => '#',
                        'subItems' => [
                            ['title' => 'menu.career_guide_category', 'url' => '/admin/career-guide-categories'],
                            ['title' => 'menu.career_guide', 'url' => '/admin/career-guides'],
                        ],
                    ],
                    [
                        'title' => 'menu.career_expert_interview_management',
                        'url' => '/admin/career-expert-interviews',
                    ],
                ]]
                ],
            ],
        ];
    }


    private function insertMenuItem(int $menuId, string $title, ?string $icon, ?string $capability, ?int $parentId = null, ?string $url = '#', ?int $order = 0): int
    {
        $menuItemId = DB::table(config('filament-menu-builder.tables.menu_items'))->insertGetId([
            'menu_id' => $menuId,
            'parent_id' => $parentId,
            'title' => $title,
            'url' => $url,
            'target' => 'self',
            'order' => $order,
            'icon' => $icon,
            'capability' => $capability,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        if ($icon) {
            DB::table(config('filament-menu-builder.tables.menu_icon'))->insert([
                'menu_item_id' => $menuItemId,
                'icon' => $icon,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return $menuItemId;
    }

    private function insertSubItems(int $menuId, int $parentId, array $subItems): void
    {
        foreach ($subItems as $subItem) {
            $subItemId = $this->insertMenuItem(
                $menuId,
                $subItem['title'],
                null,
                $subItem['capability'] ?? null,
                $parentId,
                $subItem['url']
            );
            if (isset($subItem['subItems'])) {
                $this->insertSubItems($menuId, $subItemId, $subItem['subItems']);
            }
        }
    }
}
