<?php

return [

    'builder' => [

        'actions' => [

            'clone' => [
                'label' => 'நகலெடுக்கவும்',
            ],

            'add' => [

                'label' => ':label இல் சேர்க்கவும்',

                'modal' => [

                    'heading' => ':label இல் சேர்க்கவும்',

                    'actions' => [

                        'add' => [
                            'label' => 'சேர்க்கவும்',
                        ],

                    ],

                ],

            ],

            'add_between' => [

                'label' => 'இரண்டு தொகுதிகளுக்கிடையில் சேர்க்கவும்',

                'modal' => [

                    'heading' => ':label இல் சேர்க்கவும்',

                    'actions' => [

                        'add' => [
                            'label' => 'சேர்க்கவும்',
                        ],

                    ],

                ],

            ],

            'delete' => [
                'label' => 'நீக்கவும்',
            ],

            'edit' => [

                'label' => 'தொகுக்க',

                'modal' => [

                    'heading' => 'தொகுதியை திருத்தவும்',

                    'actions' => [

                        'save' => [
                            'label' => 'மாற்றங்களைச் சேமிக்கவும்',
                        ],

                    ],

                ],

            ],

            'reorder' => [
                'label' => 'நகர்த்தவும்',
            ],

            'move_down' => [
                'label' => 'கீழே நகர்த்தவும்',
            ],

            'move_up' => [
                'label' => 'மேலே நகர்த்தவும்',
            ],

            'collapse' => [
                'label' => 'சுருக்கவும்',
            ],

            'expand' => [
                'label' => 'விரிவாக்கவும்',
            ],

            'collapse_all' => [
                'label' => 'எல்லாவற்றையும் சுருக்கவும்',
            ],

            'expand_all' => [
                'label' => 'எல்லாவற்றையும் விரிவாக்கவும்',
            ],

        ],

    ],

    'checkbox_list' => [

        'actions' => [

            'deselect_all' => [
                'label' => 'எல்லாவற்றையும் தடயமிட வேண்டாம்',
            ],

            'select_all' => [
                'label' => 'எல்லாவற்றையும் தேர்ந்தெடுக்கவும்',
            ],

        ],

    ],

    'file_upload' => [

        'editor' => [

            'actions' => [

                'cancel' => [
                    'label' => 'ரத்து செய்யவும்',
                ],

                'drag_crop' => [
                    'label' => 'சுருக்கல் முறை',
                ],

                'drag_move' => [
                    'label' => 'நகர்த்தல் முறை',
                ],

                'flip_horizontal' => [
                    'label' => 'குறுக்கு திருப்பவும்',
                ],

                'flip_vertical' => [
                    'label' => 'செங்குத்து திருப்பவும்',
                ],

                'move_down' => [
                    'label' => 'கீழே நகர்த்தவும்',
                ],

                'move_left' => [
                    'label' => 'இடப்பக்கமாக நகர்த்தவும்',
                ],

                'move_right' => [
                    'label' => 'வலப்பக்கமாக நகர்த்தவும்',
                ],

                'move_up' => [
                    'label' => 'மேலே நகர்த்தவும்',
                ],

                'reset' => [
                    'label' => 'மீட்டமை',
                ],

                'rotate_left' => [
                    'label' => 'இடது பக்கம் சுழற்றவும்',
                ],

                'rotate_right' => [
                    'label' => 'வலது பக்கம் சுழற்றவும்',
                ],

                'set_aspect_ratio' => [
                    'label' => 'விகிதம் அமைக்கவும் :ratio',
                ],

                'save' => [
                    'label' => 'சேமிக்கவும்',
                ],

                'zoom_100' => [
                    'label' => '100% ஜூம்',
                ],

                'zoom_in' => [
                    'label' => 'ஜூம் அதிகரிக்கவும்',
                ],

                'zoom_out' => [
                    'label' => 'ஜூம் குறைக்கவும்',
                ],

            ],

            'fields' => [

                'height' => [
                    'label' => 'உயரம்',
                    'unit' => 'px',
                ],

                'rotation' => [
                    'label' => 'சுழற்சி',
                    'unit' => 'டிகிரி',
                ],

                'width' => [
                    'label' => 'அகலம்',
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

                'label' => 'விகிதங்கள்',

                'no_fixed' => [
                    'label' => 'இசைவானது',
                ],

            ],

            'svg' => [

                'messages' => [
                    'confirmation' => 'SVG கோப்புகளைத் திருத்துவது தரக்குறைவுக்கு காரணமாகலாம். தொடர விரும்புகிறீர்களா?',
                    'disabled' => 'SVG கோப்புகளைத் திருத்துவது முடக்கப்பட்டுள்ளது.',
                ],

            ],

        ],

    ],

    'key_value' => [

        'actions' => [

            'add' => [
                'label' => 'வரிசையைச் சேர்க்கவும்',
            ],

            'delete' => [
                'label' => 'வரிசையை நீக்கவும்',
            ],

            'reorder' => [
                'label' => 'வரிசையை நகர்த்தவும்',
            ],

        ],

        'fields' => [

            'key' => [
                'label' => 'முக்கிய',
            ],

            'value' => [
                'label' => 'மதிப்பு',
            ],

        ],

    ],

    'markdown_editor' => [

        'toolbar_buttons' => [
            'attach_files' => 'கோப்புகளை இணைக்கவும்',
            'blockquote' => 'தொகுப்பு மேற்கோள்',
            'bold' => 'தடித்த',
            'bullet_list' => 'புள்ளியிட்ட பட்டியல்',
            'code_block' => 'குறியீடு தொகுதி',
            'heading' => 'தலைப்பு',
            'italic' => 'சாய்ந்த',
            'link' => 'இணைப்பு',
            'ordered_list' => 'அணுகப்பட்ட பட்டியல்',
            'redo' => 'மீண்டும் செய்யவும்',
            'strike' => 'வெட்டு',
            'table' => 'அட்டவணை',
            'undo' => 'அழிக்கவும்',
        ],

    ],

    'radio' => [

        'boolean' => [
            'true' => 'ஆம்',
            'false' => 'இல்லை',
        ],

    ],

    'repeater' => [

        'actions' => [

            'add' => [
                'label' => ':label இல் சேர்க்கவும்',
            ],

            'add_between' => [
                'label' => 'இடையில் சேர்க்கவும்',
            ],

            'delete' => [
                'label' => 'நீக்கவும்',
            ],

            'clone' => [
                'label' => 'நகலெடுக்கவும்',
            ],

            'reorder' => [
                'label' => 'நகர்த்தவும்',
            ],

            'move_down' => [
                'label' => 'கீழே நகர்த்தவும்',
            ],

            'move_up' => [
                'label' => 'மேலே நகர்த்தவும்',
            ],

            'collapse' => [
                'label' => 'சுருக்கவும்',
            ],

            'expand' => [
                'label' => 'விரிவாக்கவும்',
            ],

            'collapse_all' => [
                'label' => 'எல்லாவற்றையும் சுருக்கவும்',
            ],

            'expand_all' => [
                'label' => 'எல்லாவற்றையும் விரிவாக்கவும்',
            ],

        ],

    ],

    'rich_editor' => [

        'dialogs' => [

            'link' => [

                'actions' => [
                    'link' => 'இணைக்கவும்',
                    'unlink' => 'துண்டிக்கவும்',
                ],

                'label' => 'URL',

                'placeholder' => 'URL உள்ளிடவும்',

            ],

        ],

        'toolbar_buttons' => [
            'attach_files' => 'கோப்புகளை இணைக்கவும்',
            'blockquote' => 'மூலோசை',
            'bold' => 'தடித்த',
            'bullet_list' => 'புள்ளியிட்ட பட்டியல்',
            'code_block' => 'குறியீடு தொகுதி',
            'h1' => 'முதல் தலைப்பு',
            'h2' => 'தலைப்பு',
            'h3' => 'துணைத் தலைப்பு',
            'italic' => 'சாய்ந்த',
            'link' => 'இணைப்பு',
            'ordered_list' => 'ஒழுங்கமைக்கப்பட்ட பட்டியல்',
            'redo' => 'மீண்டும் செய்யவும்',
            'strike' => 'வெட்டுகை',
            'underline' => 'கீழே கோடிடு',
            'undo' => 'மீட்டமை',
        ],

    ],

    'select' => [

        'actions' => [

            'create_option' => [

                'modal' => [

                    'heading' => 'செய்யவும்',

                    'actions' => [

                        'create' => [
                            'label' => 'செய்யவும்',
                        ],

                        'create_another' => [
                            'label' => 'செய்து மீண்டும் செய்யவும்',
                        ],

                    ],

                ],

            ],

            'edit_option' => [

                'modal' => [

                    'heading' => 'திருத்தவும்',

                    'actions' => [

                        'save' => [
                            'label' => 'சேமிக்கவும்',
                        ],

                    ],

                ],

            ],

        ],

        'boolean' => [
            'true' => 'ஆம்',
            'false' => 'இல்லை',
        ],

        'loading_message' => 'ஏற்றுகிறது...',

        'max_items_message' => 'மிக அதிகமாக :count தேர்வு செய்ய முடியும்.',

        'no_search_results_message' => 'தேடலுக்கேற்ப விருப்பங்கள் இல்லை.',

        'placeholder' => 'விருப்பத்தைத் தேர்வுசெய்க',

        'searching_message' => 'தேடல் நடக்கிறது...',

        'search_prompt' => 'தேடல் தொடங்க உள்ளிடவும்...',

    ],

    'tags_input' => [
        'placeholder' => 'புதிய குறிச்சொல்',
    ],

    'text_input' => [

        'actions' => [

            'hide_password' => [
                'label' => 'கடவுச்சொல்லை மறைக்கவும்',
            ],

            'show_password' => [
                'label' => 'கடவுச்சொல்லை காட்டவும்',
            ],

        ],

    ],

    'toggle_buttons' => [

        'boolean' => [
            'true' => 'ஆம்',
            'false' => 'இல்லை',
        ],

    ],

    'wizard' => [

        'actions' => [

            'previous_step' => [
                'label' => 'முந்தையது',
            ],

            'next_step' => [
                'label' => 'அடுத்தது',
            ],

        ],

    ],

];
