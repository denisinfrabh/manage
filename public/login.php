<?php
require_once '../src/funcoes.php';

if (isset($_SESSION['usuario_id'])) {
    header('Location: ' . (ehAdmin() ? 'admin.php' : 'usuario.php'));
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'] ?? '';
    $senha = $_POST['senha'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = ?");
    $stmt->execute([$usuario]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Debug
    if (!$user) {
        $erro = "Usuário '$usuario' não encontrado!";
    } elseif (!password_verify($senha, $user['senha'])) {
        $erro = "Senha incorreta pra '$usuario'!";
    } else {
        $_SESSION['usuario_id'] = $user['id'];
        $_SESSION['nivel'] = $user['nivel'];
        $_SESSION['nome'] = $user['nome'];
        $_SESSION['documento'] = $user['documento'];
        header('Location: ' . ($user['nivel'] === 'admin' ? 'admin.php' : 'usuario.php'));
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login - Manage</title>
</head>
<body>
    <h1>Login</h1>
    <?php if (isset($erro)) echo "<p style='color: red;'>$erro</p>"; ?>
    <form method="post">
        Usuário: <input type="text" name="usuario" required><br>
        Senha: <input type="password" name="senha" required><br>
        <input type="submit" value="Entrar">
    </form>
</body>
</html>