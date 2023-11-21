<?php

namespace Core;

use Controllers\AccueilController;
use Controllers\AccueilTwig;
use Controllers\ConnexionController;
use Controllers\InscriptionController;
use Controllers\PanelAdminController;
use Controllers\PropertiesController;
use Controllers\PublierController;
use Controllers\SearchController;
use Controllers\UserController;

class Route
{

    static function Route($route)
    {
        $routes = [
            '/accueil' => ['controller' => 'AccueilController', 'method' => 'index'],
            '/' => ['controller' => 'AccueilController', 'method' => 'index'],
            '/inscription' => ['controller' => 'InscriptionController', 'method' => 'index'],
            '/traitement_inscription' => ['controller' => 'InscriptionController', 'method' => 'traitement'],
            '/connexion' => ['controller' => 'ConnexionController', 'method' => 'index'],
            '/traitement_connexion' => ['controller' => 'ConnexionController', 'method' => 'traitement'],
            '/publier' => ['controller' => 'PublierController', 'method' => 'index'],
            '/traitement_publier' => ['controller' => 'PublierController', 'method' => 'traitement'],
            '/PanelUser' => ['controller' => 'PanelUserController', 'method' => 'index'],
            '/PanelAdmin' => ['controller' => 'PanelAdminController', 'method' => 'home'],
            '/admin/users' => ['controller' => 'PanelAdminController', 'method' => 'user'],
            '/admin/properties' => ['controller' => 'PanelAdminController', 'method' => 'properties'],
            '/admin/admin' => ['controller' => 'PanelAdminController', 'method' => 'admin'],
            '/search' => ['controller' => 'SearchController', 'method' => 'index'],
            '/traitement_search' => ['controller' => 'SearchController', 'method' => 'traitement'],
            '/disconnect' => ['controller' => 'UserController', 'method' => 'disconnect'],
            '/delete' => ['controller' => 'UserController', 'method' => 'delete'],
            '/twig' => ['controller' => 'AccueilTwig', 'method' => 'index']

        ];


        if (strpos($route, '/property/') === 0) {
            $propertyId = substr($route, strlen('/property/'));
            $controllerName = 'PropertiesController';
            $methodName = 'showProperty';
            $controller = new $controllerName();
            $controller->$methodName($propertyId);
            return;
        }
        if (strpos($route, '/user/') === 0) {
            $userId = substr($route, strlen('/user/'));
            $controllerName = 'UserController';
            $methodName = 'showUser';
            $controller = new $controllerName();
            $controller->$methodName($userId);
            return;
        }
        if (array_key_exists($route, $routes)) {
            $controllerName = $routes[$route]['controller'];
            $methodName = $routes[$route]['method'];
            $controller = new $controllerName();
            $controller->$methodName();
        } else {
            include(__DIR__ . '/../Views/pages/404.php');
        }
    }
}
