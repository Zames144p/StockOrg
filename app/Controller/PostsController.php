<?php

class PostsController extends AppController
{
    public $helpers = array('Html', 'Form');

    public function beforeFilter()
    {
        parent::beforeFilter();
        // Permite acessar a home page e ler posts sem estar logado
        $this->Auth->allow('index', 'view');
        $this->set('isAuthenticated', (bool) $this->Auth->user());
        $this->set('currentUser', $this->Auth->user());
    }

    public function index()
    {
        // Se o formulário foi enviado via POST, atualiza os dados na Sessão
        if ($this->request->is('post')) {
            $dataPost = $this->request->data;

            $getFilter = function ($name) use ($dataPost) {
                return isset($dataPost[$name]) //verifica se o campo foi usado
                    ? $dataPost[$name]
                    : (isset($dataPost['Post'][$name]) ? $dataPost['Post'][$name] : '');
            };

            $busca = $getFilter('busca');
            $dataInicio = $getFilter('data_inicio');
            $dataFim = $getFilter('data_fim');

            $this->Session->write('Filter.busca', $busca);
            $this->Session->write('Filter.data_inicio', $dataInicio);
            $this->Session->write('Filter.data_fim', $dataFim);
        }

        // Lê os filtros salvos na Sessão (ou define vazio se não existir)
        $busca      = $this->Session->read('Filter.busca') ?: '';
        $dataInicio = $this->Session->read('Filter.data_inicio') ?: '';
        $dataFim    = $this->Session->read('Filter.data_fim') ?: '';

        // Função de normalização de data
        $normalizeDate = function ($input) {
            if (!is_string($input) || trim($input) === '') return '';
            $input = trim($input);
            foreach (array('d/m/Y', 'Y-m-d') as $format) {
                $date = DateTime::createFromFormat($format, $input); //interpreta o valor digitado como data
                $errors = DateTime::getLastErrors();
                if ($date && ($errors === false || ($errors['warning_count'] === 0 && $errors['error_count'] === 0))) {
                    return $date->format('Y-m-d'); //conversao para data padrao de busca
                }
            }
            return '';
        };

        $dataInicioSql = $normalizeDate($dataInicio);
        $dataFimSql    = $normalizeDate($dataFim);

        // Monta as condições da Query

        //Filtro pra perfil
        $usuariosEncontrados = array();
        if (!empty($busca)) {
            $this->loadModel('User');
            $usuariosEncontrados = $this->User->find('all', array(
                'conditions' => array(
                    'OR' => array(
                        'User.nome ILIKE'     => '%' . trim($busca) . '%',
                        'User.username ILIKE' => '%' . trim($busca) . '%',
                        'User.email ILIKE'    => '%' . trim($busca) . '%'
                    )
                ),
                'limit' => 10
            ));
        }

        // Parte pra posts
        $conditions = array('Post.status' => true);
        if (!empty($busca)) {
            $conditions['OR'] = array(
                'Post.title ILIKE' => '%' . trim($busca) . '%',
                'Post.body ILIKE'  => '%' . trim($busca) . '%',
            );
            if (ctype_digit(trim($busca))) { //verifica se é somente numero
                $conditions['OR']['Post.id'] = (int)trim($busca);
            }
        }

        if ($dataInicioSql !== '') {
            $conditions['Post.criado_em >='] = $dataInicioSql . ' 00:00:00';
        }

        if ($dataFimSql !== '') {
            $conditions['Post.criado_em <='] = $dataFimSql . ' 23:59:59';
        }

        // Busca no Banco
        $posts = $this->Post->find('all', array(
            'conditions' => $conditions, //Obs: a busca de usuarios e posts tao dentro dessa variavel.
            'recursive'  => 1,
            'order'      => array('Post.id' => 'DESC'),
            'limit'      => 15
        ));

        $this->set(compact('posts', 'busca', 'dataInicio', 'dataFim', 'usuariosEncontrados'));
    }

    // Action para o botão "Limpar" para apagar a Sessão
    public function clearFilters()
    {
        $this->Session->delete('Filter');
        return $this->redirect(array('action' => 'index'));
    }

    public function view()
    {
        if (!$this->request->is('post')) {
            throw new NotFoundException(__('Post inválido'));
        }

        $postId = isset($this->request->data['Post']['id'])
            ? $this->request->data['Post']['id']
            : null;

        if (!$postId || !ctype_digit((string) $postId)) {
            throw new NotFoundException(__('Post inválido'));
        }

        // Usando find com recursive = 1 para carregar os dados do User associado
        $post = $this->Post->find('first', array(
            'conditions' => array(
                'Post.id' => (int) $postId,
                'Post.status' => true
            ),
            'recursive'  => 1
        ));

        if (!$post || empty($post['Post']['status'])) {
            throw new NotFoundException(__('Post não encontrado'));
        }

        $this->set('post', $post);
    }

