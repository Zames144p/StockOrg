# StockOrg

O projeto foi criado usando PHP, CakePHP, Docker e PostegreSQL. 

Blog responsivo voltado para o cenario de finanças no Brasil. Projeto criado para estudar o padrao MVC no desenvolvimento web e colocar em pratica o desenvolvimento em backend.

O StockOrg é originalmente um projeto apenas para estudos, porém, caso deseje escalonar para ter a experiencia completa, é possivel.

## Features

### 🔐 Autenticação e Cargos
- Sistema de login com 3 cargos possiveis:
  - **Super Admin**
  - **Admin**
  - **Autor**
- O cargo de Autor é padrão para novos registros e o Super Admin junto Admin são cargos manuais no banco.

### 🏠 Dashboard (Home Page)
- Tela de exibição principal (guest):
  - Todos os posts
  - possibilidade de login
- Tela de exibiçao principal (Autor):
  - Side bar com sessões para usuario
  - Perfil
  - Editar Perfil
  - Sobre nós
  - Sair da sessão
  - Postar
- Tela de exibição principal (Super admin e admin):
  - Painel de controle com todos os usuarios e funcionalidades

### 👥 Gestão de membros
- Criar novos usuarios
- Editar usuarios ja existentes
- Visualizar as informações do usuario
- visualizar as datas de criações e modificações, tanto posts como usuarios
- Deletar posts e usuarios

### 💬 Posts
- Criar uma nova postagem
- Editar uma postagem ja existente
- Vizualizar suas proprias postagens e de outros usuarios
- Criar rascunhos de posts
- Anexiar imagens nos posts
- Deletar posts

## Stacks

### 🔧 Backend
- **PHP**
- **CakePHP**
- **ImgBB**

### 🗄 Database
- **Dbeaver**
- PostegreSQL
- Suport para arquivos .sql para setup

### 🎨 Frontend
- **Bootstrap 5.3**
- **jQuery**
- **Bootstrap Icons**
- CSS customizada para aprimoramento UI/UX

### ⚙️ Development Tools
- Visual Studio 2026
- Git & GitHub

## Instalação (Linux)

- Instale o php para conseguir usar o composer do projeto:
```bash
sudo apt install php
sudo apt install php-cli libapache2-mod-php
```

- Instale o Docker para subir o dockerfile
```bash
sudo apt install ca-certificates curl gnupg -y
sudo install -m 0755 -d /etc/apt/keyrings && curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo gpg --dearmor -o /etc/apt/keyrings/docker.gpg && sudo chmod a+r /etc/apt/keyrings/docker.gpg
echo "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.gpg] https://download.docker.com/linux/ubuntu $(lsb_release -cs) stable" | sudo tee /etc/apt/sources.list.d/docker.list > /dev/null
sudo apt update && sudo apt install docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin -y
sudo docker run hello-world
```

- Instale o composer 
```bash
sudo apt update
sudo apt install docker-compose-plugin -y
```
- Agora basta escrever "docker-compose up -d" no diretorio do projeto (configure o banco de dados default antes)

## Entre em contato

Perguntas, feedbacks ou ate comparação de codigo entre em contato por: sfranzcarlo@gmail.com 

**Criado por ZamesINC**