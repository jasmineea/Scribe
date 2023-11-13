<?php

return [
    'exchange' => [
        'title' => 'HandWritten Card Pricing',
        'desc' => '1 HandWritten Card => 1 Credit',
        'icon' => '',

        'elements' => [
            [
                'type' => 'text', // input fields type
                'data' => 'text', // data type, string, int, boolean
                'name' => 'credit_exchange_rate', // unique name for field
                'label' => 'Enter per card pricing', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '1.00', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ]
        ],

    ],
    'default_currency' => [
        'title' => 'Default System Currency',
        'desc' => '',
        'icon' => '',

        'elements' => [
            [
                'type' => 'text', // input fields type
                'data' => 'text', // data type, string, int, boolean
                'name' => 'currency_code', // unique name for field
                'label' => 'Enter Currency Code', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'GBP', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],
        ],

    ],
    'initial_bonus' => [
        'title' => 'Initial Credit Bonus',
        'desc' => '',
        'icon' => '',

        'elements' => [
            [
                'type' => 'text', // input fields type
                'data' => 'text', // data type, string, int, boolean
                'name' => 'initial_bonus', // unique name for field
                'label' => 'Enter Credit Amount', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '0', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],
        ],

    ],'master_file_limit' => [
        'title' => 'Master File Record limit',
        'desc' => '',
        'icon' => '',

        'elements' => [
            [
                'type' => 'text', // input fields type
                'data' => 'text', // data type, string, int, boolean
                'name' => 'master_file_record_limit', // unique name for field
                'label' => 'Master File Record Limit ', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '100', // default value if you want
                'help' => '', // Help text for the input field.
            ],
        ],

    ],
    'tooltip_messages' => [
        'title' => 'ToolTip Messages',
        'desc' => '',
        'icon' => 'fas fa-money',

        'elements' => [
            [
                'type' => 'text', // input fields type
                'data' => 'text', // data type, string, int, boolean
                'name' => 'step_1_tooltip_title', // unique name for field
                'label' => 'Enter Tooltip Title  For Step 1', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'Tooltip Title', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],[
                'type' => 'text', // input fields type
                'data' => 'text', // data type, string, int, boolean
                'name' => 'step_1_tooltip_message', // unique name for field
                'label' => 'Enter Tooltip Message  For Step 1', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'This is step one where <br> you can add custom message.', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],[
                'type' => 'text', // input fields type
                'data' => 'text', // data type, string, int, boolean
                'name' => 'step_1_video_link', // unique name for field
                'label' => 'Enter Video Link  For Step 1', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'This is step one where <br> you can add custom message.', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],[
                'type' => 'text', // input fields type
                'data' => 'text', // data type, string, int, boolean
                'name' => 'step_2_tooltip_title', // unique name for field
                'label' => 'Enter Tooltip Title  For Step 2', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'Tooltip Title', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],[
                'type' => 'text', // input fields type
                'data' => 'text', // data type, string, int, boolean
                'name' => 'step_2_tooltip_message', // unique name for field
                'label' => 'Enter Tooltip Message  For Step 2', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'This is step one where <br> you can add custom message.', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],[
                'type' => 'text', // input fields type
                'data' => 'text', // data type, string, int, boolean
                'name' => 'step_2_video_link', // unique name for field
                'label' => 'Enter Video Link  For Step 2', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'This is step one where <br> you can add custom message.', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],[
                'type' => 'text', // input fields type
                'data' => 'text', // data type, string, int, boolean
                'name' => 'step_3_tooltip_title', // unique name for field
                'label' => 'Enter Tooltip Title  For Step 3 (For Recipient List Selection)', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'Tooltip Title', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],[
                'type' => 'text', // input fields type
                'data' => 'text', // data type, string, int, boolean
                'name' => 'step_3_tooltip_message', // unique name for field
                'label' => 'Enter Tooltip Message  For Step 3  (For Recipient List Selection)', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'This is step one where <br> you can add custom message.', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],[
                'type' => 'text', // input fields type
                'data' => 'text', // data type, string, int, boolean
                'name' => 'step_3_video_link', // unique name for field
                'label' => 'Enter Video Link  For Step 3  (For Recipient List Selection)', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'This is step one where <br> you can add custom message.', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],[
                'type' => 'text', // input fields type
                'data' => 'text', // data type, string, int, boolean
                'name' => 'step_3a_tooltip_title', // unique name for field
                'label' => 'Enter Tooltip Title  For Step 3  (For Recipient File Upload)', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'Tooltip Title', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],[
                'type' => 'text', // input fields type
                'data' => 'text', // data type, string, int, boolean
                'name' => 'step_3a_tooltip_message', // unique name for field
                'label' => 'Enter Tooltip Message  For Step 3  (For Recipient File Upload)', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'This is step one where <br> you can add custom message.', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],[
                'type' => 'text', // input fields type
                'data' => 'text', // data type, string, int, boolean
                'name' => 'step_3a_video_link', // unique name for field
                'label' => 'Enter Video Link  For Step 3  (For Recipient File Upload)', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'This is step one where <br> you can add custom message.', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],[
                'type' => 'text', // input fields type
                'data' => 'text', // data type, string, int, boolean
                'name' => 'step_4_tooltip_title', // unique name for field
                'label' => 'Enter Tooltip Title  For Step 4', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'Tooltip Title', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],[
                'type' => 'text', // input fields type
                'data' => 'text', // data type, string, int, boolean
                'name' => 'step_4_tooltip_message', // unique name for field
                'label' => 'Enter Tooltip Message  For Step 4', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'This is step one where <br> you can add custom message.', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],[
                'type' => 'text', // input fields type
                'data' => 'text', // data type, string, int, boolean
                'name' => 'step_4_video_link', // unique name for field
                'label' => 'Enter Video Link  For Step 4', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'This is step one where <br> you can add custom message.', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],[
                'type' => 'text', // input fields type
                'data' => 'text', // data type, string, int, boolean
                'name' => 'step_5_tooltip_title', // unique name for field
                'label' => 'Enter Tooltip Title  For Step 5  (For one time campaign)', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'Tooltip Title', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],[
                'type' => 'text', // input fields type
                'data' => 'text', // data type, string, int, boolean
                'name' => 'step_5_tooltip_message', // unique name for field
                'label' => 'Enter Tooltip Message  For Step 5  (For one time campaign)', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'This is step one where <br> you can add custom message.', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],[
                'type' => 'text', // input fields type
                'data' => 'text', // data type, string, int, boolean
                'name' => 'step_5_video_link', // unique name for field
                'label' => 'Enter Video Link  For Step 5  (For one time campaign)', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'This is step one where <br> you can add custom message.', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],[
                'type' => 'text', // input fields type
                'data' => 'text', // data type, string, int, boolean
                'name' => 'step_5a_tooltip_title', // unique name for field
                'label' => 'Enter Tooltip Title  For Step 5  (For on going campaign)', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'Tooltip Title', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],[
                'type' => 'text', // input fields type
                'data' => 'text', // data type, string, int, boolean
                'name' => 'step_5a_tooltip_message', // unique name for field
                'label' => 'Enter Tooltip Message  For Step 5  (For on going campaign)', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'This is step one where <br> you can add custom message.', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],[
                'type' => 'text', // input fields type
                'data' => 'text', // data type, string, int, boolean
                'name' => 'step_5a_video_link', // unique name for field
                'label' => 'Enter Video Link  For Step 5  (For on going campaign)', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'This is step one where <br> you can add custom message.', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],[
                'type' => 'text', // input fields type
                'data' => 'text', // data type, string, int, boolean
                'name' => 'step_6_tooltip_title', // unique name for field
                'label' => 'Enter Tooltip Title For wallet Page', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'Tooltip Title', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],[
                'type' => 'text', // input fields type
                'data' => 'text', // data type, string, int, boolean
                'name' => 'step_6_tooltip_message', // unique name for field
                'label' => 'Enter Tooltip Message For wallet Page', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'This is step one where <br> you can add custom message.', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],[
                'type' => 'text', // input fields type
                'data' => 'text', // data type, string, int, boolean
                'name' => 'step_6_video_link', // unique name for field
                'label' => 'Enter Video Link For wallet Page', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'This is step one where <br> you can add custom message.', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],[
                'type' => 'text', // input fields type
                'data' => 'text', // data type, string, int, boolean
                'name' => 'step_7_tooltip_title', // unique name for field
                'label' => 'Enter Tooltip Title For Campaign Page', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'Tooltip Title', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],[
                'type' => 'text', // input fields type
                'data' => 'text', // data type, string, int, boolean
                'name' => 'step_7_tooltip_message', // unique name for field
                'label' => 'Enter Tooltip Message For Campaign Page', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'This is step one where <br> you can add custom message.', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],[
                'type' => 'text', // input fields type
                'data' => 'text', // data type, string, int, boolean
                'name' => 'step_7_video_link', // unique name for field
                'label' => 'Enter Video Link For Campaign Page', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'This is step one where <br> you can add custom message.', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],[
                'type' => 'text', // input fields type
                'data' => 'text', // data type, string, int, boolean
                'name' => 'step_8_tooltip_title', // unique name for field
                'label' => 'Enter Tooltip Title For Campaign Detail Page', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'Tooltip Title', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],[
                'type' => 'text', // input fields type
                'data' => 'text', // data type, string, int, boolean
                'name' => 'step_8_tooltip_message', // unique name for field
                'label' => 'Enter Tooltip Message For Campaign Detail Page', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'This is step one where <br> you can add custom message.', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],[
                'type' => 'text', // input fields type
                'data' => 'text', // data type, string, int, boolean
                'name' => 'step_8_video_link', // unique name for field
                'label' => 'Enter Video Link For Campaign Detail Page', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'This is step one where <br> you can add custom message.', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],[
                'type' => 'text', // input fields type
                'data' => 'text', // data type, string, int, boolean
                'name' => 'step_9_tooltip_title', // unique name for field
                'label' => 'Enter Tooltip Title For Recipient List Page', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'Tooltip Title', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],[
                'type' => 'text', // input fields type
                'data' => 'text', // data type, string, int, boolean
                'name' => 'step_9_tooltip_message', // unique name for field
                'label' => 'Enter Tooltip Message For Recipient List Page', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'This is step one where <br> you can add custom message.', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],[
                'type' => 'text', // input fields type
                'data' => 'text', // data type, string, int, boolean
                'name' => 'step_9_video_link', // unique name for field
                'label' => 'Enter Video Link For Recipient List Page', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'This is step one where <br> you can add custom message.', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],[
                'type' => 'text', // input fields type
                'data' => 'text', // data type, string, int, boolean
                'name' => 'step_10_tooltip_title', // unique name for field
                'label' => 'Enter Tooltip Title For Recipient Detail Page', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'Tooltip Title', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],[
                'type' => 'text', // input fields type
                'data' => 'text', // data type, string, int, boolean
                'name' => 'step_10_tooltip_message', // unique name for field
                'label' => 'Enter Tooltip Message For Recipient Detail Page', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'This is step one where <br> you can add custom message.', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],[
                'type' => 'text', // input fields type
                'data' => 'text', // data type, string, int, boolean
                'name' => 'step_10_video_link', // unique name for field
                'label' => 'Enter Video Link For Recipient Detail Page', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'This is step one where <br> you can add custom message.', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ]
        ],

    ],
    'squareup_api_keys' => [
        'title' => 'Squareup Api Keys',
        'desc' => '',
        'icon' => 'fas fa-money',

        'elements' => [
            [
                'type' => 'text', // input fields type
                'data' => 'text', // data type, string, int, boolean
                'name' => 'squareup_application_id', // unique name for field
                'label' => 'Enter Application ID', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'sandbox-sq0idb-0HOtgAjRVyzoCelY6fwvVw', // default value if you want
                'help' => '', // Help text for the input field.
            ],[
                'type' => 'text', // input fields type
                'data' => 'text', // data type, string, int, boolean
                'name' => 'squareup_access_token', // unique name for field
                'label' => 'Enter Access Token', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'EAAAECrCY5zTXusfmhgD8wkJNEdM9ZwtNlQi_-6pC2ZFSGb8N4qzD9IjZCVEU_q3', // default value if you want
                'help' => '.', // Help text for the input field.
            ],[
                'type' => 'text', // input fields type
                'data' => 'text', // data type, string, int, boolean
                'name' => 'squareup_location_id', // unique name for field
                'label' => 'Enter Location ID', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'LM3JJ2DGX1HKR', // default value if you want
                'help' => '.', // Help text for the input field.
            ],[
                'type' => 'text', // input fields type
                'data' => 'text', // data type, string, int, boolean
                'name' => 'squareup_environment', // unique name for field
                'label' => 'Enter Environment (sandbox or live)', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'sandbox', // default value if you want
                'help' => 'sanbox or live', // Help text for the input field.
            ]
        ],

    ],
    'card_written_pricing' => [
        'title' => 'Price Per Credit',
        'desc' => '',
        'icon' => 'fas fa-money',

        'elements' => [
            [
                'type' => 'text', // input fields type
                'data' => 'text', // data type, string, int, boolean
                'name' => 'card_written_pricing_less_then_equal_to_100', // unique name for field
                'label' => 'Enter pricing for less then equal to 100 credit', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '3.49', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],[
                'type' => 'text', // input fields type
                'data' => 'text', // data type, string, int, boolean
                'name' => 'card_written_pricing_101_to_500', // unique name for field
                'label' => 'Enter pricing for 101 to 500 credit', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '2.99', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],[
                'type' => 'text', // input fields type
                'data' => 'text', // data type, string, int, boolean
                'name' => 'card_written_pricing_501_to_1000', // unique name for field
                'label' => 'Enter pricing for 501 to 1000 credit', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '2.49', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],[
                'type' => 'text', // input fields type
                'data' => 'text', // data type, string, int, boolean
                'name' => 'card_written_pricing_1001_to_2000', // unique name for field
                'label' => 'Enter pricing for 1001 to 2000 credit', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '2.29', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],[
                'type' => 'text', // input fields type
                'data' => 'text', // data type, string, int, boolean
                'name' => 'card_written_pricing_greater_2000', // unique name for field
                'label' => 'Enter pricing for more then 2000 credit', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '1.99', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],
        ],

    ],
    'app' => [
        'title' => 'General',
        'desc' => 'All the general settings for application.',
        'icon' => 'fas fa-cube',

        'elements' => [
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'app_name', // unique name for field
                'label' => 'App Name', // you know what label it is
                'rules' => 'required|min:2|max:50', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'Laravel Starter', // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'footer_text', // unique name for field
                'label' => 'Footer Text', // you know what label it is
                'rules' => 'required|min:2', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '', // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'footer_text', // unique name for field
                'label' => 'Footer Text', // you know what label it is
                'rules' => 'required|min:2', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '', // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'Support_Email', // unique name for field
                'label' => 'Mail Support Email', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'James Schutrop', // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'Support_Phone_Number', // unique name for field
                'label' => 'Mail Support Phone Number', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'James Schutrop', // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'Your_Name', // unique name for field
                'label' => 'Mail Your Name', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'James Schutrop', // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'Your_Title', // unique name for field
                'label' => 'Mail Your Title', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'Founder & CEO', // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'Your_Contact_Information', // unique name for field
                'label' => 'Mail Your Contact Information', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '612.482.9796', // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'Product_Name_Team', // unique name for field
                'label' => 'Mail Product Name Team', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'Scribe Handwritten', // default value if you want
            ],
            [
                'type' => 'checkbox', // input fields type
                'data' => 'text', // data type, string, int, boolean
                'name' => 'show_copyright', // unique name for field
                'label' => 'Show Copyright', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '1', // default value if you want
            ],
        ],
    ],
    'email' => [
        'title' => 'Email',
        'desc' => 'Email settings for app',
        'icon' => 'fas fa-envelope',

        'elements' => [
            [
                'type' => 'email', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'email', // unique name for field
                'label' => 'Email', // you know what label it is
                'rules' => 'required|email', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'info@example.com', // default value if you want
            ],
        ],

    ],
    'social' => [
        'title' => 'Social Profiles',
        'desc' => 'Link of all the social profiles.',
        'icon' => 'fas fa-users',

        'elements' => [
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'facebook_url', // unique name for field
                'label' => 'Facebook Page URL', // you know what label it is
                'rules' => 'required|nullable|max:191', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '#', // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'twitter_url', // unique name for field
                'label' => 'Twitter Profile URL', // you know what label it is
                'rules' => 'required|nullable|max:191', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '#', // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'instagram_url', // unique name for field
                'label' => 'Instagram Account URL', // you know what label it is
                'rules' => 'required|nullable|max:191', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '#', // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'linkedin_url', // unique name for field
                'label' => 'LinkedIn URL', // you know what label it is
                'rules' => 'required|nullable|max:191', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '#', // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'youtube_url', // unique name for field
                'label' => 'Youtube Channel URL', // you know what label it is
                'rules' => 'required|nullable|max:191', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '#', // default value if you want
            ],
        ],

    ],
    'meta' => [
        'title' => 'Meta ',
        'desc' => 'Application Meta Data',
        'icon' => 'fas fa-globe-asia',

        'elements' => [
            [
                'type' => 'text', // input fields type
                'data' => 'text', // data type, string, int, boolean
                'name' => 'meta_site_name', // unique name for field
                'label' => 'Meta Site Name', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'Awesome Laravel | A Laravel Starter Project', // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'text', // data type, string, int, boolean
                'name' => 'meta_description', // unique name for field
                'label' => 'Meta Description', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'A CMS like modular starter application project built with Laravel 10.', // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'text', // data type, string, int, boolean
                'name' => 'meta_keyword', // unique name for field
                'label' => 'Meta Keyword', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'Web Application, Laravel,Laravel starter,Bootstrap,Admin,Template,Open,Source, nasir khan, nasirkhan', // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'text', // data type, string, int, boolean
                'name' => 'meta_image', // unique name for field
                'label' => 'Meta Image', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'img/default_banner.jpg', // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'text', // data type, string, int, boolean
                'name' => 'meta_fb_app_id', // unique name for field
                'label' => 'Meta Facebook App Id', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '569561286532601', // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'text', // data type, string, int, boolean
                'name' => 'meta_twitter_site', // unique name for field
                'label' => 'Meta Twitter Site Account', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '@nasir8891', // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'text', // data type, string, int, boolean
                'name' => 'meta_twitter_creator', // unique name for field
                'label' => 'Meta Twitter Creator Account', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '@nasir8891', // default value if you want
            ],
        ],
    ],
    'analytics' => [
        'title' => 'Analytics',
        'desc' => 'Application Analytics',
        'icon' => 'fas fa-chart-line',

        'elements' => [
            [
                'type' => 'text', // input fields type
                'data' => 'text', // data type, string, int, boolean
                'name' => 'google_analytics', // unique name for field
                'label' => 'Google Analytics (gtag)', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'G-ABCDE12345', // default value if you want
                'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
            ],
        ],

    ],
    'custom_css' => [
        'title' => 'Custom Code',
        'desc' => 'Custom code area',
        'icon' => 'fa-solid fa-file-code',

        'elements' => [
            [
                'type' => 'textarea', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'custom_css_block', // unique name for field
                'label' => 'Custom Css Code', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '', // default value if you want
                'help' => 'Paste the code in this field.', // Help text for the input field.
                'display' => 'raw', // Help text for the input field.
            ],
        ],

    ],
];
