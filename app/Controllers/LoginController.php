<?php

namespace Controllers;

use Models\UserModel;

class LoginController
{
    static public function index()
    {
        $loader = new \Twig\Loader\FilesystemLoader('App/Views/');
        $twig = new \Twig\Environment($loader);
        $template = $twig->load('pages/login.html.twig');
        echo $template->display();
    }

    static public function push()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $checkedSuccessfull = UserModel::CheckUser($email, $password);
            if ($checkedSuccessfull != false) {
                $_SESSION['ID'] = $checkedSuccessfull;
                $_SESSION['user'] = UserModel::GetUserById($_SESSION['ID']);
                header('Location: /');
                exit();
            } else {
                header('Location: login');
            }
        } else {
            header('Location: register');
            exit();
        }
    }
    static public function isConnected()
    {
        if (isset($_SESSION['user'])) {
            return true;
        } else {
            return false;
        }
    }
}
