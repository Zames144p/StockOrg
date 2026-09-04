<?php

//Aqui eu carreguei a classe do appmodel e a classe do blowfish para poder hashear a senha do usuário
app::uses('AppModel', 'Model');
app::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');
//authcomponent pra uma verificação antes da verificação kkkkkkkkjkjkjk
app::uses('authcomponent', 'Controller/Component');

class User extends AppModel {
    public $table = 'users';
    protected $username = 'username';

    //Obs: a variavel validate é uma variavel do cake, ent ela é usada pra validar os formularios.
    public $validate = array(
        'nome' => array(
            'rule' => 'notBlank',
            'message' => 'O nome de usuário não pode estar em branco.',

            'unique' => array(
                'rule' => 'isUnique',
                'message' => 'Este nome de usuário já está em uso.'
            )
        ),
        'senha' => array(
            'rule' => 'notBlank',
            'message' => 'A senha não pode estar em branco.'
        ),
        'confirmar_senha' => array(
            'rule' => 'matchPasswords',
            'message' => 'As senhas precisam ser iguais.'
        ),
    );

    public function beforeSave($options = array()) {
        //verifico se tem o id na tabela, se nao tiver, criar um novo e se ja tiver, ele vai modificar.
        if(!$this -> id){
            $this->data[$this->alias]['created'] = date('Y-m-d H:i:s');
        }
        if($this -> id){
            $this->data[$this->alias]['modified'] = date('Y-m-d H:i:s');
        }

        //Depois de ver se o usuario ja existe ou não, recebemos a informação de senha do usuario e hashear antes de botar no banco.
        if (isset($this->data[$this->alias]['password']))//verifica se tem uma senha ou não. 
        {
            $passwordHasher = new BlowfishPasswordHasher();
            $this->data[$this->alias]['password'] = $passwordHasher->hash(
                $this->data[$this->alias]['password']
            );
        }

        return true;
    }

    public function autorOuNao($id){
        if(empty($this->data[$this->alias]['cargo'])){
            $this->data[$this->alias]['cargo'] = 'autor';
        }
    }
}