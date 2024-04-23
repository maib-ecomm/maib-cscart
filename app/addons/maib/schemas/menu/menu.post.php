<?php

if (!defined('AREA')) {
    die('Access denied');
}

$schema['central']['orders']['items']['payments'] = array(
    'attrs' => array(
        'class' => 'is-addon'
    ),
    'href' => 'orders.manage',
    'position' => 1000
);

return $schema;