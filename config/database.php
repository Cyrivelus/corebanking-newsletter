<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    | En local (.env) : sqlite
    | Sur Vercel (Variables d'env) : pgsql
    */

    'default' => env('DB_CONNECTION', 'sqlite'),

    'connections' => [

        'sqlite' => [
            'driver' => 'sqlite',
            'url' => env('DB_URL'),
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ],

       'pgsql' => [
    'driver' => 'pgsql',
    'host' => 'aws-0-eu-central-1.pooler.supabase.com',
    'port' => '6543',
    'database' => 'newsletter_prod',
    'username' => 'postgres.hwllvkdvhfrkajgxwdeo', // <--- AJOUTE LE POINT ET L'ID ICI
    'password' => 'fireFlame237KLMNOPQSDFG',
    'charset' => 'utf8',
    'prefix' => '',
    'search_path' => 'public',
    'sslmode' => 'require',
],

    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    */

    'migrations' => [
        'table' => 'migrations',
        'update_date_on_publish' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Redis Databases (Optionnel pour NewsPro)
    |--------------------------------------------------------------------------
    */

    'redis' => [
        'client' => env('REDIS_CLIENT', 'phpredis'),
        'options' => [
            'cluster' => env('REDIS_CLUSTER', 'redis'),
            'prefix' => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_').'_database_'),
        ],
        'default' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_DB', '0'),
        ],
    ],
];
