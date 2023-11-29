<?php

namespace Models;

use PDOException;

class Security
{
    static function HashPassword($password)
    {
        $options = [
            'memory_cost' => 1 << 17,
            'time_cost' => 4,
            'threads' => 2
        ];
        return password_hash($password, PASSWORD_ARGON2ID, $options);
    }

    static function VerifyPassword($password, $hashedPassword)
    {
        return password_verify($password, $hashedPassword);
    }
    static function getHashedPasswordByEmail($email)
    {
        $connexion = ConnectDB::getConnection();
        try {
            $sql = "SELECT Password FROM users WHERE Email = ?";
            $prepare = $connexion->prepare($sql);
            $prepare->execute([$email]);
            $hashedPassword = $prepare->fetchColumn();
            return $hashedPassword !== false ? $hashedPassword : null;
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération du mot de passe haché : " . $e->getMessage();
            return null;
        }
    }
}
