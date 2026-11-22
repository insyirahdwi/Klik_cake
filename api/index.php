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

// Fallback environment variables for Supabase if not explicitly set in Vercel Dashboard
if (empty($_ENV['DB_CONNECTION']) && empty(getenv('DB_CONNECTION')) && empty($_SERVER['DB_CONNECTION'])) {
    $dbConfig = [
        'DB_CONNECTION' => 'pgsql',
        'DB_HOST' => 'aws-0-ap-northeast-2.pooler.supabase.com',
        'DB_PORT' => '6543',
        'DB_DATABASE' => 'postgres',
        'DB_USERNAME' => 'postgres.cksissdvxozcamyzhopt',
        'DB_PASSWORD' => 'klikcake123@',
        'DB_SSLMODE' => 'require',
    ];
    foreach ($dbConfig as $k => $v) {
        putenv("{$k}={$v}");
        $_ENV[$k] = $v;
        $_SERVER[$k] = $v;
    }
}

if (empty($_ENV['APP_KEY']) && empty(getenv('APP_KEY')) && empty($_SERVER['APP_KEY'])) {
    $defaultKey = 'base64:cdYpHBLqIl/tfTM1laY+0y4Zn9TMoR5JuKu8NjdbEYQ=';
    putenv("APP_KEY={$defaultKey}");
    $_ENV['APP_KEY'] = $defaultKey;
    $_SERVER['APP_KEY'] = $defaultKey;
}

// Forward Vercel requests to Laravel's normal public/index.php
require __DIR__ . '/../public/index.php';