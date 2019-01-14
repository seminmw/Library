<?php

if (getenv('DBHOST')) {
    define('DB_TYPE', 'pgsql');
    define('DB_PORT', '5432');

    define('DB_HOST', getenv('DBHOST'));
    define('DB_USER', getenv('DBUSER'));
    define('DB_PASS', getenv('DBPASSWORD'));
    define('DB_NAME', getenv('DBNAME'));
}
else {
    require_once __DIR__ . '/' . 'config.local.php';
}