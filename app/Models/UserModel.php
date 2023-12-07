<?php

namespace Models;

use PDO, PDOException, Models\AdminModel;

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
                $userId = UserModel::getUserIdByEmail($email);
                $_SESSION['user'] = ['Email' => $email];
                return $userId;
            }
        } else {
            return false;
        }
    }
    public static function getAllUserEmails()
    {
        $db = ConnectDB::getConnection();
        $sql = "SELECT Email FROM users";
        $query = $db->prepare($sql);
        $query->execute();
        $emails = $query->fetchAll(PDO::FETCH_COLUMN);
        return $emails;
    }
    static function CheckUserExists($email)
    {
        $connexion = ConnectDB::getConnection();

        try {
            $sql = "SELECT COUNT(*) FROM users WHERE Email = :email";
            $stmt = $connexion->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $result = $stmt->fetchColumn();

            return $result > 0;
        } catch (PDOException $e) {
            echo "Erreur lors de la vérification de l'utilisateur : " . $e->getMessage();
            return false;
        }
    }

    static function GetUserIdByEmail($email)
    {
        $db = ConnectDB::getConnection();
        $sql = "SELECT ID FROM users WHERE Email = ?";
        $query = $db->prepare($sql);
        $query->execute([$email]);
        $result = $query->fetchColumn();
        return $result !== false ? $result : null;
    }


    static function AddUser($lastname, $firstname, $phone, $email, $password)
    {
        $db = ConnectDB::getConnection();
        $userExists = UserModel::CheckUserExists($email);

        if ($userExists) {
            echo "Adresse email déjà utilisée. Veuillez en choisir une autre.";
            return false;
        } else {
            $hashedPassword = AdminModel::HashPassword($password);
            $isAdmin = 0;
            try {
                $sql = "INSERT INTO users (Lastname, Firstname,phone, Email, IsAdmin, Password) VALUES ('$lastname', '$firstname','$phone', '$email', '$isAdmin', '$hashedPassword')";
                $db->exec($sql);
                return true;
            } catch (PDOException $e) {
                echo "Erreur lors de l'ajout de l'utilisateur : " . $e->getMessage();
                return false;
            }
        }
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
        $sql = "DELETE FROM users WHERE Email = ?";
        $query = $db->prepare($sql);
        return $query->execute([$userId]);;
    }
    static function DeleteUserByEmail($userId)
    {
        $db = ConnectDB::getConnection();
        $sql = "DELETE FROM users WHERE Email = ?";
        $query = $db->prepare($sql);
        return $query->execute([$userId]);;
    }
    static function GetUserById($userId)
    {
        $db = ConnectDB::getConnection();
        $sql = "SELECT * FROM users WHERE ID = ?";
        $query = $db->prepare($sql);
        $query->execute([$userId]);
        $userData = $query->fetch(PDO::FETCH_ASSOC);
        return $userData;
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
        $updateFields = [];
        $updateValues = [];
        foreach ($newUserData as $key => $value) {
            if ($key === 'Password') {
                $hashedPassword = AdminModel::HashPassword($value);
                $updateFields[] = "Password = ?";
                $updateValues[] = $hashedPassword;
            } elseif (array_key_exists($key, $currentUserData)) {
                $updateFields[] = "$key = ?";
                $updateValues[] = $value;
            }
        }
        $updateValues[] = $userId;
        $sql = "UPDATE users SET " . implode(", ", $updateFields) . " WHERE ID = ?";
        $query = $db->prepare($sql);
        $success = $query->execute($updateValues);
        return $success;
    }
}
