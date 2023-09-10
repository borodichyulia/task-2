<?php

namespace application\models;

class Db
{
    private $db;
    private static $instance = null;

    private function __construct()
    {
        $config = require 'application/config/db.php';
        $this->db = mysqli_connect( 'db', 'root', 'password', 'db');
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Db();
        }
        return self::$instance;
    }

    public function query($sql)
    {
        $result = mysqli_query($this->db, $sql);
        return $result;
    }

    public function doSomething($arg)
    {
        return "Hello $arg";
    }
}
