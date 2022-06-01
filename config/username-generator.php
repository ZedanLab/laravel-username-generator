<?php
// config for ZedanLab/UsernameGenerator
return [
    'source'        => null,
    'field'         => 'username',
    'route_binding' => true,
    'on_creating'   => true,
    'on_updating'   => false,
    'unique'        => true,
    'separator'     => '.',
    'lowercase'     => true,
    'regex'         => null,
    'convert_to_ascii' => true,
];
