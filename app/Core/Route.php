<?php
function Route($route)
{
    $routes = [
        '/accueil' => ['controller' => 'AccueilController', 'method' => 'index'],
        '/inscription' => ['controller' => 'InscriptionController', 'method' => 'index'],
        '/traitement_inscription' => ['controller' => 'InscriptionController', 'method' => 'traitement'],
        '/connexion' => ['controller' => 'ConnexionController', 'method' => 'index'],
        '/traitement_connexion' => ['controller' => 'ConnexionController', 'method' => 'traitement'],
        '/publier' => ['controller' => 'PublierController', 'method' => 'index'],
        '/traitement_publier' => ['controller' => 'PublierController', 'method' => 'traitement'],
        '/PanelUser' => ['controller' => 'PanelUserController', 'method' => 'index'],
        '/PanelAdmin' => ['controller' => 'PanelAdminController', 'method' => 'index']
    ];
    if (array_key_exists($route, $routes)) {
        $controllerName = $routes[$route]['controller'];
        $methodName = $routes[$route]['method'];
        $controller = new $controllerName();
        $controller->$methodName();
    } else {
        include(__DIR__ . '/../Views/pages/404.php');
    }
}
