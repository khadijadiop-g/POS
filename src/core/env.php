<?php

return [
    'pgsql' => [
        'host'     => 'localhost',
        'port'     => '5432',
        'dbname'   => 'app_week',
        'user'     => 'khadija',
        'password' => 'Dakar026',
    ],
    'sqlite' => [
        'path' =>dirname(dirname(__DIR__)) . '/erp.db',
    ],
];