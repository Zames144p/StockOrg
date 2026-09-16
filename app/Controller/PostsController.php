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
        // 1. Se o formulário foi enviado via POST, atualiza os dados na Sessão
        if ($this->request->is('post')) {
            // CORRIGIDO: Usa ['busca'] ou ['Post']['busca'] em vez de ('busca')
            $dataPost = $this->request->data;

            $busca      = isset($dataPost['busca']) ? $dataPost['busca'] : (isset($dataPost['Post']['busca']) ? $dataPost['Post']['busca'] : '');
            $dataInicio = isset($dataPost['data_inicio']) ? $dataPost['data_inicio'] : (isset($dataPost['Post']['data_inicio']) ? $dataPost['Post']['data_inicio'] : '');
            $dataFim    = isset($dataPost['data_fim']) ? $dataPost['data_fim'] : (isset($dataPost['Post']['data_fim']) ? $dataPost['Post']['data_fim'] : '');

            $this->Session->write('Filter.busca', $busca);
            $this->Session->write('Filter.data_inicio', $dataInicio);
            $this->Session->write('Filter.data_fim', $dataFim);
        }

        // 2. Lê os filtros salvos na Sessão (ou define vazio se não existir)
        $busca      = $this->Session->read('Filter.busca') ?: '';
        $dataInicio = $this->Session->read('Filter.data_inicio') ?: '';
        $dataFim    = $this->Session->read('Filter.data_fim') ?: '';

        // Função de normalização de data
        $normalizeDate = function ($input) {
            if (!is_string($input) || trim($input) === '') return '';
            $input = trim($input);
            foreach (array('d/m/Y', 'Y-m-d') as $format) {
                $date = DateTime::createFromFormat($format, $input);
                $errors = DateTime::getLastErrors();
                if ($date && ($errors === false || ($errors['warning_count'] === 0 && $errors['error_count'] === 0))) {
                    return $date->format('Y-m-d');
                }
            }
            return '';
        };

        $dataInicioSql = $normalizeDate($dataInicio);
        $dataFimSql    = $normalizeDate($dataFim);

        // 3. Monta as condições da Query
        $conditions = array('Post.status' => true);

        if (!empty($busca)) {
            $conditions['OR'] = array(
                'Post.title ILIKE' => '%' . trim($busca) . '%',
                'Post.body ILIKE'  => '%' . trim($busca) . '%'
            );
            if (ctype_digit(trim($busca))) {
                $conditions['OR']['Post.id'] = (int)trim($busca);
            }
        }

        if ($dataInicioSql !== '') {
            $conditions['Post.criado_em >='] = $dataInicioSql . ' 00:00:00';
            $conditions['Post.criado_em >='] = $dataInicioSql . ' 00:00:00';
        }

        if ($dataFimSql !== '') {
            $conditions['Post.criado_em <='] = $dataFimSql . ' 23:59:59';
            $conditions['Post.criado_em <='] = $dataFimSql . ' 23:59:59';
        }

        // 4. Busca no Banco
        $posts = $this->Post->find('all', array(
            'conditions' => $conditions,
            'recursive'  => 1,
            'order'      => array('Post.id' => 'DESC'),
            'limit'      => 15
        ));

        $this->set(compact('posts', 'busca', 'dataInicio', 'dataFim'));
    }

    // Action para o botão "Limpar" para apagar a Sessão
    public function clearFilters()
    {
        $this->Session->delete('Filter');
        return $this->redirect(array('action' => 'index'));
    }

    public function view($id = null)
    {
        if (!$id) {
            throw new NotFoundException(__('Post inválido'));
        }

        // Usando find com recursive = 1 para carregar os dados do User associado
        $post = $this->Post->find('first', array(
            'conditions' => array('Post.id' => $id),
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

            // 1. Processa o upload da imagem via API Externa (ImgBB)
            if (!empty($this->request->data['Post']['imagem']['tmp_name'])) {
                $fileTmpPath = $this->request->data['Post']['imagem']['tmp_name'];
                $apiKey = '2f3135018d4bf867ad25145de87eaba8'; // Insira sua API Key aqui

                // Prepara a imagem em base64 para envio
                $imageData = base64_encode(file_get_contents($fileTmpPath));

                // Configura requisição cURL para a API do ImgBB
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://api.imgbb.com/1/upload?key=' . $apiKey);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, array('image' => $imageData));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                $response = curl_exec($ch);
                curl_close($ch);

                $jsonResponse = json_decode($response, true);

                // Se o upload externo deu certo, salva a URL publica direta
                if (!empty($jsonResponse['data']['url'])) {
                    $this->request->data['Post']['imagem'] = $jsonResponse['data']['url'];
                } else {
                    // Em caso de falha no envio externo, ignora a imagem para nao quebrar o post
                    unset($this->request->data['Post']['imagem']);
                }
            } else {
                unset($this->request->data['Post']['imagem']);
            }

            $this->request->data['Post']['user_id'] = $this->Auth->user('id');
            $saveAs = isset($this->request->data['Post']['save_as'])
                ? $this->request->data['Post']['save_as']
                : 'published';
            $this->request->data['Post']['status'] = ($saveAs !== 'draft');
            unset($this->request->data['Post']['save_as']);

            if ($this->Post->save($this->request->data)) {
                $message = $saveAs === 'draft'
                    ? 'Rascunho salvo com sucesso.'
                    : 'Post publicado com sucesso.';
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

        if ($this->request->is(array('post', 'put'))) {
            $this->Post->id = $id;

            //Tratamento da Imagem via ImgBB (igual ao add)
            if (!empty($this->request->data['Post']['imagem']['tmp_name'])) {
                $fileTmpPath = $this->request->data['Post']['imagem']['tmp_name'];
                $apiKey = '2f3135018d4bf867ad25145de87eaba8'; // Insira a sua chave do ImgBB

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
                $this->Flash->success(__('O post #%s foi atualizado com sucesso.', h($id)));
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

        if ($this->Post->delete($id)) {
            $this->Flash->success(__('O post #%s foi excluído.', h($id)));
        } else {
            $this->Flash->error(__('Não foi possível excluir o post #%s.', h($id)));
        }

        return $this->redirect(array('action' => 'index'));
    }
}
