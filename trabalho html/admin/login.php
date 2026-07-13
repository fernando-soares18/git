<?php

declare(strict_types=1);

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';

if (is_admin_logged_in()) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $token = $_POST['csrf_token'] ?? '';

    if (!validate_csrf($token)) {
        $error = 'Token de seguranca invalido. Recarregue a pagina e tente novamente.';
    } else {
        $stmt = $pdo->prepare('SELECT id, nome, email, senha_hash FROM admins WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => $email]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($password, $admin['senha_hash'])) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_name'] = $admin['nome'];
            header('Location: dashboard.php');
            exit;
        }

        $error = 'Email ou senha invalidos.';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login do Painel de Artigos</title>
<link rel="stylesheet" href="../../style.css">
</head>
<body class="admin-page">
<main class="admin-shell">
    <section class="admin-card">
        <h1>Painel de Artigos</h1>
        <p>Entre com seu usuario para publicar novos artigos no site.</p>

        <?php if ($error !== ''): ?>
            <div class="admin-alert admin-alert-error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>

        <form method="post" class="admin-form">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') ?>">

            <label for="email">Email</label>
            <input id="email" name="email" type="email" required>

            <label for="password">Senha</label>
            <input id="password" name="password" type="password" required>

            <button type="submit">Entrar no painel</button>
        </form>

        <a href="../index.php" class="admin-back-link">Voltar para o site</a>
    </section>
</main>
</body>
</html>
