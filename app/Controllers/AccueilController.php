<?php

namespace Controllers;

use Models\PropertiesModel;
use Models\UserModel;


class AccueilController
{
    public function index()
    {
        $loader = new \Twig\Loader\FilesystemLoader('App/Views/');
        $twig = new \Twig\Environment($loader);
        $template = $twig->load('pages/accueil.html.twig');
        echo $template->display(
            [
                'title' => "Home",
                'properties' => PropertiesModel::GetAllProperties(),
                'users' => UserModel::GetAllUsers(),
            ]
        );
    }
}
