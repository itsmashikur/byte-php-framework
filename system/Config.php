<?php
class Config
{
    private $data;

    public function __construct()
    {
        $this->data = array();
        $this->readEnv();
    }

    private function readEnv()
    {
        $file = '.env';
        if (!file_exists($file)) {
            $this->createEnv();
        }
        $lines = file($file, FILE_IGNORE_NEW_LINES);
        foreach ($lines as $line) {
            $line = explode('=', $line);
            $this->data[$line[0]] = $line[1];
        }
    }
    private function createEnv()
    {
        $file = '.env';
        $handle = fopen($file, 'w') or die('Cannot open file:  ' . $file);
        $data = array(
            'DB_HOST' => 'localhost',
            'DB_NAME' => 'mydatabase',
            'DB_USER' => 'root',
            'DB_PASSWORD' => '',
            'APP_DEBUGG' => true,
        );
        foreach ($data as $key => $value) {
            $line = $key . '=' . $value . PHP_EOL;
            fwrite($handle, $line);
        }
        fclose($handle);
    }
    public function get($key)
    {
        if (array_key_exists($key, $this->data)) {
            return $this->data[$key];
        }
        return null;
    }


}
