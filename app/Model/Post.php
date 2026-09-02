<?php

class Post extends AppModel {
    public $useTable = 'posts';
    public $primaryKey = 'id';
    public $displayField = 'title';

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