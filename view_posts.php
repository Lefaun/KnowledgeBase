<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';
require_once 'includes/posts.php';

if (!isset($_GET['id'])) {
    redirect('index.php');
}

$auth = new Auth();
$posts = new Posts();
$post_id = intval($_GET['id']);
$post = $posts->getPostById($post_id);
$comments = $posts->getComments($post_id);
$error = '';

if (!$post) {
    redirect('index.php');
}

// Adicionar comentário
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isLoggedIn()) {
    $content = trim($_POST['content']);
    
    if (empty($content)) {
        $error = 'O comentário não pode estar vazio.';
    } else {
        if ($posts->addComment($post_id, $_SESSION['user_id'], $content)) {
            // Recarrega a página para mostrar o novo comentário
            redirect("view_post.php?id=$post_id");
        } else {
            $error = 'Erro ao adicionar comentário.';
        }
    }
}

require_once 'includes/header.php';
?>

<div class="post-detail">
    <div class="post">
        <div class="post-header">
            <img src="<?php echo htmlspecialchars($post['profile_pic']); ?>" alt="Avatar" class="post-user-avatar">
            <span><?php echo htmlspecialchars($post['username']); ?></span>
        </div>
        
        <?php if ($post['image_path']): ?>
            <img src="<?php echo htmlspecialchars($post['image_path']); ?>" alt="Post image" class="post-image">
        <?php endif; ?>
        
        <div class="post-content">
            <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
            <small><?php echo date('d/m/Y H:i', strtotime($post['created_at'])); ?></small>
        </div>
    </div>
    
    <div class="post-comments">
        <h3>Comentários</h3>
        
        <?php if (!empty($comments)): ?>
            <?php foreach ($comments as $comment): ?>
                <div class="comment">
                    <img src="<?php echo htmlspecialchars($comment['profile_pic']); ?>" alt="Avatar" class="comment-avatar">
                    <div>
                        <strong><?php echo htmlspecialchars($comment['username']); ?></strong>
                        <p><?php echo htmlspecialchars($comment['content']); ?></p>
                        <small><?php echo date('d/m/Y H:i', strtotime($comment['created_at'])); ?></small>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Nenhum comentário ainda. Seja o primeiro a comentar!</p>
        <?php endif; ?>
        
        <?php if (isLoggedIn()): ?>
            <form method="POST" class="add-comment">
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <div class="form-group">
                    <textarea name="content" placeholder="Adicione um comentário..." required></textarea>
                </div>
                <button type="submit" class="btn">Comentar</button>
            </form>
        <?php else: ?>
            <p><a href="login.php">Faça login</a> para comentar.</p>
        <?php endif; ?>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>