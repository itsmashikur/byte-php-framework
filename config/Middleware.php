<?php

class Middleware
{
    public static $middlewares = [
        'admin' => AdminMiddleware::class
    ];
}