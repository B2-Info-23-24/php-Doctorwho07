<?php

namespace Controllers;

use Models\UserModel;

class RegisterController
{
    public function index()
    {
        $loader = new \Twig\Loader\FilesystemLoader('App/Views/');
        $twig = new \Twig\Environment($loader);
        $template = $twig->load('pages/register.html.twig');
        echo $template->display();
    }

    public function push()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $lastname = $_POST['lastname'];
            $firstname = $_POST['firstname'];
            $phone = $_POST['phone'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            UserModel::createUser($lastname, $firstname, $phone, $email, $password);
            $checkedSuccessfull = UserModel::checkUser($email, $password);
            if ($checkedSuccessfull != false) {
                $_SESSION['ID'] = $checkedSuccessfull;
                $_SESSION['user'] = UserModel::getUserById($_SESSION['ID']);
                header('Location: /');
                exit();
            } else {
                header('Location: login');
                //echo "Email ou Mot de passe incorrect";
            }

            exit();
        } else {
            header('Location: register');
            exit();
        }
    }
}
