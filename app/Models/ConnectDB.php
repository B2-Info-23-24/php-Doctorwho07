<?php

namespace Models;

use Dotenv, PDO;

class ConnectDB
{
    public static function getConnection()
    {
        $dotenv = Dotenv\Dotenv::createImmutable('./');
        $dotenv->load();
        $serverDB = $_ENV['DB_HOST'];
        $user = $_ENV['DB_USER'];
        $password = $_ENV['DB_PASSWORD'];
        $DB = $_ENV['DB_NAME'];
        $db = new PDO("mysql:host=$serverDB;dbname=$DB", $user, $password);
        return $db;
    }
}
