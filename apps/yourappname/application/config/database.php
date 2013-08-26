<?php

return array(

    'profile' => false,

    'fetch' => PDO::FETCH_CLASS,

    'default' => 'pgsql',

    'connections' => array(

        'pgsql' => array(
            'driver'   => 'pgsql',
            'host'     => '192.168.1.10',
            'database' => 'appssolut',
            'username' => 'postgres',
            'password' => 'postgres',
            'charset'  => 'utf8',
            'prefix'   => '',
            'schema'   => 'yourappname',
        ),

        'sdk' => array(
            'driver'   => 'pgsql',
            'host'     => '192.168.1.10',
            'database' => 'appssolut',
            'username' => 'postgres',
            'password' => 'postgres',
            'charset'  => 'utf8',
            'prefix'   => '',
            'schema'   => 'public',
        ),
    ),
);