<?php

namespace Core;

use Controllers\HomeController, Controllers\LoginController, Controllers\RegisterController, Controllers\AdminPanelController, Controllers\PublierController, Controllers\SearchController, Controllers\UserController, Controllers\ErreurController, Controllers\FavoritesController, Controllers\PropertiesController, Controllers\ReviewsController, Controllers\ReservationController;

class Router
{
    static function Router($route)
    {
        session_start();

        $Accueil = new HomeController;
        $Connexion = new LoginController;
        $Inscription = new RegisterController;
        $PanelAdmin = new AdminPanelController;
        $Publier = new PublierController;
        $Search = new SearchController;
        $User = new UserController;
        $ControllerErreur = new ErreurController;
        $Properties = new PropertiesController;
        $Favorites = new FavoritesController;
        $Review = new ReviewsController;
        $Reservation = new ReservationController;

        $routes = [
            //---------- Accueil ---------//
            '/home' => ['controller' => $Accueil, 'method' => 'index'],
            '/' => ['controller' => $Accueil, 'method' => 'index'],
            //---------- Inscription ---------//
            '/register' => ['controller' => $Inscription, 'method' => 'index'],
            '/register_push' => ['controller' => $Inscription, 'method' => 'traitement'],
            //---------- Connexion ---------//
            '/login' => ['controller' => $Connexion, 'method' => 'index'],
            '/login_post' => ['controller' => $Connexion, 'method' => 'traitement'],
            //---------- Disconnect ---------//
            '/disconnect' => ['controller' => $User, 'method' => 'disconnect'],
            //---------- User Account ---------//
            '/delete' => ['controller' => $User, 'method' => 'delete'],
            '/user' => ['controller' => $User, 'method' => 'home'],
            '/modify' => ['controller' => $User, 'method' => 'modify'],
            '/favorite' => ['controller' => $Favorites, 'method' => 'favorite'],
            '/favorite_remove' => ['controller' => $Favorites, 'method' => 'revokeFavorite'],
            '/favorite_property' => ['controller' => $Favorites, 'method' => 'favoriteProperty'],
            '/order' => ['controller' => $Reservation, 'method' => 'reservation'],
            '/orders' => ['controller' => $Reservation, 'method' => 'reservationsProperty'],
            '/review_push' => ['controller' => $Review, 'method' => 'publishReview'],

            //---------- Admin Account ---------//
            '/admin/home' => ['controller' => $PanelAdmin, 'method' => 'home'],
            '/admin/users' => ['controller' => $PanelAdmin, 'method' => 'users'],
            '/admin/admin' => ['controller' => $PanelAdmin, 'method' => 'admin'],
            '/admin/property' => ['controller' => $PanelAdmin, 'method' => 'properties'],
            '/admin/orders' => ['controller' => $PanelAdmin, 'method' => 'reservation'],
            '/admin/property_publish' => ['controller' => $Publier, 'method' => 'addProperty'],
            '/admin/user_add' => ['controller' => $Publier, 'method' => 'addUser'],
            '/property_push' => ['controller' => $Publier, 'method' => 'traitementProperty'],
            '/user_push' => ['controller' => $Publier, 'method' => 'traitementUser'],
            '/admin/admin_add' => ['controller' => $PanelAdmin, 'method' => 'grantAdminRole'],
            '/admin/delete_admin' => ['controller' => $PanelAdmin, 'method' => 'revokeAdminRole'],
            '/admin/user_delete' => ['controller' => $PanelAdmin, 'method' => 'deleteUsers'],
            '/admin/property_delete' => ['controller' => $PanelAdmin, 'method' => 'deleteProperty'],
            '/search' => ['controller' => $Search, 'method' => 'index'],
            '/search_push' => ['controller' => $Search, 'method' => 'traitement']
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
