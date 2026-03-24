<?php

return [
    'default' => env('DB_CONNECTION', 'pgsql'),

    'connections' => [
        'pgsql' => [
            'driver' => 'pgsql',
            // Sur Vercel, l'URL complète contient le tenant-id dans le login.
            // C'est la méthode la plus fiable.
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', 'aws-0-eu-central-1.pooler.supabase.com'),
            'port' => env('DB_PORT', '6543'),
            'database' => env('DB_DATABASE', 'postgres'),
            'username' => env('DB_USERNAME', 'postgres.hwllvkdvhfrkajgxwdeo'),
            'password' => env('DB_PASSWORD', 'fireFlame237KLMNOPQSDFG'),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => 'public',
            'sslmode' => 'require',
            'options' => [
                // Désactivation du cache de connexion pour le Serverless
                PDO::ATTR_PERSISTENT => false,
            ],
        ],
    ],

    'migrations' => [
        'table' => 'migrations',
        'update_date_on_publish' => true,
    ],
];
