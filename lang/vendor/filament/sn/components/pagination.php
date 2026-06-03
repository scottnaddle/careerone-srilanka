<?php

return [

    'label' => 'පිටුගත කිරීමේ මාර්ගසටහන',

    'overview' => '{1} ප්‍රතිඵල 1 ක් පෙන්වයි|[2,*] :first සිට :last දක්වා :total ප්‍රතිඵල පෙන්වයි',

    'fields' => [

        'records_per_page' => [

            'label' => 'පිටුවකට',

            'options' => [
                'all' => 'සියල්ල',
            ],

        ],

    ],

    'actions' => [

        'first' => [
            'label' => 'පළමු',
        ],

        'go_to_page' => [
            'label' => 'පිටුව :page වෙත යන්න',
        ],

        'last' => [
            'label' => 'අවසාන',
        ],

        'next' => [
            'label' => 'මීළඟ',
        ],

        'previous' => [
            'label' => 'කලින්',
        ],

    ],

];
