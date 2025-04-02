<?php
require_once 'src/funcoes.php';

if (isset($_SESSION['usuario_id'])) {
    header('Location: public/' . (ehAdmin() ? 'admin.php' : 'usuario.php'));
} else {
    header('Location: public/login.php');
}
exit;