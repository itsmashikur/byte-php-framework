<?php

class ErrorHandler
{
    public function handle($errorCode, $message)
    {
        http_response_code($errorCode);
        $data = [

            'errorCode' => $errorCode,
            'errorMessage' => $message
        ];
        echo Template::render('error_pages/dynamic', $data);
    }
}
