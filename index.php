<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';
require_once 'includes/posts.php';

$auth = new Auth();
$posts = new Posts();

$allPosts = $posts->getPosts();

require_once 'includes/header.php';
?>

<h2>Últimas Postagens</h2>

<div class="posts-container">
    <?php foreach ($allPosts as $post): ?>
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
            
            <div class="post-actions">
                <a href="view_post.php?id=<?php echo $post['id']; ?>">Ver Comentários</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php require_once 'includes/footer.php'; ?>