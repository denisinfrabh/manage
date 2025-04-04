<?php
$senha = 'casa@2020';
$hash = password_hash($senha, PASSWORD_DEFAULT);
echo "Hash pra 'casa@2020': " . $hash;