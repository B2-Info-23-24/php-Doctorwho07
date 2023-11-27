<?php

use Core\Route;
use Models\InitDB;

require_once(__DIR__ . '/vendor/autoload.php');

spl_autoload_register(function ($class) {
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    require(__DIR__ . '/app/' . $class . '.php');
});
InitDB::InitDB();
$route = $_SERVER['REQUEST_URI'];
Route::Route($route);
