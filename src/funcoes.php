<?php
require_once 'config.php';

function verificarLogin() {
    if (!isset($_SESSION['usuario_id'])) {
        header('Location: public/login.php');
        exit;
    }
}

function ehAdmin() {
    return isset($_SESSION['nivel']) && $_SESSION['nivel'] === 'admin';
}

function listarArquivos($pasta) {
    $arquivos = is_dir($pasta) ? scandir($pasta) : [];
    return array_filter($arquivos, fn($item) => !in_array($item, ['.', '..']));
}

function validarDocumento($documento) {
    $tamanho = strlen($documento);
    return ($tamanho === 11 || $tamanho === 14) && ctype_digit($documento);
}