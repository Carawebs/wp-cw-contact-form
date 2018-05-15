<?php
if (!defined('ABSPATH')) exit;
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
            'tab' => 'Form Email Options',
            'is_tab' => true,
            'option_name' => 'carawebs_contact_form',
            'option_group' => 'form-email-options',// At the moment, this MUST be the slugified 'tab' value @TODO Fix this!!
            'id' => 'form-email-options',
            'title' => 'Email Contact Form',
            'description' => 'Options for the contact form.',
            'fields' =>[
                [
                    'type' => 'text',
                    'name' => 'destination_email',
                    'title' => 'Destination Email',
                    'default' => NULL,
                ],
            ]
        ],
    ]
];
