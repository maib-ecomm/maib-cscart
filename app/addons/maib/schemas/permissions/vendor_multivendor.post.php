<?php

defined('BOOTSTRAP') or die('Access denied');

$schema['controllers']['maib_order'] = [
    'modes' => [
        'reverse' => [
            'permissions' => true,
        ],
        'check' => [
            'permissions' => true,
        ],
    ],
];

return $schema;