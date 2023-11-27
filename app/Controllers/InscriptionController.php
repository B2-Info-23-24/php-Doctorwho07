<?php

namespace Controllers;

use Models\UserModel;
use Handler\EmailHandler;

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
            header('Location: home');

            exit();
        } else {
            header('Location: inscription');
            exit();
        }
    }
}
