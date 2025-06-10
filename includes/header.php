<?php
require_once 'auth.php';
$auth = new Auth();
$currentUser = $auth->getUserById($_SESSION['user_id'] ?? 0);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1><a href="index.php"><?php echo SITE_NAME; ?></a></h1>
            <nav>
                <?php if (isLoggedIn()): ?>
                    <span>Olá, <?php echo htmlspecialchars($currentUser['username']); ?></span>
                    <a href="create_post.php">Nova Postagem</a>
                    <a href="profile.php">Meu Perfil</a>
                    <a href="logout.php">Sair</a>
                <?php else: ?>
                    <a href="login.php">Login</a>
                    <a href="register.php">Registrar</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>
    <main class="container">