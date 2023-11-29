<?php

namespace Models;

use PDOException;

class AdminModel
{
    public static function grantAdminPrivileges($userID)
    {
        $connexion = ConnectDB::getConnection();
        try {
            $query = $connexion->prepare("UPDATE users SET IsAdmin = 1 WHERE ID = ?");
            $success = $query->execute([$userID]);
            return $success;
        } catch (PDOException $e) {
            return false;
        }
    }
    public static function revokeAdminPrivileges($userID)
    {
        $connexion = ConnectDB::getConnection();
        try {
            $query = $connexion->prepare("UPDATE users SET IsAdmin = 0 WHERE ID = ?");
            $success = $query->execute([$userID]);
            return $success;
        } catch (PDOException $e) {
            return false;
        }
    }
    static function IsAdmin($id)
    {
        $connexion = ConnectDB::getConnection();

        $sql = "SELECT IsAdmin FROM users WHERE ID = '$id'";
        $isAdmin = $connexion->query($sql)->fetchColumn();
        return $isAdmin !== 1 ? $isAdmin : 0;
    }
}
