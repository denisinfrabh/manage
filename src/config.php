<?php
session_start();

define('DB_HOST', 'localhost');
define('DB_USER', 'root'); // Ajuste pro teu usuário do banco
define('DB_PASS', '');     // Ajuste pra tua senha do banco
define('DB_NAME', 'manage_files');

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar no banco: " . $e->getMessage());
}