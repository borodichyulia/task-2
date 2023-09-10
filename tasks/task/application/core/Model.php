<?php

namespace application\core;

use application\models\Db;

abstract class Model
{
    public $db;
    function __construct()
    {
        $this->db = Db::getInstance();
    }
}
