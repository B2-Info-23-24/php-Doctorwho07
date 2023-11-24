<?php

namespace Controllers;

use Models\UserModel;

class ConnexionController
{
    public function index()
    {
        $loader = new \Twig\Loader\FilesystemLoader('App/Views/');
        $twig = new \Twig\Environment($loader);
        $template = $twig->load('pages/connexion.html.twig');
        echo $template->display();
    }

    public function traitement()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $checkedSuccessfull = UserModel::CheckUser($email, $password);
            if ($checkedSuccessfull != false) {
                $_SESSION['ID'] = $checkedSuccessfull;
                $_SESSION['user'] = UserModel::GetUserById($_SESSION['ID']);
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
