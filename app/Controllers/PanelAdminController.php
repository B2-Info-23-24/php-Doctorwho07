<?php

namespace Controllers;

use Models\UserModel;

class PanelAdminController
{
    public function home()
    {
        require_once(dirname(__DIR__) . '/Views/AdminPanel.php');
    }
    public function user()
    {
        require_once(dirname(__DIR__) . '/Views/user.php');
    }
    public function properties()
    {
        require_once(dirname(__DIR__) . '/Views/properties.php');
    }
    public function admin()
    {
        require_once(dirname(__DIR__) . '/Views/admin.php');
    }
    public function traitement()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $checkedSuccessfull = UserModel::CheckUser($email, $password);
            if ($checkedSuccessfull == true) {
                header('Location: accueil');
                exit();
            } else {
                //echo "Email ou Mot de passe incorrect";
                header('Location: /connexion');
            }
        } else {
            header('Location: /inscription');
            exit();
        }
    }
}
