<?php
require_once 'config.php';

class Posts {
    private $db;
    
    public function __construct() {
        $this->db = getDB();
    }
    
    public function createPost($user_id, $content, $image_path = null) {
        $stmt = $this->db->prepare("INSERT INTO posts (user_id, content, image_path) VALUES (?, ?, ?)");
        return $stmt->execute([$user_id, $content, $image_path]);
    }
    
    public function getPosts($limit = 10, $offset = 0) {
        $stmt = $this->db->prepare("
            SELECT p.*, u.username, u.profile_pic 
            FROM posts p
            JOIN users u ON p.user_id = u.id
            ORDER BY p.created_at DESC
            LIMIT ? OFFSET ?
        ");
        $stmt->execute([$limit, $offset]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getPostById($post_id) {
        $stmt = $this->db->prepare("
            SELECT p.*, u.username, u.profile_pic 
            FROM posts p
            JOIN users u ON p.user_id = u.id
            WHERE p.id = ?
        ");
        $stmt->execute([$post_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function addComment($post_id, $user_id, $content) {
        $stmt = $this->db->prepare("INSERT INTO comments (post_id, user_id, content) VALUES (?, ?, ?)");
        return $stmt->execute([$post_id, $user_id, $content]);
    }
    
    public function getComments($post_id) {
        $stmt = $this->db->prepare("
            SELECT c.*, u.username, u.profile_pic 
            FROM comments c
            JOIN users u ON c.user_id = u.id
            WHERE c.post_id = ?
            ORDER BY c.created_at ASC
        ");
        $stmt->execute([$post_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>