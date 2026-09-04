<?php

class PostsController extends AppController {
    public $helpers = array('Html', 'Form');

    public function beforeFilter() {
        parent::beforeFilter();

        $this->Auth->allow('posts');
    }

    public function index() {
        $this->set('posts', $this->Post->find('all'));
    }

    public function view($id = null) {
        if (!$id) {
            throw new NotFoundException(__('Invalid post'));
        }

        $post = $this->Post->findById($id);
        if (!$post) {
            throw new NotFoundException(__('Invalid post'));
        }
        $this->set('post', $post);
    }
    public function add(){
        if($this->request->is('post')){
            $this->Post->create();
            if($this->Post->save($this->request->data)){
                $this->Flash->sucesse(__('Your post has been saved.'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Flash->error(__('Unable to add your post.'));
        }
    }
    public function edit($id = null){
        //garante que esta tentando acessar um post
        if(!$id){
            throw new NotFoundException(__('Invalid post'));
        }
        //verifica se o post existe
        $post = $this->Post->findById($id);
        if(!$post){
            throw new NotFoundException(__('Invalid post'));
        }
        //finalmente verifica se o post foi editado e salva as alterações
        if($this->request->is(array('post', 'put'))){
            $this->Post->id = $id;
            if($this->Post->save($this->request->data)){
                $this->Flash->success(__('The post with id: %s has been updated.', h($id)));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Flash->error(__('Unable to update your post.'));
        }
        //posta depois da edição, para que o usuário possa ver o post editado
        if($this->request->is('get')){
            $this->request->data = $post;
        }
    }

    public function delete($id = null){
            if($this->request->is('get')){
                throw new MethodNotAllowedException();

            };

            if($this->Post->delete($id)){
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