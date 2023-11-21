<?php

namespace Controllers;

class AccueilTwig
{
    public function index()
    {
        $loader = new \Twig\Loader\FilesystemLoader("App/Views/pages/");
        $twig = new \Twig\Environment($loader);
        $template = $twig->load("Accueil.twig");
        $_SESSION['isAdmin'] = 1;
        echo $template->render(array(
            "id" => "bob",
            "isAdmin" => $_SESSION['isAdmin'],
        ));
    }
}
