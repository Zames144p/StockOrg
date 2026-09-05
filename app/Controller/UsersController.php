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
        //primeiro eu verifico a requisiçao, se for get é pq o usuario ta acessando pela primeira vez.
        if ($this->request->is('get')) {
            return; //manda pra login normalmente
        }
        //Se for post, ele ta preenchendo o formularios e entao verifico se o usuario ja existe
        if($this->request->is('post')){
            if($this->Auth->login()){ //esse metodo do cake verifica tanto o usuario quanto a senha, retornando true se tiver certo.
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Session->setFlash('Usuário ou senha inválidos, tente novamente.');
        }
    }
}