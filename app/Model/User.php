<?php

//Aqui eu carreguei a classe do appmodel e a classe do blowfish para poder hashear a senha do usuário
app::uses('AppModel', 'Model');
app::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');
//authcomponent pra uma verificação antes da verificação kkkkkkkkjkjkjk
app::uses('authcomponent', 'Controller/Component');

class User extends AppModel
{
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
        'senha_hash' => array(
            'rule' => 'notBlank',
            'message' => 'A senha não pode estar em branco.',
            'on' => 'create'
        ),
        'confirmar_senha' => array(
            'rule' => 'matchPasswords',
            'message' => 'As senhas precisam ser iguais.',
            'on' => 'create'
        ),
    );

    public $hasMany = array(
        'Post' => array(
            'className' => 'Post',
            'foreignKey' => 'user_id',
            'dependent' => true // Deleta posts no Cake se o User for removido
        )
    );

    public function matchPasswords($data)
    { //Quando é usado o save de user, automaticamente é requisitado pelo cake
        return $data['confirmar_senha'] === $this->data[$this->alias]['senha_hash'];
        //Compara o texto puro no formulario, ai n precisa fazer uma puta verificação tlgd
    }

    public function beforeSave($options = array())
    {
        // 1. Remove a confirmação de senha para não tentar salvar no banco
        unset($this->data[$this->alias]['confirmar_senha']);

        $now = date('Y-m-d H:i:s');

        // Se for um novo registro (INSERT)
        if (empty($this->data[$this->alias]['id'])) {
            $this->data[$this->alias]['created'] = $now;
        }

        // Atualiza sempre o timestamp
        $this->data[$this->alias]['modified'] = $now;

        // Criptografa a senha exatamente na chave 'senha_hash' do seu formulário
        if (!empty($this->data[$this->alias]['senha_hash'])) {
            $passwordHasher = new BlowfishPasswordHasher();
            $this->data[$this->alias]['senha_hash'] = $passwordHasher->hash(
                $this->data[$this->alias]['senha_hash']
            );
        } else {
            unset($this->data[$this->alias]['senha_hash']);
        }

        // 5. Define o cargo padrão se estiver vazio
        if (!$this->id && empty($this->data[$this->alias]['cargo'])) {
            $this->data[$this->alias]['cargo'] = 'Autor';
        }

        return true;
    }
}
