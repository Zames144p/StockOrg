<?php

class Post extends AppModel {
    public $useTable = 'posts';
    public $primaryKey = 'id';
    public $displayField = 'title';

    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id'
        )
    );

    public $validate = array(
        'title' => array(
            'rule' => 'notBlank',
            'message' => 'Title is required'
        ),
        'body' => array(
            'rule' => 'notBlank',
            'message' => 'Body is required'
        )
    );

    public function beforeSave($options = array()) {
        $now = date('Y-m-d H:i:s');
        

        // Se for um post novo
        if (!$this->id && empty($this->data[$this->alias]['id'])) {
            $this->data[$this->alias]['criado_em'] = $now;
        }

        // Sempre atualiza a data de alteração com a data/hora atual formatada
        $this->data[$this->alias]['modificado_em'] = $now;

        return true;
    }
}