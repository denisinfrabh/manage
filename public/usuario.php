<?php
require_once '../src/funcoes.php';
verificarLogin();

$documento = $_SESSION['documento'];
$pasta = "../clientes/$documento/";
$arquivos = listarArquivos($pasta);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Painel Usuário - Manage</title>
</head>
<body>
    <h1>Arquivos de <?php echo $_SESSION['nome']; ?></h1>
    <a href="logout.php">Sair</a>
    <ul>
    <?php foreach ($arquivos as $arquivo): ?>
        <li><a href="../clientes/<?php echo $documento; ?>/<?php echo $arquivo; ?>" target="_blank"><?php echo $arquivo; ?></a></li>
    <?php endforeach; ?>
    </ul>
</body>
</html>