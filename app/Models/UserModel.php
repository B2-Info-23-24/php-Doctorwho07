<?php

namespace Models;

use PDOException, PDO;

class UserModel
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
        $connexion = ConnectDB::getConnection();

        try {
            $sql = "SELECT Password FROM users WHERE Email = '$email'";
            $hashedPassword = $connexion->query($sql)->fetchColumn();
            return $hashedPassword !== false ? $hashedPassword : null;
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération du mot de passe haché : " . $e->getMessage();
            return null;
        }
    }

    static function CheckUserExists($email)
    {
        $connexion = ConnectDB::getConnection();

        try {
            $sql = "SELECT ID FROM users WHERE Email = '$email'";
            $result = $connexion->query($sql)->fetchColumn();
            return $result;
        } catch (PDOException $e) {
            echo "Erreur lors de la vérification de l'utilisateur : " . $e->getMessage();
            return false;
        }
    }

    static function CheckUser($email, $password)
    {
        $id = UserModel::CheckUserExists($email);
        if ($id != false) {
            $hashedPassword = UserModel::GetHashedPassword($email);
            if (!UserModel::VerifyPassword($password, $hashedPassword)) {
                // echo "mot de passe incorrect";
                return false;
            } else {
                return $id;
            }
        } else {
            // echo "utilisateur introuvable";
            return false;
        }
    }
    static function AddUser($lastname, $firstname, $phone, $email, $password)
    {
        $userExists = UserModel::CheckUserExists($email);
        $connexion = ConnectDB::getConnection();

        if ($userExists) {
            echo "Adresse email déjà utilisée. Veuillez en choisir une autre.";
            return false;
        } else {
            $hashedPassword = UserModel::HashPassword($password);
            $isAdmin = 0;
            try {
                $sql = "INSERT INTO users (Lastname, Firstname,phone, Email, IsAdmin, Password) VALUES ('$lastname', '$firstname','$phone', '$email', '$isAdmin', '$hashedPassword')";
                $connexion->exec($sql);
                return true;
            } catch (PDOException $e) {
                echo "Erreur lors de l'ajout de l'utilisateur : " . $e->getMessage();
                return false;
            }
        }
    }

    static function DeleteUser($email, $password)
    {
        $connexion = ConnectDB::getConnection();

        try {
            $userExists = UserModel::CheckUserExists($email);
            if ($userExists) {
                $hashedPasswordFromDB = UserModel::GetHashedPassword($email);
                if (UserModel::VerifyPassword($password, $hashedPasswordFromDB)) {
                    $sql = "DELETE FROM users WHERE Email = '$email'";
                    $deleted = $connexion->exec($sql);
                    if ($deleted === false) {
                        echo "Erreur lors de la suppression de l'utilisateur";
                        return false;
                    } else {
                        return true;
                    }
                } else {
                    echo "Mot de passe incorrect";
                    return false;
                }
            } else {
                echo "Aucun utilisateur trouvé";
                return false;
            }
        } catch (PDOException $e) {
            echo "Erreur lors de la suppression : " . $e->getMessage();
            return false;
        }
    }
    static function DeleteUserById($userId)
    {
        $connexion = ConnectDB::getConnection();

        $sql = "DELETE FROM users WHERE Email = '$userId'";
        $deleted = $connexion->exec($sql);
        if ($deleted === false) {
            echo "Erreur lors de la suppression de l'utilisateur";
            return false;
        } else {
            return true;
        }
    }

    static function GetUserById($userId)
    {
        $connexion = ConnectDB::getConnection();

        try {
            $sql = "SELECT * FROM users WHERE ID = '$userId'";
            $userData = $connexion->query($sql)->fetch(PDO::FETCH_ASSOC);
            return $userData !== false ? $userData : null;
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération de l'utilisateur : " . $e->getMessage();
            return null;
        }
    }
    static function GetAllUsers()
    {
        $connexion = ConnectDB::getConnection();

        try {
            $sql = "SELECT * FROM users";
            $userList = $connexion->query($sql)->fetchAll(PDO::FETCH_ASSOC);
            return $userList !== false ? $userList : array();
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des utilisateurs : " . $e->getMessage();
            return array();
        }
    }


    public static function updateUserById($newUserData)
    {
        $connexion = ConnectDB::getConnection();
        $query = $connexion->prepare("UPDATE users SET Lastname = ?, Firstname = ?, Phone = ?, Email = ?, IsAdmin = ?, Password = ? WHERE ID = ?");
        $query->execute([$newUserData['lastname'], $newUserData['firstname'], intval($newUserData['phone']), $newUserData['email'], $newUserData['IsAdmin'], $newUserData['password'], $newUserData['ID']]);
        return true;
    }

    static function IsAdmin($id)
    {
        $connexion = ConnectDB::getConnection();

        $sql = "SELECT IsAdmin FROM users WHERE ID = '$id'";
        $isAdmin = $connexion->query($sql)->fetchColumn();
        return $isAdmin !== 1 ? $isAdmin : 0;
    }
}
