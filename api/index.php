<?php

/**
 * Point d'entrée pour Vercel Serverless Functions
 */

// 1. Définir les dossiers de stockage dans /tmp (seul endroit accessible en écriture sur Vercel)
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

// 2. Charger l'application Laravel
require __DIR__ . '/../public/index.php';
