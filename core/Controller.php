<?php
class Controller {
    protected function model($model) {
        require_once 'models/' . $model . '.php';
        return new $model();
    }

    protected function view($view, $data = []) {
        if (file_exists('views/' . $view . '.php')) {
            extract($data);
            require_once 'views/' . $view . '.php';
        } else {
            throw new Exception("View not found: $view");
        }
    }

    protected function redirect($url) {
        header('Location: ' . $url);
        exit();
    }
} 