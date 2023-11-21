<?php

namespace Controllers;

use Models\UserModel;

class ConnexionController
{
    public function index()
    {
        require_once(dirname(__DIR__) . '/Views/connexion.php');
    }

    public function traitement()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $checkedSuccessfull = UserModel::CheckUser($email, $password);
            if ($checkedSuccessfull != false) {
                $_SESSION['ID'] = $checkedSuccessfull;
                $_SESSION['isAdmin'] = UserModel::IsAdmin($_SESSION['ID']);
                header('Location: accueil');
                exit();
            } else {
                header('Location: connexion');
                //echo "Email ou Mot de passe incorrect";
            }
        } else {
            header('Location: inscription');
            exit();
        }
    }
}