    public function add()
    {
        if ($this->request->is('post')) {
            $this->Post->create();

            if (empty($this->request->data['Post']['user_id'])) {
                $this->request->data['Post']['user_id'] = $this->Auth->user('id');
            }

            // Processa o upload para o ImgBB via Multipart/CURLFile
            if (!empty($this->request->data['Post']['imagem']['tmp_name'])) {
                $fileTmpPath = $this->request->data['Post']['imagem']['tmp_name'];
                $fileName    = $this->request->data['Post']['imagem']['name'];
                $fileType    = $this->request->data['Post']['imagem']['type'];

                $apiKey = getenv('API_KEY') ?: ($_ENV['API_KEY'] ?? ($_SERVER['API_KEY'] ?? null));
                $apiKey = trim($apiKey);

                if (empty($apiKey)) {
                    CakeLog::write('error', '[ImgBB] API_KEY vazia no ambiente.');
                    unset($this->request->data['Post']['imagem']);
                } else {
                    // Envia o arquivo como CURLFile binário (Evita o bloqueio de payload base64)
                    $cfile = new CURLFile($fileTmpPath, $fileType, $fileName);

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, 'https://api.imgbb.com/1/upload?key=' . $apiKey);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, array(
                        'image' => $cfile
                    ));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)');
                    curl_setopt($ch, CURLOPT_TIMEOUT, 30);

                    $response = curl_exec($ch);
                    $curlError = curl_error($ch);
                    curl_close($ch);

                    if ($curlError) {
                        CakeLog::write('error', '[ImgBB cURL Error]: ' . $curlError);
                        unset($this->request->data['Post']['imagem']);
                    } else {
                        $jsonResponse = json_decode($response, true);

                        if (!empty($jsonResponse['data']['url'])) {
                            // Sucesso: Salva a URL da imagem
                            $this->request->data['Post']['imagem'] = $jsonResponse['data']['url'];
                        } else {
                            CakeLog::write('error', '[ImgBB API Response Error]: ' . $response);
                            unset($this->request->data['Post']['imagem']);
                        }
                    }
                }
            } else {
                unset($this->request->data['Post']['imagem']);
            }

            $saveAs = isset($this->request->data['Post']['status']) ? $this->request->data['Post']['status'] : 'published';
            $this->request->data['Post']['status'] = ($saveAs !== 'draft');

            if ($this->Post->save($this->request->data)) {
                $message = ($saveAs === 'draft') ? 'Rascunho salvo com sucesso.' : 'Post publicado com sucesso.';
                $this->Flash->success(__($message));
                return $this->redirect(array('action' => 'index'));
            }

            $this->Flash->error(__('Não foi possível salvar o post.'));
        }
    }

    public function edit($id = null)
    {
        if (!$id) {
            throw new NotFoundException(__('Post inválido'));
        }

        $post = $this->Post->findById($id);
        if (!$post) {
            throw new NotFoundException(__('Post não encontrado'));
        }

        $currentUserId = $this->Auth->user('id');
        $currentUserCargo = $this->Auth->user('cargo');
        if ($post['Post']['user_id'] != $currentUserId && !$this->hasAdminPrivileges($currentUserCargo)) {
            throw new ForbiddenException(__('Acesso não autorizado'));
        }

        // Verificar se o post editado é rascunho
        if ($this->request->is(array('post', 'put'))) {
            $this->Post->id = $id;

            $saveAs = isset($this->request->data['Post']['status'])
                ? $this->request->data['Post']['status']
                : null;

            if ($saveAs === 'draft') {
                $this->request->data['Post']['status'] = false;
            } else {
                $this->request->data['Post']['status'] = true;
            }

            // Tratamento da Imagem via ImgBB (igual ao add)
            if (!empty($this->request->data['Post']['imagem']['tmp_name'])) {
                $fileTmpPath = $this->request->data['Post']['imagem']['tmp_name'];
                $apiKey = getenv('API_KEY'); // Insira sua API Key aqui

                if (!$apiKey) {
                    throw new InternalErrorException('Chave de API não configurada.');
                }
                $imageData = base64_encode(file_get_contents($fileTmpPath));

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://api.imgbb.com/1/upload?key=' . $apiKey);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, array('image' => $imageData));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                $response = curl_exec($ch);
                curl_close($ch);

                $jsonResponse = json_decode($response, true);

                if (!empty($jsonResponse['data']['url'])) {
                    // Atualiza com a nova URL pública da imagem
                    $this->request->data['Post']['imagem'] = $jsonResponse['data']['url'];
                } else {
                    // Se falhou o upload, mantém a imagem antiga que já estava no banco
                    $this->request->data['Post']['imagem'] = $post['Post']['imagem'];
                }
            } else {
                // Se o usuário não enviou um novo arquivo, mantém a imagem já cadastrada
                unset($this->request->data['Post']['imagem']);
            }

            if ($this->Post->save($this->request->data)) {
                $this->Flash->success(__('O post foi atualizado com sucesso.', h($id)));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Flash->error(__('Não foi possível atualizar o post.'));
        }

        if ($this->request->is('get')) {
            $this->request->data = $post;
        }
    }

    public function delete($id = null)
    {
        if ($this->request->is('get')) {
            throw new MethodNotAllowedException();
        }

        $post = $this->Post->findById($id);
        if (!$post) {
            throw new NotFoundException(__('Post não encontrado'));
        }

        $currentUserId = $this->Auth->user('id');
        $currentUserCargo = $this->Auth->user('cargo');
        if ($post['Post']['user_id'] != $currentUserId && !$this->hasAdminPrivileges($currentUserCargo)) {
            throw new ForbiddenException(__('Acesso não autorizado'));
        }

        if ($this->Post->delete($id)) {
            $this->Flash->success(__('O post #%s foi excluído.', h($id)));
        } else {
            $this->Flash->error(__('Não foi possível excluir o post #%s.', h($id)));
        }

        return $this->redirect(array('action' => 'index'));
    }
}
