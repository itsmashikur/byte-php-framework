<?php

class App
{

    public $config;
    

    public function __construct()
    {
        $this->config = new Config();
        $this->boot();

    }

    public static function boot()
    {
        Route::run();
        self::htaccessGenerate();

    }

    private static function htaccessGenerate()
    {
        if (!file_exists('.htaccess')) {
            $htAccess = file_get_contents("system/htaccess.stub");
            file_put_contents(".htaccess", $htAccess);
        }
    }

    public static function debug($_debugg_able)
    {
        print "<pre>";
        print_r($_debugg_able);
        print "</pre>";
    }
}
