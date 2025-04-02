CREATE DATABASE manage_files;
USE manage_files;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL UNIQUE, -- Nome de login (ex.: "joao", "admin")
    senha VARCHAR(255) NOT NULL,         -- Hash da senha
    nivel ENUM('admin', 'usuario') NOT NULL, -- Nível de acesso
    nome VARCHAR(100) NOT NULL,          -- Nome real do cliente (ex.: "João Silva")
    documento VARCHAR(14) NOT NULL UNIQUE -- CPF (11 dígitos) ou CNPJ (14 dígitos)
);

-- Admin inicial (sem pasta específica)
INSERT INTO usuarios (usuario, senha, nivel, nome, documento) 
VALUES ('admin', '$2y$10$exemplo_hash_aqui', 'admin', 'Administrador', '');

-- Usuário com CPF
INSERT INTO usuarios (usuario, senha, nivel, nome, documento) 
VALUES ('joao', '$2y$10$exemplo_hash_aqui', 'usuario', 'João Silva', '12345678901');

-- Usuário com CNPJ
INSERT INTO usuarios (usuario, senha, nivel, nome, documento) 
VALUES ('maria', '$2y$10$exemplo_hash_aqui', 'usuario', 'Maria Ltda', '12345678000190');