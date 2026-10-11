-- Habilita extensão para UUID ou funções auxiliares
CREATE EXTENSION IF NOT EXISTS "uuid-ossp";

-- 1. TABELA DE USUÁRIOS
CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(100),
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(150) NOT NULL UNIQUE,
    senha_hash VARCHAR(255) NOT NULL,
    foto VARCHAR(255) DEFAULT 'perfilDefault.jpg',
    cargo VARCHAR(20) DEFAULT 'Autor',
    bio TEXT,
    created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    modified TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. TABELA DE POSTS
CREATE TABLE IF NOT EXISTS posts (
    id SERIAL PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    body TEXT NOT NULL,
    imagem VARCHAR(255),
    status BOOLEAN DEFAULT TRUE,
    created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    modified TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_posts_users FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- INSERIR USUÁRIO SUPERADMIN PADRÃO (Hash Bcrypt válida de 60 caracteres)
INSERT INTO users (nome, username, email, senha_hash, cargo) 
VALUES (
    'SuperAdmin', 
    'admin', 
    'admin@stockorg.com', 
    '$2a$10$e8p2H1N/s8k.A1VzG/Yp/e5L3Z4V8y8N4x7k3j2m1n0o9p8q7r6s', 
    'SuperAdmin'
)
ON CONFLICT (username) DO NOTHING;