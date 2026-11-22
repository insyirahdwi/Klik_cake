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

// Copy pre-seeded SQLite database to writable /tmp if using sqlite
$sqliteTarget = '/tmp/database.sqlite';
$sqliteSource = __DIR__ . '/../database/database.sqlite';
if (!file_exists($sqliteTarget) && file_exists($sqliteSource)) {
    copy($sqliteSource, $sqliteTarget);
}

// Forward Vercel requests to Laravel's normal public/index.php
require __DIR__ . '/../public/index.php';