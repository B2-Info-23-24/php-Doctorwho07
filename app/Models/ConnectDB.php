<?php

namespace Models;

use Dotenv, PDOException, PDO, Exception;

class ConnectDB
{
    public static function getConnection()
    {
        $dotenv = Dotenv\Dotenv::createImmutable('./');
        $dotenv->load();
        $serverDB = $_ENV['DB_HOST'] ?? "mysql";

        $user = $_ENV['DB_USER'];
        $password = $_ENV['DB_PASSWORD'];
        $DB = $_ENV['DB_NAME'];

        try {
            $connexion = new PDO("mysql:host=$serverDB;dbname=$DB", $user, $password);
            return $connexion;
        } catch (PDOException $e) {
            echo "Erreur de connexion : " . $e->getMessage();
            $serverDB = "mysql";

            try {
                $connexion = new PDO("mysql:host=$serverDB;dbname=$DB", $user, $password);
                return $connexion;
            } catch (PDOException $e) {
                echo "Erreur de connexion à la base de données par défaut : " . $e->getMessage();
                return null;
            }
        }
    }
}
