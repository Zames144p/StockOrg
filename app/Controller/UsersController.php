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
        if (!$this->isSuperAdmin($this->Auth->user('cargo'))) {
            throw new ForbiddenException('Somente o SuperAdmin pode promover administradores');
        }

        $this->User->id = $id;

        if (!$this->User->exists()) {
            throw new NotFoundException('Usuário não encontrado');
        }

        $targetUser = $this->User->findById($id);
        if ($targetUser['User']['cargo'] !== 'autor') {
            throw new ForbiddenException('Apenas usuários Autor podem ser promovidos');
        }

        //caso o user exista, quando essa action for chamada, ele vai mudar o cargo do usuario para admin.
        $this->User->saveField('cargo', 'admin');
        return $this->redirect(array('action' => 'painelAdemiro'));
    }

    public function removerAdemiro($id)
    {
        if (!$this->isSuperAdmin($this->Auth->user('cargo'))) {
            throw new ForbiddenException('Somente o SuperAdmin pode remover cargos administrativos');
        }

        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }

        $targetUser = $this->User->findById($id);
        if (empty($targetUser)) {
            throw new NotFoundException('Usuário não encontrado');
        }

        if ($targetUser['User']['cargo'] !== 'admin') {
            throw new ForbiddenException('Apenas usuários Admin podem ser rebaixados por esta ação');
        }

        $this->User->id = $id;
        $this->User->saveField('cargo', 'autor');

        return $this->redirect(array('action' => 'painelAdemiro'));
    }

    public function perfil($id = null)
    {
        // Se nenhum ID for passado na URL (/users/perfil), carrega o ID do usuário logado
        if (!$id) {
            $id = $this->Auth->user('id');
        }

        // Se não houver ID e o usuário não estiver logado, redireciona para o login
        if (!$id) {
            return $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }

        // Busca os dados do usuário solicitado no banco
        $user = $this->User->findById($id);

        if (empty($user)) {
            $this->Session->setFlash('Usuário não encontrado.');
            return $this->redirect(array('controller' => 'posts', 'action' => 'index'));
        }

        // Busca os Posts publicados deste usuário específico
        $posts = $this->User->Post->find('all', array(
            'conditions' => array(
                'Post.user_id' => $id,
                'Post.status'  => true
            ),
            'order' => array('Post.id' => 'DESC')
        ));

        // Busca os rascunhos apenas se o usuário estiver vendo o proprio perfil
        $rascunhos = array();
        if ($id == $this->Auth->user('id')) {
            $rascunhos = $this->User->Post->find('all', array(
                'conditions' => array(
                    'Post.user_id' => $id,
                    'Post.status'  => false
                ),
                'order' => array('Post.id' => 'DESC')
            ));
        }

        $this->set(compact('user', 'posts', 'rascunhos'));
    }

    public function painelAdemiro()
    {
        $this->layout = 'default';

        $user = $this->Auth->user();
        if (empty($user['cargo']) || !$this->hasAdminPrivileges($user['cargo'])) {
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
        if (!$this->hasAdminPrivileges($this->Auth->user('cargo'))) {
            throw new ForbiddenException('Acesso não autorizado');
        }

        if (!$this->request->is('post') &&  !$this->request->is('delete')) {
            throw new MethodNotAllowedException();
        }

        $this->User->id = $id;

        if (!$this->User->exists()) {
            throw new NotFoundException('Usuário não encontrado');
        }

        $targetUser = $this->User->findById($id);
        if (!$this->isSuperAdmin($this->Auth->user('cargo')) && $targetUser['User']['cargo'] !== 'autor') {
            throw new ForbiddenException('Somente o SuperAdmin pode excluir contas administrativas');
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
        // Identifica quem está logado na sessão
        $sessionUserId = $this->Auth->user('id');
        $sessionCargo  = $this->Auth->user('cargo');

        if (!$sessionUserId) {
            $this->Flash->error('Sessão expirada. Faça login novamente.');
            return $this->redirect(array('action' => 'login'));
        }

        // Define o ID do usuário que será carregado/editado
        // Se o Admin passar um $id via URL, edita esse $id; caso contrário, edita o próprio perfil
        if (!empty($id) && $this->hasAdminPrivileges($sessionCargo)) {
            $targetUserId = $id;
        } else {
            $targetUserId = $sessionUserId;
        }

        // Busca o usuário no banco de dados
        $targetUser = $this->User->findById($targetUserId);
        if (!$targetUser) {
            $this->Flash->error('Usuário não encontrado.');
            return $this->redirect(array('action' => 'perfil'));
        }

        if (
            $targetUserId != $sessionUserId
            && !$this->isSuperAdmin($sessionCargo)
            && $targetUser['User']['cargo'] !== 'autor'
        ) {
            throw new ForbiddenException('Somente o SuperAdmin pode editar contas administrativas');
        }

        // Se for submissão de formulário (POST ou PUT)
        if ($this->request->is(array('post', 'put'))) {

            // Assegura que o ID que está sendo atualizado é o $targetUserId
            $this->request->data['User']['id'] = $targetUserId;

            // Admin comum não pode alterar o próprio cargo por requisição manual.
            if (!$this->isSuperAdmin($sessionCargo)) {
                unset($this->request->data['User']['cargo']);
            }

            // Trata o upload da foto de perfil via Cloudinary
            if (!empty($this->request->data['User']['foto']['tmp_name'])) {
                $fileTmpPath = $this->request->data['User']['foto']['tmp_name'];
                $fileName    = $this->request->data['User']['foto']['name'];
                $fileType    = $this->request->data['User']['foto']['type'];

                $cloudName = strtolower(trim(getenv('CLOUDINARY_CLOUD_NAME') ?: ($_ENV['CLOUDINARY_CLOUD_NAME'] ?? '')));
                $apiKey    = trim(getenv('CLOUDINARY_API_KEY')    ?: ($_ENV['CLOUDINARY_API_KEY'] ?? ''));
                $apiSecret = trim(getenv('CLOUDINARY_API_SECRET') ?: ($_ENV['CLOUDINARY_API_SECRET'] ?? ''));

                if (empty($cloudName) || empty($apiKey) || empty($apiSecret)) {
                    CakeLog::write('error', '[Cloudinary] Credenciais de ambiente ausentes no perfil de usuario.');
                    // Mantém a foto que já existia no banco se as credenciais falharem
                    if (isset($user['User']['foto'])) {
                        $this->request->data['User']['foto'] = $user['User']['foto'];
                    } else {
                        unset($this->request->data['User']['foto']);
                    }
                } else {
                    $timestamp = time();
                    $signature = sha1('timestamp=' . $timestamp . $apiSecret);

                    $postFields = array(
                        'file'      => new CURLFile($fileTmpPath, $fileType, $fileName),
                        'api_key'   => $apiKey,
                        'timestamp' => $timestamp,
                        'signature' => $signature,
                        // Opcional: converte automaticamente para formatos otimizados (como WEBP) e limita a resolução máxima
                        'transformation' => 'c_limit,w_1920,h_1080/q_auto,f_auto'
                    );

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, 'https://api.cloudinary.com/v1_1/' . $cloudName . '/image/upload');
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 30);

                    $response = curl_exec($ch);
                    $curlError = curl_error($ch);
                    curl_close($ch);

                    if ($curlError) {
                        CakeLog::write('error', '[Cloudinary cURL Error no perfil]: ' . $curlError);
                        // Em caso de erro na conexão, preserva a foto antiga
                        if (isset($user['User']['foto'])) {
                            $this->request->data['User']['foto'] = $user['User']['foto'];
                        } else {
                            unset($this->request->data['User']['foto']);
                        }
                    } else {
                        $jsonResponse = json_decode($response, true);

                        if (!empty($jsonResponse['secure_url'])) {
                            // SUCESSO: Atualiza com a nova URL HTTPS do Cloudinary
                            $this->request->data['User']['foto'] = $jsonResponse['secure_url'];
                        } else {
                            CakeLog::write('error', '[Cloudinary API Error no perfil]: ' . $response);
                            if (isset($user['User']['foto'])) {
                                $this->request->data['User']['foto'] = $user['User']['foto'];
                            } else {
                                unset($this->request->data['User']['foto']);
                            }
                        }
                    }
                }
            } else {
                // Se o usuário não enviou um novo arquivo, remove a chave para que 
                // o CakePHP não limpe o valor no banco
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

        // Busca os posts do usuário editado para o Admin visualizar no final da página
        $this->loadModel('Post');
        $userPosts = $this->Post->find('all', array(
            'conditions' => array('Post.user_id' => $targetUserId),
            'order' => array('Post.criado_em' => 'DESC')
        ));

        // Envia as duas variáveis necessárias para a View
        $this->set('targetUser', $targetUser);
        $this->set('userPosts', $userPosts);
    }
}
