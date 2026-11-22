<?php

// Prepare writable /tmp directories for serverless environment
$storagePath = '/tmp/storage';
$subdirs = [
    '/app',
    '/app/public',
    '/framework',
    '/framework/cache',
    '/framework/cache/data',
    '/framework/sessions',
    '/framework/testing',
    '/framework/views',
    '/logs',
];

foreach ($subdirs as $dir) {
    $fullPath = $storagePath . $dir;
    if (!is_dir($fullPath)) {
        mkdir($fullPath, 0755, true);
    }
}

// Forward Vercel requests to Laravel's normal public/index.php
require __DIR__ . '/../public/index.php';