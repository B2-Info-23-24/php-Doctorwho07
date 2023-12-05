<?php

namespace Models;

use PDO, Models\AdminModel;

class UserModel
{
    static function CheckUser($email, $password)
    {
        $exist = UserModel::CheckUserExists($email);
        if ($exist == true) {
            $hashedPassword = AdminModel::GetHashedPassword($email);
            if (!AdminModel::VerifyPassword($password, $hashedPassword)) {
                return false;
            } else {
                $_SESSION['user'] = ['Email' => $email];
                return true;
            }
        } else {
            return false;
        }
    }
    static function CheckUserExists($email)
    {
        $db = ConnectDB::getConnection();
        $sql = "SELECT COUNT(*) FROM users WHERE Email = '$email'";
        $query = $db->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    static function GetUserByEmail($email)
    {
        $db = ConnectDB::getConnection();
        $sql = "SELECT * FROM users WHERE Email = ?'";
        $query = $db->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    static function AddUser($lastname, $firstname, $phone, $email, $password)
    {
        $db = ConnectDB::getConnection();
        $hashedPassword = AdminModel::HashPassword($password);
        $isAdmin = 0;
        $sql = "INSERT INTO users (Lastname, Firstname,phone, Email, IsAdmin, Password) VALUES ('$lastname', '$firstname','$phone', '$email', '$isAdmin', '$hashedPassword')";
        $query = $db->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    static function DeleteUser($email, $password)
    {
        $db = ConnectDB::getConnection();
        $hashedPasswordFromDB = AdminModel::GetHashedPassword($email);
        if (AdminModel::VerifyPassword($password, $hashedPasswordFromDB)) {
            $sql = "DELETE FROM users WHERE Email = '$email'";
            $query = $db->prepare($sql);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
    }
    static function DeleteUserById($userId)
    {
        $db = ConnectDB::getConnection();
        $sql = "DELETE FROM users WHERE Email = '$userId'";
        $query = $db->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    static function DeleteUserByEmail($userId)
    {
        $db = ConnectDB::getConnection();
        $sql = "DELETE FROM users WHERE Email = '$userId'";
        $query = $db->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    static function GetUserById($userId)
    {
        $db = ConnectDB::getConnection();
        $sql = "SELECT * FROM users WHERE ID = '$userId'";
        $query = $db->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    static function GetAllUsers()
    {
        $db = ConnectDB::getConnection();
        $sql = "SELECT * FROM users";
        $query = $db->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    static function UpdateUserById($userId, $newUserData)
    {
        $db = ConnectDB::getConnection();
        $currentUserData = UserModel::GetUserById($userId);
        foreach ($newUserData as $key => $value) {
            $currentUserData[$key] = $value;
        }
        $sql = "UPDATE users SET ";
        foreach ($currentUserData as $key => $value) {
            $sql .= "$key = '$value', ";
        }
        $sql = rtrim($sql, ", ");
        $sql .= " WHERE ID = '$userId'";
        $result = $db->exec($sql);
        return $result;
    }
}
