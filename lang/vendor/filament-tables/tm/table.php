<?php
return [

'column_toggle' => [
    'heading' => 'நெடுவரிசை',
],

'columns' => [
    'actions' => [
        'label' => 'செயல்கள்|செயல்கள்',
    ],

    'text' => [
        'actions' => [
            'collapse_list' => ':count குறைவாகக் காண்பிக்கவும்',
            'expand_list' => ':count அதிகமாகக் காண்பிக்கவும்',
        ],

        'more_list_items' => 'மற்றும் :count நெடுவரிசைகள்',
    ],
],

'fields' => [
    'bulk_select_page' => [
        'label' => 'மொத்த செயல் முடுக்கம் செயல்படுத்த அனைத்து உருப்படிகளையும் தேர்ந்தெடுக்கவும்/நீக்கவும்.',
    ],

    'bulk_select_record' => [
        'label' => ':key உருப்படியை மொத்த செயல் முடுக்கத்திற்கு தேர்ந்தெடுக்கவும்/நீக்கவும்.',
    ],

    'bulk_select_group' => [
        'label' => ':title குழுவை மொத்த செயல் முடுக்கங்களுக்கு தேர்ந்தெடுக்கவும்/நீக்கவும்.',
    ],

    'search' => [
        'label' => 'தேடல்',
        'placeholder' => 'தேடல்',
        'indicator' => 'தேடல்',
    ],
],

'summary' => [
    'heading' => 'சுருக்கம்',

    'subheadings' => [
        'all' => 'அனைத்து :label',
        'group' => ':group சுருக்கம்',
        'page' => 'இந்த பக்கம்',
    ],

    'summarizers' => [
        'average' => [
            'label' => 'சராசரி',
        ],

        'count' => [
            'label' => 'எண்ணிக்கை',
        ],

        'sum' => [
            'label' => 'மொத்தம்',
        ],
    ],
],

'actions' => [
    'disable_reordering' => [
        'label' => 'பதிவுகளை மறுசீரமைப்பை நிறைவு செய்யவும்',
    ],

    'enable_reordering' => [
        'label' => 'பதிவுகளை மறுசீரமைக்கவும்',
    ],

    'filter' => [
        'label' => 'வடிகட்டி',
    ],

    'group' => [
        'label' => 'குழு',
    ],

    'open_bulk_actions' => [
        'label' => 'மொத்த செயல்கள்',
    ],

    'toggle_columns' => [
        'label' => 'நெடுவரிசைகளை மாற்றவும்',
    ],
],

'empty' => [
    'heading' => 'ஒரு :model இல்லை',

    'description' => 'ஒரு :model உருவாக்கவும் தொடங்கவும்.',
],

'filters' => [
    'actions' => [
        'apply' => [
            'label' => 'வடிகட்டிகளை பயன்படுத்தவும்',
        ],

        'remove' => [
            'label' => 'வடிகட்டிகளை அகற்றவும்',
        ],

        'remove_all' => [
            'label' => 'அனைத்து வடிகட்டிகளையும் அகற்றவும்',
            'tooltip' => 'அனைத்து வடிகட்டிகளையும் அகற்றவும்',
        ],

        'reset' => [
            'label' => 'மீட்டமை',
        ],
    ],

    'heading' => 'வடிகட்டிகள்',

    'indicator' => 'செயலில் உள்ள வடிகட்டிகள்',

    'multi_select' => [
        'placeholder' => 'அனைத்தும்',
    ],

    'select' => [
        'placeholder' => 'அனைத்தும்',
    ],

    'trashed' => [
        'label' => 'நீக்கப்பட்ட பதிவுகள்',

        'only_trashed' => 'மட்டுமே நீக்கப்பட்டவை',

        'with_trashed' => 'நீக்கப்பட்டவற்றையும் சேர்க்கவும்',

        'without_trashed' => 'நீக்கப்பட்டவற்றை தவிர்க்கவும்',
    ],
],

'grouping' => [
    'fields' => [
        'group' => [
            'label' => 'இணைக்கவும்',
            'placeholder' => 'இணைக்கவும்',
        ],

        'direction' => [
            'label' => 'இணைப்பு திசை',

            'options' => [
                'asc' => 'அதிகரிக்கும் வரிசை',
                'desc' => 'குறைக்கும் வரிசை',
            ],
        ],
    ],
],

'reorder_indicator' => 'மறுசீரமைக்க பதிவுகளை இழுக்கவும் மற்றும் விடவும்.',

'selection_indicator' => [
    'selected_count' => '1 பதிவு தேர்ந்தெடுக்கப்பட்டது|:count பதிவுகள் தேர்ந்தெடுக்கப்பட்டன',

    'actions' => [
        'select_all' => [
            'label' => 'அனைத்து :count ஐத் தேர்ந்தெடுக்கவும்',
        ],

        'deselect_all' => [
            'label' => 'அனைத்தையும் அகற்றவும்',
        ],
    ],
],

'sorting' => [
    'fields' => [
        'column' => [
            'label' => 'இணைக்க',
        ],

        'direction' => [
            'label' => 'திசை',

            'options' => [
                'asc' => 'அதிகரிக்கும் வரிசை',
                'desc' => 'குறைக்கும் வரிசை',
            ],
        ],
    ],
],
];
