<?php

return [

    'builder' => [

        'actions' => [

            'clone' => [
                'label' => 'අනුකලනය කරන්න',
            ],

            'add' => [

                'label' => ':label වෙත එක් කරන්න',

                'modal' => [

                    'heading' => ':label වෙත එක් කරන්න',

                    'actions' => [

                        'add' => [
                            'label' => 'එක් කරන්න',
                        ],

                    ],

                ],

            ],

            'add_between' => [

                'label' => 'කොටස් අතර ඇතුලත් කරන්න',

                'modal' => [

                    'heading' => ':label වෙත එක් කරන්න',

                    'actions' => [

                        'add' => [
                            'label' => 'එක් කරන්න',
                        ],

                    ],

                ],

            ],

            'delete' => [
                'label' => 'මකන්න',
            ],

            'edit' => [

                'label' => 'සංස්කරණය කරන්න',

                'modal' => [

                    'heading' => 'කොටස සංස්කරණය කරන්න',

                    'actions' => [

                        'save' => [
                            'label' => 'වෙනස්කම් සුරකින්න',
                        ],

                    ],

                ],

            ],

            'reorder' => [
                'label' => 'නැවත සකසන්න',
            ],

            'move_down' => [
                'label' => 'පහළට ගමන් කරන්න',
            ],

            'move_up' => [
                'label' => 'ඉහළට ගමන් කරන්න',
            ],

            'collapse' => [
                'label' => 'සන්සුන් කරන්න',
            ],

            'expand' => [
                'label' => 'විශාල කරන්න',
            ],

            'collapse_all' => [
                'label' => 'සියල්ල සන්සුන් කරන්න',
            ],

            'expand_all' => [
                'label' => 'සියල්ල විශාල කරන්න',
            ],

        ],

    ],

    'checkbox_list' => [

        'actions' => [

            'deselect_all' => [
                'label' => 'සියල්ල අඛණ්ඩ කරන්න',
            ],

            'select_all' => [
                'label' => 'සියල්ල තෝරන්න',
            ],

        ],

    ],

    'file_upload' => [

        'editor' => [

            'actions' => [

                'cancel' => [
                    'label' => 'අවලංගු කරන්න',
                ],

                'drag_crop' => [
                    'label' => '“අපේක්ෂාව” ආකාරයට ඇදවීම',
                ],

                'drag_move' => [
                    'label' => '“ගමන්” ආකාරයට ඇදවීම',
                ],

                'flip_horizontal' => [
                    'label' => 'පිටපසට හරවන්න',
                ],

                'flip_vertical' => [
                    'label' => 'සිරස්ව හරවන්න',
                ],

                'move_down' => [
                    'label' => 'පින්තූරය පහළට ගමන් කරන්න',
                ],

                'move_left' => [
                    'label' => 'පින්තූරය වමට ගමන් කරන්න',
                ],

                'move_right' => [
                    'label' => 'පින්තූරය දකුණට ගමන් කරන්න',
                ],

                'move_up' => [
                    'label' => 'පින්තූරය ඉහළට ගමන් කරන්න',
                ],

                'reset' => [
                    'label' => 'නැවත සකසන්න',
                ],

                'rotate_left' => [
                    'label' => 'පින්තූරය වමට අනිවර්තනය කරන්න',
                ],

                'rotate_right' => [
                    'label' => 'පින්තූරය දකුණට අනිවර්තනය කරන්න',
                ],

                'set_aspect_ratio' => [
                    'label' => ':ratio සඳහා අනුපාතය සකසන්න',
                ],

                'save' => [
                    'label' => 'සුරකින්න',
                ],

                'zoom_100' => [
                    'label' => '100% විශාලනය',
                ],

                'zoom_in' => [
                    'label' => 'විශාලනය කරන්න',
                ],

                'zoom_out' => [
                    'label' => 'සන්සුන් කරන්න',
                ],

            ],

            'fields' => [

                'height' => [
                    'label' => 'උස',
                    'unit' => 'px',
                ],

                'rotation' => [
                    'label' => 'අනිවර්තනය',
                    'unit' => 'ඩිග්‍රී',
                ],

                'width' => [
                    'label' => 'පළල',
                    'unit' => 'px',
                ],

                'x_position' => [
                    'label' => 'X',
                    'unit' => 'px',
                ],

                'y_position' => [
                    'label' => 'Y',
                    'unit' => 'px',
                ],

            ],

            'aspect_ratios' => [

                'label' => 'අනුපාත',

                'no_fixed' => [
                    'label' => 'ස්වෛරී',
                ],

            ],

            'svg' => [

                'messages' => [
                    'confirmation' => 'SVG ගොනු සංස්කරණය කිරීම තීන්ත ගුණාත්මකත්වය අඩු කළ හැක. දිගටම කරන්නේද?',
                    'disabled' => 'SVG ගොනු සංස්කරණය අක්‍රියයි.',
                ],

            ],

        ],

    ],

    'key_value' => [

        'actions' => [

            'add' => [
                'label' => 'පේළියක් එක් කරන්න',
            ],

            'delete' => [
                'label' => 'පේළිය මකන්න',
            ],

            'reorder' => [
                'label' => 'පේළිය නැවත සකසන්න',
            ],

        ],

        'fields' => [

            'key' => [
                'label' => 'යතුර',
            ],

            'value' => [
                'label' => 'අගය',
            ],

        ],

    ],

    'markdown_editor' => [

        'toolbar_buttons' => [
            'attach_files' => 'ගොනු එක් කරන්න',
            'blockquote' => 'Blockquote',
            'bold' => 'තද',
            'bullet_list' => 'Bullet List',
            'code_block' => 'Code Block',
            'heading' => 'මාතෘකාව',
            'italic' => 'ඇලකසන ලද',
            'link' => 'සබැඳිය',
            'ordered_list' => 'අනුක්‍රමික ලැයිස්තුව',
            'redo' => 'නැවත කරන්න',
            'strike' => 'රේඛා මාරුව',
            'table' => 'වගුව',
            'undo' => 'අවලංගු කරන්න',
        ],

    ],

    'radio' => [

        'boolean' => [
            'true' => 'ඔව්',
            'false' => 'නැත',
        ],

    ],

    'repeater' => [

        'actions' => [

            'add' => [
                'label' => ':label සඳහා එකතු කරන්න',
            ],

            'add_between' => [
                'label' => 'මධ්‍යයේ ඇතුලත් කරන්න',
            ],

            'delete' => [
                'label' => 'මකන්න',
            ],

            'clone' => [
                'label' => 'අනුකලනය කරන්න',
            ],

            'reorder' => [
                'label' => 'නැවත සකසන්න',
            ],

            'move_down' => [
                'label' => 'පහළට ගමන් කරන්න',
            ],

            'move_up' => [
                'label' => 'ඉහළට ගමන් කරන්න',
            ],

            'collapse' => [
                'label' => 'සන්සුන් කරන්න',
            ],

            'expand' => [
                'label' => 'විශාල කරන්න',
            ],

            'collapse_all' => [
                'label' => 'සියල්ල සන්සුන් කරන්න',
            ],

            'expand_all' => [
                'label' => 'සියල්ල විශාල කරන්න',
            ],

        ],

    ],

    'rich_editor' => [

        'dialogs' => [

            'link' => [

                'actions' => [
                    'link' => 'සබැඳිය',
                    'unlink' => 'අසබැඳිය',
                ],

                'label' => 'URL',

                'placeholder' => 'URL ඇතුළත් කරන්න',

            ],

        ],

        'toolbar_buttons' => [
            'attach_files' => 'ගොනු එක් කරන්න',
            'blockquote' => 'Blockquote',
            'bold' => 'තද',
            'bullet_list' => 'Bullet List',
            'code_block' => 'Code Block',
            'h1' => 'මාතෘකාව',
            'h2' => 'උප මාතෘකාව',
            'italic' => 'ඇලකසන ලද',
            'link' => 'සබැඳිය',
            'ordered_list' => 'අනුක්‍රමික ලැයිස්තුව',
            'redo' => 'නැවත කරන්න',
            'strike' => 'රේඛා මාරුව',
            'underline' => 'අඩුරේඛාව',
            'undo' => 'අවලංගු කරන්න',
        ],

    ],

    'select' => [

        'actions' => [

            'create_option' => [

                'modal' => [

                    'heading' => 'සැකසීම',

                    'actions' => [

                        'create' => [
                            'label' => 'අලුත් කරන්න',
                        ],

                        'create_another' => [
                            'label' => 'අලුත් කර, තවත් එකක් කරන්න',
                        ],

                    ],

                ],

            ],

            'edit_option' => [

                'modal' => [

                    'heading' => 'සංස්කරණය',

                    'actions' => [

                        'save' => [
                            'label' => 'සුරකින්න',
                        ],

                    ],

                ],

            ],

        ],

        'boolean' => [
            'true' => 'ඔව්',
            'false' => 'නැත',
        ],

        'loading_message' => 'පූරණය වෙමින් පවතී...',
        'max_items_message' => 'කෙසේ හෝ :count ක් තෝරා ගත හැක.',
        'no_search_results_message' => 'ඔබගේ සෙවුමට ගැලපෙන විකල්ප නැත.',
        'placeholder' => 'විකල්පයක් තෝරන්න',
        'searching_message' => 'සෙවීම සිදු වෙමින්...',
        'search_prompt' => 'සෙවීම ආරම්භ කිරීමට ටයිප් කරන්න...',

    ],

    'tags_input' => [
        'placeholder' => 'නව ටැගය',
    ],

    'text_input' => [

        'actions' => [

            'hide_password' => [
                'label' => 'මුරපදය සඟවන්න',
            ],

            'show_password' => [
                'label' => 'මුරපදය පෙන්වන්න',
            ],

        ],

    ],

    'toggle_buttons' => [

        'boolean' => [
            'true' => 'ඔව්',
            'false' => 'නැත',
        ],

    ],

    'wizard' => [

        'actions' => [

            'previous_step' => [
                'label' => 'පෙරට යන්න',
            ],

            'next_step' => [
                'label' => 'ඊළඟට යන්න',
            ],

        ],

    ],

];
