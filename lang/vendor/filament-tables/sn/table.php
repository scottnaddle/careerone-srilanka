<?php
return [

'column_toggle' => [
    'heading' => 'තීරය',
],

'columns' => [
    'actions' => [
        'label' => 'ක්‍රියා|ක්‍රියා',
    ],

    'text' => [
        'actions' => [
            'collapse_list' => ':count අඩු කර පිටුවක් පෙන්වන්න',
            'expand_list' => ':count වැඩි කර පිටුවක් පෙන්වන්න',
        ],

        'more_list_items' => 'සහ වෙනත් :count තීර',
    ],
],

'fields' => [
    'bulk_select_page' => [
        'label' => 'සමස්ත ක්‍රියා සඳහා සියලුම අයිතම තෝරන්න/අවලංගු කරන්න.',
    ],

    'bulk_select_record' => [
        'label' => 'සමස්ත ක්‍රියා සඳහා :key අයිතමය තෝරන්න/අවලංගු කරන්න.',
    ],

    'bulk_select_group' => [
        'label' => ':title කණ්ඩායම සමස්ත ක්‍රියා සඳහා තෝරන්න/අවලංගු කරන්න.',
    ],

    'search' => [
        'label' => 'සෙවීම',
        'placeholder' => 'සෙවීම',
        'indicator' => 'සෙවීම',
    ],
],

'summary' => [
    'heading' => 'සාරාංශය',

    'subheadings' => [
        'all' => 'සියලුම :label',
        'group' => ':group සාරාංශය',
        'page' => 'මෙම පිටුව',
    ],

    'summarizers' => [
        'average' => [
            'label' => 'සමහර ගණන',
        ],

        'count' => [
            'label' => 'ගණන',
        ],

        'sum' => [
            'label' => 'එකතුව',
        ],
    ],
],

'actions' => [
    'disable_reordering' => [
        'label' => 'ප්‍රතිලේඛන සැකසුම අවසන් කරන්න',
    ],

    'enable_reordering' => [
        'label' => 'ප්‍රතිලේඛන නැවත සකසන්න',
    ],

    'filter' => [
        'label' => 'පෙරහන්',
    ],

    'group' => [
        'label' => 'කණ්ඩායම',
    ],

    'open_bulk_actions' => [
        'label' => 'සමස්ත ක්‍රියා',
    ],

    'toggle_columns' => [
        'label' => 'තීරු මාරු කරන්න',
    ],
],

'empty' => [
    'heading' => 'කිසිඳු :model නැත',

    'description' => 'ආරම්භ කිරීමට :model එකක් සාදන්න.',
],

'filters' => [
    'actions' => [
        'apply' => [
            'label' => 'පෙරහන් යෙදවන්න',
        ],

        'remove' => [
            'label' => 'පෙරහන් ඉවත් කරන්න',
        ],

        'remove_all' => [
            'label' => 'සියලු පෙරහන් ඉවත් කරන්න',
            'tooltip' => 'සියලු පෙරහන් ඉවත් කරන්න',
        ],

        'reset' => [
            'label' => 'නැවත සකසන්න',
        ],
    ],

    'heading' => 'පෙරහන්',

    'indicator' => 'සක්‍රීය පෙරහන්',

    'multi_select' => [
        'placeholder' => 'සියලුම',
    ],

    'select' => [
        'placeholder' => 'සියලුම',
    ],

    'trashed' => [
        'label' => 'අහෝසි කළ ලේඛන',

        'only_trashed' => 'අහෝසි කළ ලේඛන පමණක්',

        'with_trashed' => 'අහෝසි කළ ලේඛන ඇතුළත් කරන්න',

        'without_trashed' => 'අහෝසි කළ ලේඛන ඇතුළත් නොකරන්න',
    ],
],

'grouping' => [
    'fields' => [
        'group' => [
            'label' => 'කණ්ඩායම් කරන්න',
            'placeholder' => 'කණ්ඩායම් කරන්න',
        ],

        'direction' => [
            'label' => 'කණ්ඩායම් දිශාව',

            'options' => [
                'asc' => 'අවධිනය',
                'desc' => 'අවසන් කිරීම',
            ],
        ],
    ],
],

'reorder_indicator' => 'නැවත සකසන්න. තේරුම් කර හා ලැබෙන්න.',

'selection_indicator' => [
    'selected_count' => '1 ලේඛනයක් තෝරා ඇත|:count ලේඛන තෝරා ඇත',

    'actions' => [
        'select_all' => [
            'label' => 'සියලුම :count තෝරන්න',
        ],

        'deselect_all' => [
            'label' => 'සියල්ල ඉවත් කරන්න',
        ],
    ],
],

'sorting' => [
    'fields' => [
        'column' => [
            'label' => 'සකසන්න',
        ],

        'direction' => [
            'label' => 'දිශාව',

            'options' => [
                'asc' => 'අවධිනය',
                'desc' => 'අවසන් කිරීම',
            ],
        ],
    ],
],
];
