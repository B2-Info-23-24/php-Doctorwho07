<?php

use Core\Route;

require_once(__DIR__ . '/vendor/autoload.php');

spl_autoload_register(function ($class) {
    require(__DIR__ . '/app/Controllers/' . $class . '.php');
});

$route = $_SERVER['REQUEST_URI'];
Route::Route($route);
