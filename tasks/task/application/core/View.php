<?php

namespace application\core;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class View
{

    public $path;
    public $route;
    public $layout = 'default';

    public function __construct($route)
    {
        $this->route = $route;
        $this->path = $route['controller'] . '/' . $route['action'];
    }

    public function render($title, $vars = [])
    {
        require_once '/var/www/vendor/autoload.php';

        $loader = new FilesystemLoader('application/views/');
        $twig = new Environment($loader);

        switch ($this->route['action']) {
            case 'index':
                $template = $twig->load('app/index.twig');
                echo $template->render(['title' => $title]);
                break;
            case 'create':
                $template = $twig->load('users/create.twig');
                echo $template->render(['title' => $title]);
                break;
            case 'editUser':
                $template = $twig->load('users/editUser.twig');
                echo $template->render(['title' => $title, 'user' => $vars['user']]);
                break;
            case 'new':
                $template = $twig->load('users/new.twig');
                echo $template->render(['title' => $title, 'user' => $vars]);
                break;
            case 'getAll':
                $template = $twig->load('users/getAll.twig');
                echo $template->render(['title' => $title, 'users' => $vars['users'], 'pogination' => $vars['pogination']]);
                break;
            case 'getOne':
                $template = $twig->load('users/getOne.twig');
                echo $template->render(['title' => $title, 'user' => $vars['user']]);
                break;
        }
    }

    public function redirect($url)
    {
        header('location: ' . $url);
        exit;
    }


    public static function errorCode($code)
    {
        http_response_code($code);
        $path = 'application/views/errors/' . $code . '.php';
        if (file_exists($path)) {
            require $path;
        }
        exit;
    }
}
