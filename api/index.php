<?php
// api/index.php

$storageFolders = [
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/framework/cache',
    '/tmp/storage/logs',
];

foreach ($storageFolders as $folder) {
    if (!is_dir($folder)) {
        mkdir($folder, 0775, true);
    }
}

// Optionnel : Forcer le vidage du cache de config au démarrage si nécessaire
// putenv('APP_CONFIG_CACHE=/tmp/config.php');

require __DIR__ . '/../public/index.php';
