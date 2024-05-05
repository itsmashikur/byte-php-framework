<?php

class AdminMiddleware
{
    public function handle($next)
    {
        // Check if the user is logged in
        // if (!isset($_SESSION['user'])) {
        //     // Redirect or throw an error, depending on your application's requirements
        //     header("Location: /login");
        //     exit;
        // }

        // Check if the user is an admin
        // $user = $_SESSION['user'];

        // if (!$user['is_admin']) {
        //     // Redirect or throw an error, depending on your application's requirements
        //     header("Location: /");
        //     exit;
        // }

        // Call the next middleware or route handler
        $next();
    }
}
