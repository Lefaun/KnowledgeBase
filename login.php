<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';

$auth = new Auth();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    if ($auth->login($username, $password)) {
        redirect('index.php');
    } else {
        $error = 'Usuário ou senha incorretos.';
    }
}

require_once 'includes/header.php';
?>

<div class="form-container">
    <h2>Login</h2>
    
    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <form method="POST">
        <div class="form-group">
            <label for="username">Usuário</label>
            <input type="text" id="username" name="username" required>
        </div>
        
        <div class="form-group">
            <label for="password">Senha</label>
            <input type="password" id="password" name="password" required>
        </div>
        
        <button type="submit" class="btn">Entrar</button>
    </form>
    
    <p style="margin-top: 1rem;">Não tem uma conta? <a href="register.php">Registre-se</a></p>
</div>

<?php require_once 'includes/footer.php'; ?>