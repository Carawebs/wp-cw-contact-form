<?php
if ( ! defined( 'ABSPATH' ) ) exit;
return [
    'type' => 'options_page',
    'setting' => [
        'option_name' => 'carawebs_contact_form',
        'option_group' => 'main'
    ],
    'default_tab' => 'main',
    'page' => [
        'page_title' => 'Carawebs Simple Email Contact Form',
        'menu_title' => 'Contact Form',
        'capability' => 'manage_options',
        'unique_page_slug' => 'carawebs-contact-form-options-page',
    ],
    'sections' => [
        [
            'tab' => 'Main',
            'is_tab' => true,
            'option_name' => 'carawebs_contact_fields',
            'option_group' => 'main',
            'id' => 'main',
            'title' => 'Form Fields',
            'description' => 'This is the main section.',
            'fields' =>[
                [
                    'type' => 'text',
                    'name' => 'destination_email',
                    'title' => 'Destination Email',
                    'default' => NULL,
                ],
                [
                    'type' => 'text',
                    'name' => 'line_1',
                    'title' => 'Address Line One',
                    'default' => NULL,
                    'placeholder' => 'Type here'
                ]
            ]
        ],
        [
            'tab' => 'Social Media',
            'option_name' => 'carawebs_social',
            'option_group' => 'social-media', // At the moment, this MUST be the slugified 'tab' value @TODO Fix this!!
            'id' => 'social-media',
            'title' => 'Social Media',
            'description' => 'The social stuff.',
            'fields' =>[
                [
                    'type' => 'text',
                    'name' => 'facebook',
                    'title' => 'Facebook',
                    'desc' => 'Enter the URL of your Facebook page',
                    'placeholder' => ''
                ],
                [
                    'type' => 'text',
                    'name' => 'twitter',
                    'title' => 'Twitter',
                    'desc' => 'Enter the URL of your Twitter page',
                    'placeholder' => ''
                ]
            ],
        ],
    ]
];
