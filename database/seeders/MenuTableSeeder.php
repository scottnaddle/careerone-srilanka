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
                'capability' => 'admin,naita_admin',
                'order' => 1,
                'items' => [
                    ['title' => 'menu.overview', 'url' => '/admin/overview', 'capability' => 'admin,naita_admin'],
                    ['title' => 'menu.cgo_performance', 'url' => '/admin/cgo-performance', 'capability' => 'admin,naita_admin'],
                    ['title' => 'menu.institute_performance', 'url' => '/admin/institute-performance', 'capability' => 'admin,naita_admin'],
                    ['title' => 'menu.company_performance', 'url' => '/admin/company-performance', 'capability' => 'naita_admin'],
                    ['title' => 'menu.pdm-dashboard', 'url' => '/admin/pdm-dashboard', 'capability' => 'super_admin'],
                    //                    ['title' => 'menu.log_performance', 'url' => '/admin/log-performance'],
                ],
            ],
            [
                'label' => 'menu.career_guidance',
                'icon' => 'career-guidance-icon',
                'capability' => 'admin,naita_admin',
                'order' => 2,
                'items' => [
                    ['title' => 'menu.career_test', 'url' => '/admin/career-tests', 'capability' => 'admin,naita_admin'],
                    ['title' => 'menu.counseling', 'url' => '/admin/counselings', 'capability' => 'admin,naita_admin'],
                ],
            ],
            [
                'label' => 'menu.job_support',
                'icon' => 'support',
                'capability' => 'naita_admin',
                'order' => 3,
                'items' => [
                    ['title' => 'menu.job_posting', 'url' => '/admin/jobs', 'capability' => 'naita_admin'],
                    ['title' => 'menu.ojt_list', 'url' => '/admin/o-j-t-s', 'capability' => 'naita_admin'],
                    ['title' => 'menu.company_list', 'url' => '/admin/company-jobs', 'capability' => 'naita_admin'],
                ],
            ],
            [
                'label' => 'menu.information',
                'icon' => 'content',
                'capability' => 'admin,naita_admin',
                'order' => 4,
                'items' => [
                    [
                        'title' => 'menu.information',
                        'url' => '#',
                        'capability' => 'admin,naita_admin',
                        'subItems' => [
                            [
                                'title' => 'menu.content',
                                'url' => '#',
                                'capability' => 'super_admin',
                                'subItems' => [
                                    ['title' => 'menu.video', 'url' => '/admin/content/videos', 'capability' => 'super_admin'],
                                    ['title' => 'menu.document', 'url' => '/admin/content/documents', 'capability' => 'super_admin'],
                                ],
                            ],
                            [
                                'title' => 'menu.events',
                                'url' => '',
                                'capability' => 'admin,naita_admin',
                                'subItems' => [
                                    ['title' => 'menu.event_list', 'url' => '/admin/information/content/event-lists', 'capability' => 'admin,naita_admin'],
                                    ['title' => 'menu.event_approval_list', 'url' => '/admin/information/content/event-approval-lists', 'capability' => 'admin,naita_admin'],
                                    // ['title' => 'menu.event_rejected_list', 'url' => '/admin/information/event-list-rejecteds'],
                                ],
                            ],
                            ['title' => 'menu.q_and_a', 'url' => '/admin/information/q-as', 'capability' => 'super_admin'],
                            ['title' => 'menu.notice', 'url' => '/admin/information/notice', 'capability' => 'super_admin'],
                            [
                                'title' => 'menu.faq',
                                'url' => '/admin/information/f-a-qs',
                                'capability' => 'super_admin',
                                'subItems' => [
                                    ['title' => 'menu.faq', 'url' => '/admin/information/f-a-qs', 'capability' => 'super_admin'],
                                    ['title' => 'menu.faq_article', 'url' => '/admin/information/f-a-q-articles', 'capability' => 'super_admin'],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            [
                'label' => 'menu.membership',
                'icon' => 'membership-icon',
                'capability' => 'super_admin,admin,naita_admin',
                'order' => 5,
                'items' => [
                    [
                        'title' => 'menu.membership',
                        'url' => '#',
                        'subItems' => [
                            [
                                'title' => 'menu.trainee',
                                'url' => '/admin/trainees',
                                'capability' => 'super_admin,admin,naita_admin'
                            ],
                            [
                                'title' => 'menu.cgo',
                                'url' => '#',
                                'capability' => 'super_admin,admin,naita_admin',
                                'subItems' => [
                                    ['title' => 'menu.cgo_list', 'url' => '/admin/c-g-o-s', 'capability' => 'super_admin,admin,naita_admin'],
                                    ['title' => 'menu.approved_cgo_details', 'url' => '/admin/approved-c-g-o-details', 'capability' => 'super_admin,admin,naita_admin'],
                                    ['title' => 'menu.cgo_approval_list', 'url' => '/admin/cgo-approval-list', 'capability' => 'super_admin,admin,naita_admin'],
                                ],
                            ],
                            [
                                'title' => 'menu.company',
                                'url' => '#',
                                'capability' => 'super_admin,naita_admin',
                                'subItems' => [
                                    ['title' => 'menu.company_list', 'url' => '/admin/companies', 'capability' => 'super_admin,naita_admin'],
                                    ['title' => 'menu.company_approval_list', 'url' => '/admin/company-approval-list', 'capability' => 'super_admin'],
                                ],
                            ],
                            [
                                'title' => 'menu.administrator',
                                'url' => '#',
                                'capability' => 'super_admin',
                                'subItems' => [
                                    ['title' => 'menu.administrator_list', 'url' => '/admin/administrators', 'capability' => 'super_admin'],
                                    ['title' => 'menu.administrator_approval_list', 'url' => '/admin/administrator-approval-list', 'capability' => 'super_admin'],
                                ],
                            ],
                            [
                                'title' => 'menu.company_recruiter',
                                'url' => '#',
                                'capability' => 'super_admin,naita_admin',
                                'subItems' => [
                                    ['title' => 'menu.company_recruiter_list', 'url' => '/admin/comapny-user-lists', 'capability' => 'super_admin,naita_admin'],
                                    ['title' => 'menu.company_recruiter_approval_list', 'url' => '/admin/company-recruiter-approvals', 'capability' => 'super_admin,naita_admin'],
                                ],
                            ],
                            [
                                'title' => 'menu.reactive_account_list',
                                'url' => '/admin/user-re-actives',
                                'capability' => 'super_admin'
                            ],
                        ],
                    ],
                ],
            ],
            [
                'label' => 'menu.system_management',
                'icon' => 'heroicon-o-cog-6-tooth',
                'capability' => 'super_admin',
                'order' => 6,
                'items' => [
                    [
                        'title' => 'menu.information',
                        'url' => '#',
                        'capability' => 'super_admin',
                        'subItems' => [
                            ['title' => 'menu.emergency-user-reset', 'url' => '/admin/emergency-user-reset', 'capability' => 'super_admin'],
                            [
                                'title' => 'menu.manage_role',
                                'url' => '/admin/c-g-o-s',
                                'capability' => 'super_admin',
                                'subItems' => [
                                    ['title' => 'menu.role', 'url' => '/admin/shield/roles', 'capability' => 'super_admin'],
                                    ['title' => 'menu.member', 'url' => '/admin/admin-roles', 'capability' => 'super_admin'],
                                ],
                            ],
                            ['title' => 'menu.menu', 'url' => '/admin/menus', 'capability' => 'super_admin'],
                            ['title' => 'menu.institute', 'url' => '/admin/api/institutes', 'capability' => 'super_admin'],
                            ['title' => 'menu.nvq_course', 'url' => '/admin/api/n-v-q-courses', 'capability' => 'super_admin'],
                            ['title' => 'menu.nvq_level', 'url' => '/admin/api/packages', 'capability' => 'super_admin'],
                            ['title' => 'menu.req_course', 'url' => '/admin/api/r-e-q-courses', 'capability' => 'super_admin'],
                            ['title' => 'menu.head_office', 'url' => '/admin/head-offices', 'capability' => 'super_admin'],
                            ['title' => 'menu.code_management', 'url' => '/admin/code-managements', 'capability' => 'super_admin'],
                            ['title' => 'menu.language_management', 'url' => '/admin/translation-manager', 'capability' => 'super_admin'],
                            ['title' => 'menu.sector_management', 'url' => '/admin/sectors', 'capability' => 'super_admin'],
                        ],
                    ],
                ],
            ],
            [
                'label' => 'menu.general_information_management',
                'icon' => 'icons8-info',
                'capability' => 'super_admin',
                'order' => 7,
                'items' => [
                    ['title' => 'information', 'url' => '#','capability' => 'super_admin', 'subItems' => [
                    [
                        'title' => 'menu.banner_management',
                        'url' => '/admin/banners',
                        'capability' => 'super_admin',
                    ],
                    [
                        'title' => 'menu.popup_management',
                        'url' => '/admin/popups',
                        'capability' => 'super_admin',
                    ],
                    [
                        'title' => 'menu.policy_management',
                        'url' => '#',
                        'capability' => 'super_admin',
                        'subItems' => [
                            ['title' => 'menu.policy_category', 'url' => '/admin/policy-categories', 'capability' => 'super_admin'],
                            ['title' => 'menu.policy', 'url' => '/admin/policies', 'capability' => 'super_admin'],
                        ],
                    ],
                    [
                        'title' => 'menu.job_information_management',
                        'url' => '/admin/job-informations',
                        'capability' => 'super_admin',
                    ],
//                    [
//                        'title' => 'menu.type_of_enterprise_management',
//                        'url' => '/admin/enterprises',
//                    ],
                    [
                        'title' => 'menu.newsletter_management',
                        'url' => '#',
                        'capability' => 'super_admin',
                        'subItems' => [
                            ['title' => 'menu.newsletter_category', 'url' => '/admin/newsletter-categories', 'capability' => 'super_admin'],
                            ['title' => 'menu.newsletter', 'url' => '/admin/newsletters', 'capability' => 'super_admin'],
                        ],
                    ],
                    [
                        'title' => 'menu.career_guide_management',
                        'url' => '#',
                        'capability' => 'super_admin',
                        'subItems' => [
                            ['title' => 'menu.career_guide_category', 'url' => '/admin/career-guide-categories', 'capability' => 'super_admin'],
                            ['title' => 'menu.career_guide', 'url' => '/admin/career-guides', 'capability' => 'super_admin'],
                        ],
                    ],
                    [
                        'title' => 'menu.career_expert_interview_management',
                        'url' => '/admin/career-expert-interviews',
                        'capability' => 'super_admin'
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
