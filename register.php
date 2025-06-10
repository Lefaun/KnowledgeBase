<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';

$auth = new Auth();
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $email = trim($_POST['email']);
    $full_name = trim($_POST['full_name']);
    
    // Validações básicas
    if (empty($username)) $errors[] = 'Usuário é obrigatório.';
    if (empty($password)) $errors[] = 'Senha é obrigatória.';
    if (empty($email)) $errors[] = 'Email é obrigatório.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Email inválido.';
    
    if (empty($errors)) {
        $result = $auth->register($username, $password, $email, $full_name);
        
        if ($result['success']) {
            // Login automático após registro
            if ($auth->login($username, $password)) {
                redirect('index.php');
            }
        } else {
            $errors[] = $result['message'];
        }
    }
}

require_once 'includes/header.php';
?>

<div class="form-container">
    <h2>Registrar</h2>
    
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $error): ?>
                <p><?php echo $error; ?></p>
            <?php endforeach; ?>
        </div>
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
        
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>
        
        <div class="form-group">
            <label for="full_name">Nome Completo</label>
            <input type="text" id="full_name" name="full_name">
        </div>
        
        <button type="submit" class="btn">Registrar</button>
    </form>
    
    <p style="margin-top: 1rem;">Já tem uma conta? <a href="login.php">Faça login</a></p>
</div>

<?php require_once 'includes/footer.php'; ?>