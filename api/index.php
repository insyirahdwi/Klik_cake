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
    @chmod($sqliteTarget, 0666);
}

// Fallback environment variables if not set in Vercel Dashboard
if (empty($_ENV['DB_CONNECTION']) && empty(getenv('DB_CONNECTION')) && empty($_SERVER['DB_CONNECTION'])) {
    putenv('DB_CONNECTION=sqlite');
    $_ENV['DB_CONNECTION'] = 'sqlite';
    $_SERVER['DB_CONNECTION'] = 'sqlite';
    putenv('DB_DATABASE=/tmp/database.sqlite');
    $_ENV['DB_DATABASE'] = '/tmp/database.sqlite';
    $_SERVER['DB_DATABASE'] = '/tmp/database.sqlite';
}

if (empty($_ENV['APP_KEY']) && empty(getenv('APP_KEY')) && empty($_SERVER['APP_KEY'])) {
    $defaultKey = 'base64:cdYpHBLqIl/tfTM1laY+0y4Zn9TMoR5JuKu8NjdbEYQ=';
    putenv("APP_KEY={$defaultKey}");
    $_ENV['APP_KEY'] = $defaultKey;
    $_SERVER['APP_KEY'] = $defaultKey;
}

// Forward Vercel requests to Laravel's normal public/index.php
require __DIR__ . '/../public/index.php';