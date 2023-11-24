<?php

namespace Core;

use Controllers\AccueilController;
use Controllers\ConnexionController;
use Controllers\InscriptionController;
use Controllers\AdminPanelController;
use Controllers\PublierController;
use Controllers\SearchController;
use Controllers\UserController;
use Controllers\ControllerErreur;
use Controllers\PropertiesController;



class Route
{
    static function Route($route)
    {
        session_start();


        $AccueilController = new AccueilController;
        $ConnexionController = new ConnexionController;
        $InscriptionController = new InscriptionController;
        $PanelAdminController = new AdminPanelController;
        $PublierController = new PublierController;
        $SearchController = new SearchController;
        $UserController = new UserController;
        $ControllerErreur = new ControllerErreur;
        $PropertiesController = new PropertiesController;

        $routes = [
            //---------- Accueil ---------//
            '/accueil' => ['controller' => $AccueilController, 'method' => 'index'],
            '/' => ['controller' => $AccueilController, 'method' => 'index'],
            //---------- Inscription ---------//
            '/inscription' => ['controller' => $InscriptionController, 'method' => 'index'],
            '/traitement_inscription' => ['controller' => $InscriptionController, 'method' => 'traitement'],
            //---------- Connexion ---------//
            '/connexion' => ['controller' => $ConnexionController, 'method' => 'index'],
            '/traitement_connexion' => ['controller' => $ConnexionController, 'method' => 'traitement'],
            //---------- Disconnect ---------//
            '/disconnect' => ['controller' => $UserController, 'method' => 'disconnect'],
            //---------- User Account ---------//
            '/delete' => ['controller' => $UserController, 'method' => 'delete'],
            '/user' => ['controller' => $UserController, 'method' => 'home'],
            '/modify' => ['controller' => $UserController, 'method' => 'Modify'],


            //---------- Admin Account ---------//
            '/admin/home' => ['controller' => $PanelAdminController, 'method' => 'home'],
            '/admin/users' => ['controller' => $PanelAdminController, 'method' => 'users'],
            '/admin/properties' => ['controller' => $PanelAdminController, 'method' => 'properties'],
            '/admin/reservation' => ['controller' => $PanelAdminController, 'method' => 'reservation'],
            '/admin/publish' => ['controller' => $PublierController, 'method' => 'index'],
            '/traitement_publier' => ['controller' => $PublierController, 'method' => 'traitement'],



            '/search' => ['controller' => $SearchController, 'method' => 'index'],
            '/traitement_search' => ['controller' => $SearchController, 'method' => 'traitement']
        ];
        if (strpos($route, '/admin/') === 0 && !isset($_SESSION['user']['IsAdmin'])) {
            header("Location: /");
            exit;
        }
        if (($route == "/user") && (isset($_SESSION['user']) == False)) {
            $InscriptionController->index();
            exit;
        }
        if (strpos($route, '/property/') === 0) {
            $propertyId = substr($route, strlen('/property/'));
            $PropertiesController->showProperty($propertyId);
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
            $methodName = $routes[$route]['method'];
            $controller = $routes[$route]['controller'];
            $controller->$methodName();
        } else {
            $ControllerErreur->index();
        }
    }
}
