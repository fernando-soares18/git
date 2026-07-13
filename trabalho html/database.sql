CREATE DATABASE IF NOT EXISTS site_medico CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE site_medico;

CREATE TABLE IF NOT EXISTS admins (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(120) NOT NULL,
    email VARCHAR(190) NOT NULL UNIQUE,
    senha_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS artigos (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(220) NOT NULL,
    categoria VARCHAR(120) NOT NULL,
    data_publicacao DATE NOT NULL,
    imagem_capa VARCHAR(255) NOT NULL,
    conteudo TEXT NOT NULL,
    admin_id INT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_artigos_admin FOREIGN KEY (admin_id) REFERENCES admins(id)
);

-- Troque a senha em PLAIN_TEXT_PASSWORD e gere o hash com password_hash no PHP.
-- Exemplo rapido no terminal:
-- php -r "echo password_hash('SUA_SENHA_FORTE', PASSWORD_DEFAULT), PHP_EOL;"
INSERT INTO admins (nome, email, senha_hash)
VALUES ('Administrador', 'admin@site.com', 'COLE_AQUI_O_HASH_DA_SENHA')
ON DUPLICATE KEY UPDATE nome = VALUES(nome);
