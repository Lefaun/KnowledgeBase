<?php
// Configurações automáticas para Render
$dbConfig = [
    'host' => getenv('DB_HOST') ?: 'localhost',
    'user' => getenv('DB_USER') ?: 'root',
    'pass' => getenv('DB_PASS') ?: '',
    'name' => getenv('DB_NAME') ?: 'instasocial_kb'
];

define('DB_HOST', $dbConfig['host']);
define('DB_USER', $dbConfig['user']);
define('DB_PASS', $dbConfig['pass']);
define('DB_NAME', $dbConfig['name']);
define('SITE_NAME', 'InstaSocial');
define('BASE_URL', getenv('BASE_URL') ?: 'http://localhost');
define('UPLOAD_DIR', __DIR__ . '/../uploads/');

// Cria diretório de uploads se não existir
if (!is_dir(UPLOAD_DIR)) {
    mkdir(UPLOAD_DIR, 0755, true);
}
