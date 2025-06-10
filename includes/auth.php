<?php
require_once 'config.php';

class Auth {
    private $db;
    
    public function __construct() {
        $this->db = getDB();
    }
    
    public function register($username, $password, $email, $full_name) {
        // Verifica se o usuário já existe
        $stmt = $this->db->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        
        if ($stmt->rowCount() > 0) {
            return ['success' => false, 'message' => 'Username or email already exists.'];
        }
        
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->db->prepare("INSERT INTO users (username, password, email, full_name) VALUES (?, ?, ?, ?)");
        
        if ($stmt->execute([$username, $hashedPassword, $email, $full_name])) {
            return ['success' => true];
        }
        
        return ['success' => false, 'message' => 'Registration failed.'];
    }

require_once __DIR__ . '/config.php'; // Adicione esta linha no topo

class Auth {
    private $db;
    
    public function __construct() {
        $this->db = getDB(); // Agora a função está disponível
    }
    

    public function login($username, $password) {
        $stmt = $this->db->prepare("SELECT id, username, password FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            return true;
        }
        return false;
    }
    
    public function getUserById($id) {
        $stmt = $this->db->prepare("SELECT id, username, email, full_name, profile_pic FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
