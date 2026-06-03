<?php
namespace App\Services;

class BreadcrumbService
{
    public static function generate(array $items = []): array
    {
        $breadcrumbs = [
            [
                'label' => 'Admin',
                'url' => route('admin.dashboard'),
            ],
        ];
        return array_merge($breadcrumbs, $items);
    }
}
