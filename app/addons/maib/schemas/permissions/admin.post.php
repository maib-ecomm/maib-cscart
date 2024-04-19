<?php

defined('BOOTSTRAP') or die('Access denied');

$schema['maib_order'] = [
    'modes' => [
        'reverse' => [
            'permissions' => 'edit_order'
        ],
    ],
];

return $schema;