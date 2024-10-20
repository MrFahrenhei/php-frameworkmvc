<?php

require_once __DIR__. '/vendor/autoload.php';

use App\Core\Application;

(Dotenv\Dotenv::createImmutable(__DIR__))->load();

$config = [
    'db' => [
        'dsn' => $_ENV['DB_DSN'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD'],
    ]
];
$app = new Application(__DIR__, $config);
$app->db->applyMigrations();