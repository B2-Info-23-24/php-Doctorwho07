<?php

namespace Controllers;

use Models\PropertiesModel;
use Models\UserModel;


class AccueilController
{
    public function index()
    {
        if (isset($_SESSION['user'])) {
            $users = UserModel::GetAllUsers();
            $user = $_SESSION['user']['IsAdmin'];
        } else {
            $users = 0;
            $user = 0;
        }
        $loader = new \Twig\Loader\FilesystemLoader('App/Views/');
        $twig = new \Twig\Environment($loader);
        $template = $twig->load('pages/accueil.html.twig');
        echo $template->display(
            [
                'title' => "Home",
                'properties' => PropertiesModel::GetAllProperties(),
                'users' => $users,
                'user' =>  $user,
            ]
        );
    }
}
