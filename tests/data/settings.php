<?php

declare(strict_types=1);

$dotenv = Dotenv\Dotenv::createArrayBacked(ROOT, '.env.test');
$env = $dotenv->load();
return [
    'db_host' => $env['DB_HOST'],
    'db_port' => $env['DB_PORT'],
    'db_username' => $env['DB_USERNAME'],
    'db_password' => $env['DB_PASSWORD'],
    'db_name' => $env['DB_NAME'],
    'db_root_password' => $env['DB_ROOT_PASSWORD'],
];
