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
use Controllers\FavoritesController;
use Controllers\PropertiesController;
use Controllers\ReviewsController;
use Controllers\ReservationController;



class Route
{
    static function Route($route)
    {
        session_start();

        $Accueil = new AccueilController;
        $Connexion = new ConnexionController;
        $Inscription = new InscriptionController;
        $PanelAdmin = new AdminPanelController;
        $Publier = new PublierController;
        $Search = new SearchController;
        $User = new UserController;
        $ControllerErreur = new ControllerErreur;
        $Properties = new PropertiesController;
        $Favorites = new FavoritesController;
        $Review = new ReviewsController;
        $Reservation = new ReservationController;

        $routes = [
            //---------- Accueil ---------//
            '/accueil' => ['controller' => $Accueil, 'method' => 'index'],
            '/' => ['controller' => $Accueil, 'method' => 'index'],
            //---------- Inscription ---------//
            '/inscription' => ['controller' => $Inscription, 'method' => 'index'],
            '/traitement_inscription' => ['controller' => $Inscription, 'method' => 'traitement'],
            //---------- Connexion ---------//
            '/connexion' => ['controller' => $Connexion, 'method' => 'index'],
            '/traitement_connexion' => ['controller' => $Connexion, 'method' => 'traitement'],
            //---------- Disconnect ---------//
            '/disconnect' => ['controller' => $User, 'method' => 'disconnect'],
            //---------- User Account ---------//
            '/delete' => ['controller' => $User, 'method' => 'delete'],
            '/user' => ['controller' => $User, 'method' => 'home'],
            '/modify' => ['controller' => $User, 'method' => 'Modify'],
            '/favorite' => ['controller' => $Favorites, 'method' => 'favorite'],
            '/revokeFavorite' => ['controller' => $Favorites, 'method' => 'revokeFavorite'],
            '/favoriteProperty' => ['controller' => $Favorites, 'method' => 'favoriteProperty'],
            '/reservation' => ['controller' => $Reservation, 'method' => 'Reservation'],
            '/orders' => ['controller' => $Reservation, 'method' => 'ReservationsProperty'],


            //---------- Admin Account ---------//
            '/admin/home' => ['controller' => $PanelAdmin, 'method' => 'home'],
            '/admin/users' => ['controller' => $PanelAdmin, 'method' => 'users'],
            '/admin/admin' => ['controller' => $PanelAdmin, 'method' => 'admin'],
            '/admin/properties' => ['controller' => $PanelAdmin, 'method' => 'properties'],
            '/admin/reservation' => ['controller' => $PanelAdmin, 'method' => 'reservation'],
            '/admin/addProperty' => ['controller' => $Publier, 'method' => 'addProperty'],
            '/admin/addUser' => ['controller' => $Publier, 'method' => 'addUser'],
            '/traitement_property' => ['controller' => $Publier, 'method' => 'traitementProperty'],
            '/traitement_user' => ['controller' => $Publier, 'method' => 'traitementUser'],
            '/admin/grantAdminRole' => ['controller' => $PanelAdmin, 'method' => 'grantAdminRole'],
            '/admin/revokeAdminRole' => ['controller' => $PanelAdmin, 'method' => 'revokeAdminRole'],
            '/admin/deleteUsers' => ['controller' => $PanelAdmin, 'method' => 'deleteUsers'],
            '/admin/deleteProperties' => ['controller' => $PanelAdmin, 'method' => 'deleteProperty'],
            '/search' => ['controller' => $Search, 'method' => 'index'],
            '/traitement_search' => ['controller' => $Search, 'method' => 'traitement'],
            '/publishReview' => ['controller' => $Review, 'method' => 'PublishReview']
        ];
        if (strpos($route, '/admin/') === 0 && !isset($_SESSION['user']['IsAdmin'])) {
            header("Location: /");
            exit;
        }
        if (($route == "/user") && (isset($_SESSION['user']) == False)) {
            $Inscription->index();
            exit;
        }
        if (strpos($route, '/property/') === 0) {
            $propertyId = substr($route, strlen('/property/'));
            $Properties->showProperty($propertyId);
            return;
        }
        if (strpos($route, '/user/') === 0) {
            $userId = substr($route, strlen('/user/'));
            $User->showUser($userId);
            return;
        }
        if (array_key_exists($route, $routes)) {
            $methodName = $routes[$route]['method'];
            $controller = $routes[$route]['controller'];
            $controller->$methodName();
        } else {
            $ControllerErreur->index();
        }
        // foreach ($routes as $routePattern => $routeConfig) {
        //     if ($route === $routePattern) {
        //         $controller = $routeConfig['controller'];
        //         $method = $routeConfig['method'];

        //         // Pour les routes /admin/grantAdminRole et /admin/revokeAdminRole
        //         if ($route === '/admin/grantAdminRole') {
        //             $userID = intval($_POST['userID'] ?? 0);
        //             $controller->$method($userID);
        //         } elseif ($route === '/admin/revokeAdminRole') {
        //             $userID = intval($_POST['userID'] ?? 0);
        //             $controller->$method($userID);
        //         } else {
        //             $controller->$method();
        //         }
        //         return;
        //     }
        // }

        // $ControllerErreur->index();
    }
}
