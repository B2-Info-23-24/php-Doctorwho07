<?php
function ConnectDB()
{
    $dotenv = Dotenv\Dotenv::createImmutable('./');
    $dotenv->load();
    $serverDB = $_ENV['DB_HOST'];
    $user = $_ENV['DB_USER'];
    $password = $_ENV['DB_PASSWORD'];
    $DB = $_ENV['DB_NAME'];

    try {
        $connexion = new PDO("mysql:host=$serverDB;dbname=$DB", $user, $password);
        return $connexion;
    } catch (PDOException $e) {
        echo "Erreur de connexion : " . $e->getMessage();
    }
}