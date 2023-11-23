<?php

namespace Controllers;

class User
{
    public function index()
    {
        $loader = new \Twig\Loader\FilesystemLoader('App/Views/');
        $twig = new \Twig\Environment($loader);
        $template = $twig->load('pages/user.html.twig');
        echo $template->display();
    }
}
