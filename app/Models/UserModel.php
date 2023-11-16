<?php

class UserModel
{
    private $connexion;

    public function __construct()
    {
        $this->connexion = ConnectDB();
    }

    public function HashPassword($password)
    {
        $options = [
            'memory_cost' => 1 << 17,
            'time_cost' => 4,
            'threads' => 2
        ];
        return password_hash($password, PASSWORD_ARGON2ID, $options);
    }

    public function VerifyPassword($password, $hashedPassword)
    {
        return password_verify($password, $hashedPassword);
    }
    public function GetHashedPassword($email)
    {
        try {
            $sql = "SELECT Password FROM users WHERE Email = '$email'";
            $hashedPassword = $this->connexion->query($sql)->fetchColumn();
            return $hashedPassword !== false ? $hashedPassword : null;
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération du mot de passe haché : " . $e->getMessage();
            return null;
        }
    }

    public function CheckUserExists($email)
    {
        try {
            $sql = "SELECT COUNT(*) FROM users WHERE Email = '$email'";
            $result = $this->connexion->query($sql)->fetchColumn();
            return $result > 0;
        } catch (PDOException $e) {
            echo "Erreur lors de la vérification de l'utilisateur : " . $e->getMessage();
            return false;
        }
    }

    public function CheckUser($email, $password)
    {
        $exist = $this->CheckUserExists($email);
        if ($exist == true) {
            $hashedPassword = $this->GetHashedPassword($email);
            if (!$this->VerifyPassword($password, $hashedPassword)) {
                // echo "mot de passe incorrect";
                return false;
            } else {
                $_SESSION['user'] = ['Email' => $email];
                return true;
            }
        } else {
            // echo "utilisateur introuvable";
            return false;
        }
    }

    public function AddUser($lastname, $firstname, $email, $password)
    {
        $userExists = $this->CheckUserExists($email);

        if ($userExists) {
            echo "Adresse email déjà utilisée. Veuillez en choisir une autre.";
            return false;
        } else {
            $hashedPassword = $this->HashPassword($password);
            $isAdmin = 0;
            try {
                $sql = "INSERT INTO users (Lastname, Firstname, Email, IsAdmin, Password) VALUES ('$lastname', '$firstname', '$email', '$isAdmin', '$hashedPassword')";
                $this->connexion->exec($sql);
                return true;
            } catch (PDOException $e) {
                echo "Erreur lors de l'ajout de l'utilisateur : " . $e->getMessage();
                return false;
            }
        }
    }

    public function DeleteUser($email, $password)
    {
        try {
            $userExists = $this->CheckUserExists($email);
            if ($userExists) {
                $hashedPasswordFromDB = $this->GetHashedPassword($email);
                if ($this->VerifyPassword($password, $hashedPasswordFromDB)) {
                    $sql = "DELETE FROM users WHERE Email = '$email'";
                    $deleted = $this->connexion->exec($sql);
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
}





// update user

// get user

// get all users

// get user by id

// get user by email