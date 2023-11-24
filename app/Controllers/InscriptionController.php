<?php

namespace Controllers;

use Models\UserModel;

class InscriptionController
{
    public function index()
    {
        $loader = new \Twig\Loader\FilesystemLoader('App/Views/');
        $twig = new \Twig\Environment($loader);
        $template = $twig->load('pages/inscription.html.twig');
        echo $template->display();
    }

    public function traitement()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $lastname = $_POST['lastname'];
            $firstname = $_POST['firstname'];
            $phone = $_POST['phone'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            UserModel::AddUser($lastname, $firstname, $phone, $email, $password);
            $checkedSuccessfull = UserModel::CheckUser($email, $password);
            if ($checkedSuccessfull != false) {
                $_SESSION['ID'] = $checkedSuccessfull;
                $_SESSION['user'] = UserModel::GetUserById($_SESSION['ID']);
                header('Location: accueil');
                exit();
            } else {
                echo "Erreur lors de l'inscription.";
            }
        } else {
            header('Location: inscription');
            exit();
        }
    }
}
