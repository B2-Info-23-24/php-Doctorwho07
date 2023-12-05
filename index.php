<?php

use Core\Route;
use Models\InitDB;

require_once(__DIR__ . '/vendor/autoload.php');
InitDB::InitDB();
$route = $_SERVER['REQUEST_URI'];
Route::Route($route);