<?php

namespace Models;

use PDOException, PDO, Exception, Models\Security;

class UserModel
{
    static function createUser($lastname, $firstname, $phone, $email, $password)
    {
        $userExists = self::checkUserExists($email);
        $connexion = ConnectDB::getConnection();

        if ($userExists) {
            throw new Exception("L'utilisateur existe déjà.");
        } else {
            $hashedPassword = Security::hashPassword($password);
            $isAdmin = 0;

            try {
                $sql = "INSERT INTO users (Lastname, Firstname, phone, Email, IsAdmin, Password) VALUES ('$lastname', '$firstname','$phone', '$email', '$isAdmin', '$hashedPassword')";
                $connexion->exec($sql);
                return true;
            } catch (PDOException $e) {
                throw new Exception("Erreur lors de la création de l'utilisateur.");
            }
        }
    }

    static function deleteUser($email, $password)
    {
        $connexion = ConnectDB::getConnection();

        try {
            $userExists = self::checkUserExists($email);
            if ($userExists) {
                $hashedPasswordFromDB = Security::getHashedPasswordByEmail($email);
                if (Security::verifyPassword($password, $hashedPasswordFromDB)) {
                    $sql = "DELETE FROM users WHERE Email = '$email'";
                    $deleted = $connexion->exec($sql);
                    return $deleted !== false;
                } else {
                    throw new Exception("Mot de passe incorrect.");
                }
            } else {
                throw new Exception("L'utilisateur n'existe pas.");
            }
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la suppression de l'utilisateur.");
        }
    }

    static function deleteUserById($userId)
    {
        $connexion = ConnectDB::getConnection();

        $sql = "DELETE FROM users WHERE Email = '$userId'";
        $deleted = $connexion->exec($sql);
        return $deleted !== false;
    }

    static function getUserById($userId)
    {
        $connexion = ConnectDB::getConnection();

        try {
            $sql = "SELECT * FROM users WHERE ID = '$userId'";
            $userData = $connexion->query($sql)->fetch(PDO::FETCH_ASSOC);
            return $userData !== false ? $userData : null;
        } catch (PDOException $e) {
            return null;
        }
    }
    static function GetUserByEmail($email)
    {
        $connexion = ConnectDB::getConnection();
        try {
            $sql = "SELECT * FROM users WHERE Email = ?";
            $stmt = $connexion->prepare($sql);
            $stmt->execute([$email]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération de l'utilisateur par email : " . $e->getMessage();
            return null;
        }
    }

    static function getAllUsers()
    {
        $connexion = ConnectDB::getConnection();

        try {
            $sql = "SELECT * FROM users";
            $userList = $connexion->query($sql)->fetchAll(PDO::FETCH_ASSOC);
            if ($userList === false) {
                throw new Exception("Erreur lors de la récupération des utilisateurs.");
            }
            return $userList;
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération des utilisateurs.");
        }
    }


    static function updateUserById($userId, $newUserData)
    {
        $connexion = ConnectDB::getConnection();

        try {
            $currentUserData = self::getUserById($userId);
            if ($currentUserData) {
                foreach ($newUserData as $key => $value) {
                    $currentUserData[$key] = $value;
                }
                $sql = "UPDATE users SET ";
                foreach ($currentUserData as $key => $value) {
                    $sql .= "$key = '$value', ";
                }
                $sql = rtrim($sql, ", ");
                $sql .= " WHERE ID = '$userId'";
                $affectedRows = $connexion->exec($sql);
                return $affectedRows !== false;
            } else {
                throw new Exception("Utilisateur non trouvé.");
            }
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la mise à jour de l'utilisateur.");
        }
    }

    static function checkUserExists($email)
    {
        $connexion = ConnectDB::getConnection();

        try {
            $sql = "SELECT COUNT(*) FROM users WHERE Email = '$email'";
            $result = $connexion->query($sql)->fetchColumn();
            return $result > 0;
        } catch (PDOException $e) {
            return false;
        }
    }

    static function checkUser($email, $password)
    {
        $exist = self::checkUserExists($email);
        if ($exist == true) {
            $hashedPassword = Security::getHashedPasswordByEmail($email);
            if (!Security::verifyPassword($password, $hashedPassword)) {
                return false;
            } else {
                $_SESSION['user'] = ['Email' => $email];
                return true;
            }
        } else {
            return false;
        }
    }
    static function DeleteUserByEmail($userId)
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
}
