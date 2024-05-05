# MiniPHP Framework (Byte)

MiniPHP is a lightweight PHP framework inspired by Laravel but without any Composer dependencies. It's designed to provide essential features for building web applications in PHP without the overhead of a full-fledged framework. This README will guide you through the setup and usage of MiniPHP.

## Features

- **Routing**: Define clean and flexible routes for handling HTTP requests.
- **Middleware**: Implement middleware to intercept and process HTTP requests before they reach your application's core logic.
- **Template Rendering**: Render views using a simple templating engine.
- **Authentication**: Basic authentication system to secure routes.
- **Session Management**: Utilize PHP sessions for user authentication and data persistence.
- **Error Handling**: Basic error handling mechanisms for a smooth development experience.

## Installation

Simply clone the repository to get started:



# Usage Guide for MiniPHP Framework

## Routing
Define routes in `routes.php`.

```php
Route::group(['prefix' => '/admin', 'middleware' => ['admin']], function () {
    Route::get('/', [HomeController::class, 'index']);
    Route::get('/users', [UserController::class, 'index']);
});

Route::group(['prefix' => '/api', 'middleware' => ['admin', 'auth']], function () {
    Route::get('/posts', [PostController::class, 'index']);
    Route::post('/posts', [PostController::class, 'store']);
});

```

Controllers

Implement controllers to handle route actions.

```php

class HomeController
{
    public function index()
    {
        return Template::render('index');
    }

    public function user()
    {
        $request = new Request();
        print_r($request->get());
    }
}

```


Middleware

Define middleware to intercept requests.

```php

class AdminMiddleware
{
    public function handle($next)
    {
        // Check if the user is logged in and an admin
        // Redirect or throw errors if conditions are not met

        // Call the next middleware or route handler
        $next();
    }
}


```

Views

Return Views.

```php
return Template::render('index', ['data' => $data]);
```

# Contributing to MiniPHP Framework

We welcome contributions from the community to help improve MiniPHP and make it even better. Whether you're a seasoned developer or just starting out, there are many ways you can contribute to the project.

## How to Contribute

### 1. Reporting Bugs

If you encounter any bugs or issues while using MiniPHP, please report them by opening a new issue on our GitHub repository. Be sure to include detailed information about the problem, including steps to reproduce it if possible.

### 2. Suggesting Enhancements

Have an idea for a new feature or improvement? We'd love to hear it! Feel free to open an issue on GitHub to discuss your suggestion with the community.

### 3. Providing Feedback

Your feedback is invaluable in helping us understand how we can make MiniPHP better. Whether it's positive feedback or constructive criticism, please share your thoughts with us by opening an issue on GitHub.

### 4. Contributing Code

If you're comfortable with coding, you can contribute directly to the MiniPHP codebase by submitting pull requests. Whether it's fixing bugs, implementing new features, or improving existing functionality, your contributions are highly appreciated.

## Thank You

I appreciate your interest in contributing to MiniPHP! Your contributions help make this project better for everyone. If you have any questions or need assistance, don't hesitate to reach out to me.

