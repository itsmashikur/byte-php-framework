<?php

//show errors

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);


class Byte
{

    public $application;

    public function __construct()
    {
        spl_autoload_register(function () {
            $directories = ['system', 'controllers', 'routes', 'middlewares', 'addons', 'config', 'models'];
            foreach ($directories as $directory) {
                $subDirectories = glob($directory . '/*', GLOB_ONLYDIR);
                $directories = array_merge(array($directory), $subDirectories);

                foreach ($directories as $dir) {
                    foreach (glob($dir . '/*.php') as $file) {
                        if (is_file($file)) {
                            require_once $file;
                        }
                    }
                }
            }
        });

        $this->application = new App();
    }

}

$byte = new Byte();




