<?php

class BlogController
{
    public function index($request)
    {
        App::debug($request->parameters());
    }
}
