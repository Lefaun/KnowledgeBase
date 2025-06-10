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
$userPosts = $posts->getPosts(10, 0, $currentUser['id']);

require_once 'includes/header.php';
?>

<div class="profile-container">
    <div class="profile-header">
        <img src="<?php echo htmlspecialchars($currentUser['profile_pic']); ?>" alt="Profile" class="profile-avatar">
        <div>
            <h2><?php echo htmlspecialchars($currentUser['username']); ?></h2>
            <p><?php echo htmlspecialchars($currentUser['full_name']); ?></p>
            <p><?php echo htmlspecialchars($currentUser['email']); ?></p>
        </div>
    </div>
    
    <h3>Minhas Postagens</h3>
    
    <div class="posts-container">
        <?php if (!empty($userPosts)): ?>
            <?php foreach ($userPosts as $post): ?>
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
        <?php else: ?>
            <p>Você ainda não fez nenhuma postagem.</p>
        <?php endif; ?>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>