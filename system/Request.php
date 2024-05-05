<?php

class Request
{
    private $parameters;

    public function __construct($parameters = [])
    {
        $this->parameters = (object) $parameters;
    }

    public function __get($name)
    {
        $data = array_merge((array)$this->parameters, $_GET, $_POST);
        return $data[$name] ?? $_FILES[$name] ?? null;
    }


    public static function all()
    {
        return (object) array_merge($_GET, $_POST);
    }

    public static function get()
    {
        return (object) $_GET;
    }

    public static function post()
    {
        return (object) $_POST;
    }

    public static function file($name)
    {
        return $_FILES[$name];
    }

    public function parameters()
    {
        return $this->parameters;
    }
}
