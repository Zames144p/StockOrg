<?php

class PostsController extends AppController
{
    public $helpers = array('Html', 'Form');

    public function beforeFilter()
    {
        parent::beforeFilter();
        //aqui o usuario consegue acessar a home page e acessar os posts.
        $this->Auth->allow('index', 'view');
        $this->set('isAuthenticated', (bool) $this->Auth->user());
        $this->set('currentUser', $this->Auth->user());
    }

    public function index()
    {
        $rawBusca      = $this->request->query('busca');
        $rawDataInicio = $this->request->query('data_inicio');
        $rawDataFim    = $this->request->query('data_fim');

        $normalizeDate = function ($input) {
            if (is_array($input)) {
                if (!empty($input['year']) && !empty($input['month']) && !empty($input['day'])) {
                    return sprintf('%04d-%02d-%02d', $input['year'], $input['month'], $input['day']);
                }
                return '';
            }

            if (!is_string($input)) {
                return '';
            }
            //Assim ele pesquisa nos dois formatos 
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

        $busca      = is_string($rawBusca) ? trim($rawBusca) : '';
        $dataInicio = is_string($rawDataInicio) ? trim($rawDataInicio) : '';
        $dataFim    = is_string($rawDataFim) ? trim($rawDataFim) : '';
        $dataInicioSql = $normalizeDate($rawDataInicio);
        $dataFimSql = $normalizeDate($rawDataFim);
        $conditions = array('Post.status' => true);

        if (!empty($busca)) {
            $conditions['OR'] = array(
                'Post.title ILIKE' => '%' . $busca . '%',
                'Post.body ILIKE'  => '%' . $busca . '%'
            );
            if (ctype_digit($busca)) {
                $conditions['OR']['Post.id'] = (int)$busca;
            }
        }

        if ($dataInicioSql !== '') {
            $conditions['Post.created >='] = $dataInicioSql . ' 00:00:00';
        }

        if ($dataFimSql !== '') {
            $conditions['Post.created <='] = $dataFimSql . ' 23:59:59';
        }

        $posts = $this->Post->find('all', array(
            'conditions' => $conditions,
            'order'      => array('Post.created' => 'DESC'),
            'limit'      => 15
        ));

        $this->set(compact('posts', 'busca', 'dataInicio', 'dataFim'));
    }

    public function view($id = null)
    {
        if (!$id) {
            throw new NotFoundException(__('Invalid post'));
        }

        $post = $this->Post->findById($id);
        if (!$post || empty($post['Post']['status'])) {
            throw new NotFoundException(__('Invalid post'));
        }
        $this->set('post', $post);
    }
    public function add()
    {
        if ($this->request->is('post')) {
            $this->Post->create();

            $this->request->data['Post']['user_id'] = $this->Auth->user('id'); //Associa o post criado ao seu usuario
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
        //garante que esta tentando acessar um post
        if (!$id) {
            throw new NotFoundException(__('Invalid post'));
        }
        //verifica se o post existe
        $post = $this->Post->findById($id);
        if (!$post) {
            throw new NotFoundException(__('Invalid post'));
        }
        //finalmente verifica se o post foi editado e salva as alterações
        if ($this->request->is(array('post', 'put'))) {
            $this->Post->id = $id;
            if ($this->Post->save($this->request->data)) {
                $this->Flash->success(__('The post with id: %s has been updated.', h($id)));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Flash->error(__('Unable to update your post.'));
        }
        //posta depois da edição, para que o usuário possa ver o post editado
        if ($this->request->is('get')) {
            $this->request->data = $post;
        }
    }

    public function delete($id = null)
    {
        if ($this->request->is('get')) {
            throw new MethodNotAllowedException();
        };

        if ($this->Post->delete($id)) {
            $this->Flash->success(
                __('The post with id: %s has been deleted.', h($id))
            );
            return $this->redirect(array('action' => 'index'));
        } else {
            $this->Flash->error(
                __('The post with id: %s could not be deleted.', h($id))
            );
        }

        return $this->redirect(array('action' => 'index'));
    }
}
