<?php

use Core\Route;
use Models\InitDB;


require_once(__DIR__ . '/vendor/autoload.php');

spl_autoload_register(function ($class) {
    require(__DIR__ . '/app/Controllers/' . $class . '.php');
});
InitDB::InitDB();
$route = $_SERVER['REQUEST_URI'];
Route::Route($route);
