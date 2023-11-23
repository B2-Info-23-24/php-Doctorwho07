<?php

namespace Controllers;

use Models\UserModel;

class PanelUserController
{
    public function Modify()
    {
        require_once(dirname(__DIR__) . '/Views/userModif.php');
    }
    public function History()
    {
        require_once(dirname(__DIR__) . '/Views/history.php');
    }
    public function Reservation()
    {
        require_once(dirname(__DIR__) . '/Views/reservation.php');
    }
    public function Panel()
    {
        require_once(dirname(__DIR__) . '/Views/panel.php');
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
