<?php

App::uses('AppController', 'Controller');

class UsersController extends AppController
{
    public $helpers = array('Html', 'Form');

    public function beforeFilter()
    {
        parent::beforeFilter();
        // Configurações do AuthComponent
        $this->Auth->allow('login', 'cadastro'); // Permite acesso às ações de login e cadastro sem autenticação.
        $this->set('currentUser', $this->Auth->user());
    }

    public function cadastro()
    {
        if ($this->request->is('post')) {
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->User->saveField('cargo', 'autor');
                $this->Flash->success('Cadastro realizado com sucesso!');
                return $this->redirect(array('action' => 'login'));
            }
            $this->Flash->error('Não foi possível realizar o cadastro. Por favor, tente novamente.');
        }
    }

    public function login()
    {
        //primeiro eu verifico a requisiçao, se for get é pq o usuario ta acessando pela primeira vez.
        if ($this->request->is('get')) {
            return; //manda pra login normalmente
        }
        //Se for post, ele ta preenchendo o formularios e entao verifico se o usuario ja existe
        if ($this->request->is('post')) {
            if ($this->Auth->login()) { //esse metodo do cake verifica tanto o usuario quanto a senha, retornando true se tiver certo.
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error('Usuário ou senha inválidos, tente novamente.');
        }
    }

    public function sairDaConta()
    {
        return $this->redirect($this->Auth->logout());
    }

    //action pra dar o poder de admin (lembrar de chamar isso apenas no painel de usuarios)
    public function poderAdemiro($id)
    {
        $this->User->id = $id;

        if (!$this->user->exists()) {
            throw new NotFoundException('Usuário não encontrado');
        }
        //caso o user exista, quando essa action for chamada, ele vai mudar o cargo do usuario para admin.
        $this->User->saveField('cargo', 'admin');
        return $this->redirect(array('action' => 'index'));
    }

    public function perfil()
    {
        $this->layout = 'dashboard';
        $userId = $this->Auth->user('id');
        if (!$userId) {
            return $this->redirect(array('action' => 'login'));
        }

        $user = $this->User->findById($userId);
        if (empty($user)) {
            throw new NotFoundException('Usuário não encontrado');
        }

        $this->set('currentUser', $user['User']);
        $this->set('user', $user['User']);
    }

    public function painelAdemiro()
    {
        $this->layout = 'dashboard';

        $user = $this->Auth->user();
        if (empty($user['cargo']) || $user['cargo'] !== 'admin') {
            return $this->redirect(array('controller' => 'posts', 'action' => 'index'));
        }
        $this->set('currentUser', $user);

        $usuarios = $this->User->find('all', array(
            'order' => array('User.id' => 'ASC')
        ));

        $this->set(compact('usuarios', 'user'));
    }

    public function delete($id = null)
    {
        if (!$this->request->is('post') &&  !$this->request->is('delete')) {
            throw new MethodNotAllowedException();
        }

        $this->User->id = $id;

        if (!$this->User->exists()) {
            throw new NotFoundException('Usuário não encontrado');
        }

        if ($this->User->delete()) {
            $this->Flash->success('Usuário excluído com sucesso.');
        } else {
            $this->Flash->error('Não foi possível excluir o usuário.');
        }

        return $this->redirect(array('action' => 'painelAdemiro'));
    }

    public function edit($id = null)
    {
    // 1. Identifica quem está logado na sessão
    $sessionUserId = $this->Auth->user('id');
    $sessionCargo  = $this->Auth->user('cargo');

    if (!$sessionUserId) {
        $this->Flash->error('Sessão expirada. Faça login novamente.');
        return $this->redirect(array('action' => 'login'));
    }

    // 2. Define o ID do usuário que será carregado/editado
    // Se o Admin passar um $id via URL, edita esse $id; caso contrário, edita o próprio perfil
    if (!empty($id) && $sessionCargo === 'admin') {
        $targetUserId = $id;
    } else {
        $targetUserId = $sessionUserId;
    }

    // 3. Busca o usuário no banco de dados
    $targetUser = $this->User->findById($targetUserId);
    if (!$targetUser) {
        $this->Flash->error('Usuário não encontrado.');
        return $this->redirect(array('action' => 'perfil'));
    }

    // 4. Se for submissão de formulário (POST ou PUT)
    if ($this->request->is(array('post', 'put'))) {
        
        // Assegura que o ID que está sendo atualizado é o $targetUserId
        $this->request->data['User']['id'] = $targetUserId;

        // Trata o upload da foto de perfil
        if (!empty($this->request->data['User']['foto']['name'])) {
            $file = $this->request->data['User']['foto'];
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $allowed = array('jpg', 'jpeg', 'png', 'webp');

            if (in_array($ext, $allowed)) {
                $filename = 'user_' . $targetUserId . '_' . time() . '.' . $ext;
                $targetPath = WWW_ROOT . 'img' . DS . $filename;

                if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                    $this->request->data['User']['foto'] = $filename;
                } else {
                    unset($this->request->data['User']['foto']);
                }
            } else {
                unset($this->request->data['User']['foto']);
            }
        } else {
            unset($this->request->data['User']['foto']);
        }

        // Salva as alterações
        if ($this->User->save($this->request->data)) {
            // Atualiza a sessão se o usuário alterou o próprio perfil
            if ($targetUserId == $sessionUserId) {
                $updatedUser = $this->User->findById($sessionUserId);
                $this->Auth->login($updatedUser['User']);
            }

            $this->Flash->success('Perfil atualizado com sucesso!');
            
            if ($targetUserId != $sessionUserId) {
                return $this->redirect(array('action' => 'painelAdemiro'));
            }
            return $this->redirect(array('action' => 'perfil'));
        } else {
            $this->Flash->error('Erro ao salvar as alterações.');
        }
    } else {
        // Carregamento inicial (GET): Preenche o formulário com os dados do $targetUser
        $this->request->data = $targetUser;
        unset($this->request->data['User']['senha_hash']);
    }

    // 5. Busca os posts do usuário editado para o Admin visualizar no final da página
    $this->loadModel('Post');
    $userPosts = $this->Post->find('all', array(
        'conditions' => array('Post.user_id' => $targetUserId),
        'order' => array('Post.created' => 'DESC')
    ));

    // Envia as duas variáveis necessárias para a View
    $this->set('targetUser', $targetUser);
    $this->set('userPosts', $userPosts);
}
}