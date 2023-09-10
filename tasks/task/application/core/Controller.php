<?php

namespace application\core;

use application\core\View;
use application\services\UsersService;

abstract class Controller
{

    public $route;
    public $view;
    public $model;
    public $service;

    public function __construct($route)
    {
        $this->route = $route;
        $this->view = new View($route);
        $this->model = $this->loadModel($route['controller']);
        $this->service = new UsersService();
    }

    public function loadModel($name)
    {
        $path = 'application\models\\' . ucfirst($name);
        if (class_exists($path)) {
            return new $path;
        }
    }
}
