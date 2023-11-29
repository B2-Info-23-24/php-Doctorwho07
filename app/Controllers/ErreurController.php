<?php

namespace Controllers;

class ErreurController
{
    public function index()
    {
        $loader = new \Twig\Loader\FilesystemLoader('App/Views/');
        $twig = new \Twig\Environment($loader);
        $template = $twig->load('pages/404.html.twig');
        echo $template->display();
    }
}
