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
        if (!$this->id) {
            $this->data[$this->alias]['criado_em'] = date('Y-m-d H:i:s');
        } else {
            $this->data[$this->alias]['modificado_em'] = date('Y-m-d H:i:s');
        }

        return true;
    }
}