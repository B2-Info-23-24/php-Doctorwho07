<?php

// index.php
require_once(__DIR__ . '/vendor/autoload.php');
require_once(__DIR__ . '/app/Core/routes.php');
require_once "app/Models/init_DB.php";

InitDB();
// session_start();

spl_autoload_register(function ($class) {
    include 'app/Controllers/' . $class . '.php';
});

// $route = $_SERVER['REQUEST_URI'];
// Route($route);