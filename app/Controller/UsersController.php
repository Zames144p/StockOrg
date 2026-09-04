<?php

App::uses('AppController', 'Controller');

class UsersController extends AppController {
    public $helpers = array('Html', 'Form');

    public function beforeFilter() {
        parent::beforeFilter();
        // Configurações do AuthComponent
        $this->Auth->allow('login', 'cadastro'); // Permite acesso às ações de login e cadastro sem autenticação.
    }

    public function cadastro(){
        if($this->request->is('post')) {
            $this->User->create();
            if ($this->User->save($this->request->data)){
                $this->Session->setFlash('Cadastro realizado com sucesso!');
                return $this->redirect(array('action' => 'login'));
            }
        }
        $this->Session->setFlash('Não foi possível realizar o cadastro. Por favor, tente novamente.');
    }

    public function login(){
        if($this->request->is('post'))
    }    
}