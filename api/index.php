<?php
// api/index.php

// 1. Créer les dossiers de stockage dans /tmp (nécessaire pour Vercel)
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

// 2. Lancer l'application normalement
require __DIR__ . '/../public/index.php';
