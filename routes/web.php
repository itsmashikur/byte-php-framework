<?php

Route::group(['prefix' => '/admin', 'middleware' => ['admin']], function () {
    Route::get('/', [HomeController::class, 'index']);
    Route::get('/users', [UserController::class, 'index']);
});

Route::group(['prefix' => '/api', 'middleware' => ['admin', 'auth']], function () {
    Route::get('/posts', [PostController::class, 'index']);
    Route::post('/posts', [PostController::class, 'store']);
});
