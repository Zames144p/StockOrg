-- Habilita extensão para UUID ou funções auxiliares caso necessário
CREATE EXTENSION IF NOT EXISTS "uuid-ossp";

-- 1. TABELA DE USUÁRIOS
CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(100),
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(150) NOT NULL UNIQUE,
    senha_hash VARCHAR(255) NOT NULL,
    foto VARCHAR(255) DEFAULT 'perfilDefault.jpg',
    cargo VARCHAR(20) DEFAULT 'Autor', -- 'SuperAdmin', 'admin', 'Autor'
    bio TEXT,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. TABELA DE POSTS
CREATE TABLE IF NOT EXISTS posts (
    id SERIAL PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    body TEXT NOT NULL,
    imagem VARCHAR(255),
    status BOOLEAN DEFAULT TRUE, -- TRUE: Publicado, FALSE: Rascunho
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    modificado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_posts_users FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);  

-- INSERIR USUÁRIO SUPERADMIN PADRÃO (Senha: 123456 hash bcrypt exemplo)
INSERT INTO users (nome, username, email, password, cargo) 
VALUES ('SuperAdmin', 'admin', 'admin@stockorg.com', '$2a$10$XZPDy...', 'SuperAdmin')
ON CONFLICT (username) DO NOTHING;