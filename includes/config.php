<?php
// Configurações do banco de dados
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'instasocial_kb');

// Configurações do site
define('SITE_NAME', 'InstaSocial Knowledge Base');
define('BASE_URL', 'http://localhost/instasocial_kb');
define('UPLOAD_DIR', __DIR__ . '/../uploads/');

// Inicia a sessão
session_start();

// Conexão com o banco de dados
function getDB() {
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8';
    try {
        $db = new PDO($dsn, DB_USER, DB_PASS);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    } catch (PDOException $e) {
        die('Connection failed: ' . $e->getMessage());
    }
}

// Função para redirecionamento
function redirect($url) {
    header("Location: $url");
    exit();
}

// Verifica se o usuário está logado
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Função para upload de imagens
function uploadImage($file) {
    $target_dir = UPLOAD_DIR;
    $target_file = $target_dir . basename($file['name']);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    // Verifica se é uma imagem real
    $check = getimagesize($file['tmp_name']);
    if($check === false) {
        return ['success' => false, 'message' => 'File is not an image.'];
    }
    
    // Verifica se o arquivo já existe
    if (file_exists($target_file)) {
        $target_file = $target_dir . uniqid() . '.' . $imageFileType;
    }
    
    // Verifica o tamanho do arquivo (5MB máximo)
    if ($file['size'] > 5000000) {
        return ['success' => false, 'message' => 'File is too large.'];
    }
    
    // Permite apenas certos formatos
    if(!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
        return ['success' => false, 'message' => 'Only JPG, JPEG, PNG & GIF files are allowed.'];
    }
    
    // Tenta fazer o upload
    if (move_uploaded_file($file['tmp_name'], $target_file)) {
        return ['success' => true, 'path' => 'uploads/' . basename($target_file)];
    } else {
        return ['success' => false, 'message' => 'Error uploading file.'];
    }
}
?>