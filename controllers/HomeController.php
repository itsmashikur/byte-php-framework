<?php

class HomeController
{
    public function index()
    {
        return Template::render('index');
    }
    public function user(){
        $request = new Request();
        print_r($request->get());
    }
}