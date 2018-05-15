<?php
if (!defined('ABSPATH')) exit;
$privacyPage = esc_url(home_url('/privacy'));
$fields = [
    'name' => [
        'name' => 'name',
        'nice_name' => 'Name',
        'type' => 'text',
        'label' => 'Name',
        //'placeholder' => 'Please enter your name (required)',
        'required' => true
    ],
    'email' => [
        'name' => 'email',
        'nice_name' => 'Email',
        'type' => 'email',
        'label' => 'Email',
        'required' => true,
    ],
    'company' => [
        'name' => 'company',
        'nice_name' => 'Company',
        'type' => 'text',
        'label' => 'Your Company',
    ],
    'position' => [
        'name' => 'position',
        'nice_name' => 'Position',
        'type' => 'text',
        'label' => 'Job Title',
    ],
    'about' => [
        'name' => 'about',
        'nice_name' => 'Person\'s interest',
        'type' => 'radio',
        'options'=> [
            // $value => $label
            'Client'   => 'Client',
            'Consultant' => 'Consultant',
            'Main Contractor' => 'Main Contractor',
            'Specialist Contractor' => 'Specialist Contractor',
        ],
        'label' => 'Please tell us about yourself:'
    ],
    'consent' => [
        'name' => 'user-consent',
        'nice_name' => 'Privacy',
        'type' => 'checkbox',
        'label' => 'I consent to GIRI collecting my name, email address, my company name and my job title.',
        'required' => true,
        'class' => 'top-border',
        'extra_html' => "<p class='small'>This form collects your details so that we can contact you to give you information on becoming a member of the Get it Right Initiative. For more information on how we use and store your details please visit our <a href='$privacyPage'>privacy page</a></p>"
    ],
    // 'info' => [
    //     'label' => 'See our full <a href="/privacy">privacy statement</a>...',
    //     'type' => 'paragraph'
    // ]
];
return $fields;
