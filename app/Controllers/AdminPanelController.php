<?php

namespace Controllers;

use Models\UserModel;

class AdminPanelController
{
    public function home()
    {
        $loader = new \Twig\Loader\FilesystemLoader('App/Views/');
        $twig = new \Twig\Environment($loader);
        $template = $twig->load('pages/AdminPanel.html.twig');
        echo $template->display(
            [
                'Title' => "Panneau d'administration",
            ]
        );
    }
    public function users()
    {
        $loader = new \Twig\Loader\FilesystemLoader('App/Views/');
        $twig = new \Twig\Environment($loader);
        $template = $twig->load('pages/AdminUser.html.twig');
        echo $template->display(
            [
                'Title' => "Liste des utilisateurs",
            ]
        );
    }
    public function properties()
    {
        $loader = new \Twig\Loader\FilesystemLoader('App/Views/');
        $twig = new \Twig\Environment($loader);
        $template = $twig->load('pages/AdminProperties.html.twig');
        echo $template->display(
            [
                'Title' => "Liste des Logements",
            ]
        );
    }
}
