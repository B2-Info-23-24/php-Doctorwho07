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
        $sql = "SELECT Password FROM users WHERE Email = '$email'";
        $query = $db->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public static function grantAdminRole($userID)
    {
        $db = ConnectDB::getConnection();
        $sql = "UPDATE users SET IsAdmin = 1 WHERE ID = ?";
        $query = $db->prepare($sql);
        $query->execute([$userID]);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public static function revokeAdminRole($userID)
    {
        $db = ConnectDB::getConnection();
        $sql = "UPDATE users SET IsAdmin = 0 WHERE ID = ?";
        $query = $db->prepare($sql);
        $query->execute([$userID]);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    static function IsAdmin($id)
    {
        $db = ConnectDB::getConnection();
        $sql = "SELECT IsAdmin FROM users WHERE ID = '$id'";
        $query = $db->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}
