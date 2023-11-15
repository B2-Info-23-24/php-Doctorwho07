<?php


function Route($route)
{
    echo "route";
    switch ($route) {
        case '/accueil':
            echo "accueil";
            // $controller = new AccueilController();
            // $controller->index();
            break;

        case '/inscription':
            echo "bonjour";
            $controller = new InscriptionController();
            $controller->index();
            break;

        case '/traitement_inscription':
            $controller = new InscriptionController();
            $controller->traitement();
            break;

        case '/connexion':
            $controller = new ConnexionController();
            $controller->index();
            break;

        case '/traitement_connexion':
            $controller = new ConnexionController();
            $controller->traitement();
            break;

        default:
            include(__DIR__ . '/../Views/pages/404.php');
            break;
    }
}