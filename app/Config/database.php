<?php
class DATABASE_CONFIG {

    public $default;

    public function __construct() {
        $this->default = array(
            'datasource' => 'Database/Postgres',
            'persistent' => false,
            'host'       => getenv('DATABASE_HOST') ?: '172.17.0.1',
            'login'      => getenv('DATABASE_USER') ?: 'cakeBlog',
            'password'   => getenv('DATABASE_PASSWORD') ?: 'c4k3-rUl3Z',
            'database'   => getenv('DATABASE_NAME') ?: 'blogdb',
            'port'       => getenv('DATABASE_PORT') ?: 5432,
            'prefix'     => '',
            'encoding'   => 'utf8',
            'sslmode'    => 'prefer'
        );
    }

    public $test = array(
        'datasource' => 'Database/Postgres',
        'persistent' => false,
        'host'       => '172.17.0.1',
        'port'       => 5432,
        'login'      => 'user',
        'password'   => 'password',
        'database'   => 'blogdb_test',
        'prefix'     => '',
        'encoding'   => 'utf8',
    );
}