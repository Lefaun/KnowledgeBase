<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';
require_once 'includes/posts.php';

if (!isLoggedIn()) {
    redirect('login.php');
}

$auth = new Auth();
$posts = new Posts();
$currentUser = $auth->getUserById($_SESSION['user_id']);
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = trim($_POST['content']);
    $image_path = null;
    
    if (empty($content)) {
        $error = 'O conteúdo da postagem é obrigatório.';
    } else {
        // Processar upload de imagem
        if (!empty($_FILES['image']['name'])) {
            $upload = uploadImage($_FILES['image']);
            
            if ($upload['success']) {
                $image_path = $upload['path'];
            } else {
                $error = $upload['message'];
            }
        }
        
        if (empty($error)) {
            if ($posts->createPost($currentUser['id'], $content, $image_path)) {
                redirect('index.php');
            } else {
                $error = 'Erro ao criar postagem.';
            }
        }
    }
}

require_once 'includes/header.php';
?>

<div class="form-container">
    <h2>Criar Nova Postagem</h2>
    
    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="content">Conteúdo</label>
            <textarea id="content" name="content" required></textarea>
        </div>
        
        <div class="form-group">
            <label for="image">Imagem (opcional)</label>
            <input type="file" id="image" name="image" accept="image/*">
        </div>
        
        <button type="submit" class="btn">Publicar</button>
    </form>
</div>

<?php require_once 'includes/footer.php'; ?>