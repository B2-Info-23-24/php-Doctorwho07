<?php

namespace Models;

use PDO, Models\UserModel;

class AdminModel
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
    static function GetHashedPassword($email)
    {
        $db = ConnectDB::getConnection();
        $sql = "SELECT Password FROM users WHERE Email = ?";
        $query = $db->prepare($sql);
        $query->execute([$email]);
        $result = $query->fetchColumn();
        return $result;
    }
    public static function grantAdminRole($userID)
    {
        $db = ConnectDB::getConnection();
        $sql = "UPDATE users SET IsAdmin = 1 WHERE ID = ?";
        $query = $db->prepare($sql);
        return $query->execute([$userID]);
    }

    public static function revokeAdminRole($userID)
    {
        $db = ConnectDB::getConnection();
        $sql = "UPDATE users SET IsAdmin = 0 WHERE ID = ?";
        $query = $db->prepare($sql);
        return $query->execute([$userID]);
    }

    static function IsAdmin($id)
    {
        $db = ConnectDB::getConnection();
        $sql = "SELECT IsAdmin FROM users WHERE ID = ?";
        $query = $db->prepare($sql);
        $query->execute([$id]);
        $result = $query->fetchColumn();
        return $result === '1';
    }
}
