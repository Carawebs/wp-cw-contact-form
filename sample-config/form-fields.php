<?php
if ( ! defined( 'ABSPATH' ) ) exit;
$fields = [
    [
        'input' => 'name',
        'input' => 'company',
        'textarea' => 'message',
        'radio' => [
            'first'   => 'First',
            'second' => 'Second',
        ]
    ],
];
return $fields;
