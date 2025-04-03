<?php
require_once '../src/funcoes.php';
verificarLogin();
if (!ehAdmin()) {
    header('Location: usuario.php');
    exit;
}
if (isset($_POST['cadastrar_usuario'])) {
    $novo_usuario = $_POST['usuario'];
    $novo_senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $novo_nome = $_POST['nome'];
    $novo_documento = $_POST['documento'];
    
    $stmt = $pdo->prepare("INSERT INTO usuarios (usuario, senha, nivel, nome, documento) VALUES (?, ?, 'usuario', ?, ?)");
    if ($stmt->execute([$novo_usuario, $novo_senha, $novo_nome, $novo_documento])) {
        $msg = "Usuário '$novo_usuario' cadastrado com sucesso!";
    } else {
        $msg = "Erro ao cadastrar usuário!";
    }
}

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['arquivo'])) { // Upload
        $documento = $_POST['documento'];
        $stmt = $pdo->prepare("SELECT nome FROM usuarios WHERE documento = ? AND nivel = 'usuario'");
        $stmt->execute([$documento]);
        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($cliente) {
            $pasta = "../clientes/$documento/";
            if (!is_dir($pasta)) mkdir($pasta, 0777, true);
            $arquivo = $_FILES['arquivo'];
            $nome_original = basename($arquivo['name']);
            $destino = $pasta . $nome_original;
            $contador = 1;
            while (file_exists($destino)) {
                $extensao = pathinfo($nome_original, PATHINFO_EXTENSION);
                $nome_sem_ext = pathinfo($nome_original, PATHINFO_FILENAME);
                $destino = $pasta . $nome_sem_ext . "_$contador." . $extensao;
                $contador++;
            }
            if (move_uploaded_file($arquivo['tmp_name'], $destino)) {
                $msg = "Arquivo enviado com sucesso!";
            } else {
                $msg = "Erro ao enviar arquivo!";
            }
        } else {
            $msg = "Documento '$documento' não encontrado!";
        }
    } elseif (isset($_POST['apagar'])) { // Apagar
        $documento = $_POST['documento'];
        $arquivo = $_POST['arquivo'];
        $caminho = "../clientes/$documento/$arquivo";
        if (file_exists($caminho) && unlink($caminho)) {
            $msg = "Arquivo apagado com sucesso!";
        } else {
            $msg = "Erro ao apagar arquivo!";
        }
    }
}

// Substituir essa linha:
// $clientes = listarArquivos('../clientes/');

// Por isso:
$stmt = $pdo->prepare("SELECT documento FROM usuarios WHERE nivel = 'usuario'");
$stmt->execute();
$clientes = $stmt->fetchAll(PDO::FETCH_COLUMN); // Pega só os documentos
$stmt = $pdo->prepare("SELECT documento, nome FROM usuarios WHERE nivel = 'usuario'");
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
$clientes_nomes = array_column($usuarios, 'nome', 'documento');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Painel Admin - Manage</title>
</head>
<body>
    <h1>Painel do Admin</h1>
    <a href="logout.php">Sair</a>
    <?php if ($msg) echo "<p>$msg</p>"; ?>

    <h2>Enviar Arquivo</h2>
    <form method="post" enctype="multipart/form-data">
        Documento (CPF/CNPJ): <input type="text" name="documento" required placeholder="ex: 12345678901"><br>
        Arquivo: <input type="file" name="arquivo" required><br>
        <input type="submit" value="Enviar">
    </form>

    <h2>Gerenciar Arquivos</h2>
    <?php foreach ($clientes as $cliente): ?>
        <h3>Cliente: <?php echo $cliente . ' - ' . ($clientes_nomes[$cliente] ?? 'Desconhecido'); ?></h3>
        <ul>
        <?php
        $arquivos = listarArquivos("../clientes/$cliente");
        foreach ($arquivos as $arquivo): ?>
            <li>
                <a href="../clientes/<?php echo $cliente; ?>/<?php echo $arquivo; ?>" target="_blank"><?php echo $arquivo; ?></a>
                <form method="post" style="display:inline;">
                    <input type="hidden" name="documento" value="<?php echo $cliente; ?>">
                    <input type="hidden" name="arquivo" value="<?php echo $arquivo; ?>">
                    <input type="submit" name="apagar" value="Apagar">
                </form>
            </li>
        <?php endforeach; ?>
        </ul>
    <?php endforeach; ?>
<h2>Cadastrar Novo Usuário</h2>
<form method="post">
    Usuário: <input type="text" name="usuario" required><br>
    Senha: <input type="password" name="senha" required><br>
    Nome: <input type="text" name="nome" required><br>
    Documento (CPF/CNPJ): <input type="text" name="documento" required><br>
    <input type="submit" name="cadastrar_usuario" value="Cadastrar">
</form>

</body>
</html>