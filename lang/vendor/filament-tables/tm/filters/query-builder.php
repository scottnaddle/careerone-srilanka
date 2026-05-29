<?php

return [

    'label' => 'ප්‍රශ්න සාදකය',

    'form' => [

        'operator' => [
            'label' => 'ක්‍රියාකාරකම්',
        ],

        'or_groups' => [

            'label' => 'සමූහය',

            'block' => [
                'label' => 'හෝ (OR)',
                'or' => 'හෝ',
            ],

        ],

        'rules' => [

            'label' => 'නියමයන්',

            'item' => [
                'and' => 'සහ',
            ],

        ],

    ],

    'no_rules' => '(නියමයන් නැත)',

    'item_separators' => [
        'and' => 'සහ',
        'or' => 'හෝ',
    ],

    'operators' => [

        'is_filled' => [

            'label' => [
                'direct' => 'පිරවා ඇත',
                'inverse' => 'හිස්ව ඇත',
            ],

            'summary' => [
                'direct' => ':attribute පිරවා ඇත',
                'inverse' => ':attribute හිස්ව ඇත',
            ],

        ],

        'boolean' => [

            'is_true' => [

                'label' => [
                    'direct' => 'සත්‍ය',
                    'inverse' => 'අසත්‍ය',
                ],

                'summary' => [
                    'direct' => ':attribute සත්‍ය',
                    'inverse' => ':attribute අසත්‍ය',
                ],

            ],

        ],

        'date' => [

            'is_after' => [

                'label' => [
                    'direct' => 'දිනට පසු',
                    'inverse' => 'දිනට පසු නොවේ',
                ],

                'summary' => [
                    'direct' => ':attribute දිනට පසු :date',
                    'inverse' => ':attribute දිනට පසු නොවේ :date',
                ],

            ],

            'is_before' => [

                'label' => [
                    'direct' => 'දිනට පෙර',
                    'inverse' => 'දිනට පෙර නොවේ',
                ],

                'summary' => [
                    'direct' => ':attribute දිනට පෙර :date',
                    'inverse' => ':attribute දිනට පෙර නොවේ :date',
                ],

            ],

            'is_date' => [

                'label' => [
                    'direct' => 'දිනය',
                    'inverse' => 'දිනයක් නොවේ',
                ],

                'summary' => [
                    'direct' => ':attribute දිනයක් :date',
                    'inverse' => ':attribute දිනයක් නොවේ :date',
                ],

            ],

            'is_month' => [

                'label' => [
                    'direct' => 'මාසය',
                    'inverse' => 'මාසය නොවේ',
                ],

                'summary' => [
                    'direct' => ':attribute මාසය :month',
                    'inverse' => ':attribute මාසය නොවේ :month',
                ],

            ],

            'is_year' => [

                'label' => [
                    'direct' => 'වර්ෂය',
                    'inverse' => 'වර්ෂය නොවේ',
                ],

                'summary' => [
                    'direct' => ':attribute වර්ෂය :year',
                    'inverse' => ':attribute වර්ෂය නොවේ :year',
                ],

            ],

            'form' => [

                'date' => [
                    'label' => 'දිනය',
                ],

                'month' => [
                    'label' => 'මාසය',
                ],

                'year' => [
                    'label' => 'වර්ෂය',
                ],

            ],

        ],

        'number' => [

            'equals' => [

                'label' => [
                    'direct' => 'සම',
                    'inverse' => 'සම නොවේ',
                ],

                'summary' => [
                    'direct' => ':attribute සම :number',
                    'inverse' => ':attribute සම නොවේ :number',
                ],

            ],

            'is_max' => [

                'label' => [
                    'direct' => 'උපරිමය',
                    'inverse' => 'උපරිමයට වැඩි',
                ],

                'summary' => [
                    'direct' => ':attribute උපරිමය :number',
                    'inverse' => ':attribute උපරිමයට වැඩි :number',
                ],

            ],

            'is_min' => [

                'label' => [
                    'direct' => 'අවම',
                    'inverse' => 'අවමයට අඩු',
                ],

                'summary' => [
                    'direct' => ':attribute අවම :number',
                    'inverse' => ':attribute අවමයට අඩු :number',
                ],

            ],

            'aggregates' => [

                'average' => [
                    'label' => 'මධ්‍යස්ථ',
                    'summary' => ':attribute මධ්‍යස්ථ',
                ],

                'max' => [
                    'label' => 'උපරිමය',
                    'summary' => ':attribute උපරිමය',
                ],

                'min' => [
                    'label' => 'අවම',
                    'summary' => ':attribute අවම',
                ],

                'sum' => [
                    'label' => 'මුළු එකතුව',
                    'summary' => ':attribute මුළු එකතුව',
                ],

            ],

            'form' => [

                'aggregate' => [
                    'label' => 'මුළු එකතුව',
                ],

                'number' => [
                    'label' => 'අංකය',
                ],

            ],

        ],

        'relationship' => [

            'equals' => [

                'label' => [
                    'direct' => 'සම',
                    'inverse' => 'සම නොවේ',
                ],

                'summary' => [
                    'direct' => ':count :relationship සම',
                    'inverse' => ':count :relationship සම නොවේ',
                ],

            ],

            'has_max' => [

                'label' => [
                    'direct' => 'උපරිමය ඇත',
                    'inverse' => 'උපරිමයෙන් වැඩි',
                ],

                'summary' => [
                    'direct' => ':relationship උපරිමය :count',
                    'inverse' => ':relationship උපරිමයෙන් වැඩි :count',
                ],

            ],

            'has_min' => [

                'label' => [
                    'direct' => 'අවමය ඇත',
                    'inverse' => 'අවමය අඩුයි',
                ],

                'summary' => [
                    'direct' => ':relationship අවමය :count',
                    'inverse' => ':relationship අවමය අඩුයි :count',
                ],

            ],

            'is_empty' => [

                'label' => [
                    'direct' => 'හිස්යි',
                    'inverse' => 'හිස් නොවේ',
                ],

                'summary' => [
                    'direct' => ':relationship හිස්යි',
                    'inverse' => ':relationship හිස් නොවේ',
                ],

            ],

            'is_related_to' => [

                'label' => [

                    'single' => [
                        'direct' => 'සම්බන්ධ',
                        'inverse' => 'සම්බන්ධ නොවේ',
                    ],

                    'multiple' => [
                        'direct' => 'අඩංගු',
                        'inverse' => 'අඩංගු නොවේ',
                    ],

                ],

                'summary' => [

                    'single' => [
                        'direct' => ':relationship :values සම්බන්ධ',
                        'inverse' => ':relationship :values සම්බන්ධ නොවේ',
                    ],

                    'multiple' => [
                        'direct' => ':relationship :values අඩංගු',
                        'inverse' => ':relationship :values අඩංගු නොවේ',
                    ],

                    'values_glue' => [
                        0 => ', ',
                        'final' => ' හෝ ',
                    ],

                ],

                'form' => [

                    'value' => [
                        'label' => 'අගය',
                    ],

                    'values' => [
                        'label' => 'අගයන්',
                    ],

                ],

            ],

            'form' => [

                'count' => [
                    'label' => 'ගණන',
                ],

            ],

        ],

        'select' => [

            'is' => [

                'label' => [
                    'direct' => 'වේ',
                    'inverse' => 'නොවේ',
                ],

                'summary' => [
                    'direct' => ':attribute :values වේ',
                    'inverse' => ':attribute :values නොවේ',
                    'values_glue' => [
                        ', ',
                        'final' => ' හෝ ',
                    ],
                ],

                'form' => [

                    'value' => [
                        'label' => 'අගය',
                    ],

                    'values' => [
                        'label' => 'අගයන්',
                    ],

                ],

            ],

        ],

        'text' => [

            'contains' => [

                'label' => [
                    'direct' => 'අඩංගුයි',
                    'inverse' => 'අඩංගු නොවේ',
                ],

                'summary' => [
                    'direct' => ':attribute :text අඩංගුයි',
                    'inverse' => ':attribute :text අඩංගු නොවේ',
                ],

            ],

            'ends_with' => [

                'label' => [
                    'direct' => 'ගින් අවසන් වේ',
                    'inverse' => 'ගින් අවසන් නොවේ',
                ],

                'summary' => [
                    'direct' => ':attribute :text ගින් අවසන් වේ',
                    'inverse' => ':attribute :text ගින් අවසන් නොවේ',
                ],

            ],

            'equals' => [

                'label' => [
                    'direct' => 'සම',
                    'inverse' => 'සම නොවේ',
                ],

                'summary' => [
                    'direct' => ':attribute :text සම',
                    'inverse' => ':attribute :text සම නොවේ',
                ],

            ],

            'starts_with' => [

                'label' => [
                    'direct' => 'ගින් ආරම්භ වේ',
                    'inverse' => 'ගින් ආරම්භ නොවේ',
                ],

                'summary' => [
                    'direct' => ':attribute :text ගින් ආරම්භ වේ',
                    'inverse' => ':attribute :text ගින් ආරම්භ නොවේ',
                ],

            ],

            'form' => [

                'text' => [
                    'label' => 'වචනය',
                ],

            ],

        ],

    ],

    'actions' => [

        'add_rule' => [
            'label' => 'නියමය එක් කරන්න',
        ],

        'add_rule_group' => [
            'label' => 'නියම සමූහය එක් කරන්න',
        ],

    ],

];
