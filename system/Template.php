<?php

class Template
{
    public static function render($view, $data = [])
    {
        extract($data);
        ob_start();
        include 'views/' . $view . '.php';
        print ob_get_clean();
    }
}