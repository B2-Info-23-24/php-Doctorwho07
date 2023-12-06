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
            $errorMessages = [];
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errorMessages[] = "Adresse e-mail invalide";
            }
            if (empty($firstname)) {
                $errorMessages[] = "Veuillez entrer votre prénom.";
            }
            if (empty($lastname)) {
                $errorMessages[] = "Veuillez entrer votre nom.";
            }
            if (empty($phone) || !preg_match('/^\d{10}$/', $phone)) {
                $errorMessages[] = "Veuillez entrer un numéro de téléphone valide.";
            }
            if (strlen($password) < 8) {
                $errorMessages[] = "Le mot de passe doit contenir au moins 8 caractères.";
            }
            if (!empty($errorMessages)) {
                $loader = new \Twig\Loader\FilesystemLoader('App/Views/');
                $twig = new \Twig\Environment($loader);
                $template = $twig->load('pages/register.html.twig');
                echo $template->render(['errors' => $errorMessages]);
                exit();
            }
            UserModel::AddUser($lastname, $firstname, $phone, $email, $password);
            $checkedSuccessfull = UserModel::checkUser($email, $password);

            if ($checkedSuccessfull != false) {
                $_SESSION['ID'] = $checkedSuccessfull;
                $_SESSION['user'] = UserModel::getUserById($_SESSION['ID']);
                header('Location: /');
                exit();
            } else {
                header('Location: login');
                exit();
            }
        } else {
            header('Location: register');
            exit();
        }
    }
}
