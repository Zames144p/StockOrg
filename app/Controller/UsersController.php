<?php

App::uses('AppController', 'Controller');

class UsersController extends AppController {
    public $helpers = array('Html', 'Form');

    public function login(){
        $this->layout = false;
    }

    public function cadastro(){
        $this->layout = false;
    }
}