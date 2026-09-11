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
}