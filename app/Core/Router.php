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
            '/Accueil' => ['controller' => $Accueil, 'method' => 'index'],
            '/' => ['controller' => $Accueil, 'method' => 'index'],
            //---------- Inscription ---------//
            '/Inscription' => ['controller' => $Inscription, 'method' => 'index'],
            '/Traitement_inscription' => ['controller' => $Inscription, 'method' => 'traitement'],
            //---------- Connexion ---------//
            '/Connexion' => ['controller' => $Connexion, 'method' => 'index'],
            '/Traitement_connexion' => ['controller' => $Connexion, 'method' => 'traitement'],
            //---------- Disconnect ---------//
            '/Deconnexion' => ['controller' => $User, 'method' => 'disconnect'],
            //---------- User Account ---------//
            '/Suppression' => ['controller' => $User, 'method' => 'delete'],
            '/Utilisateur' => ['controller' => $User, 'method' => 'home'],
            '/Modifier' => ['controller' => $User, 'method' => 'Modify'],
            '/Favoris' => ['controller' => $Favorites, 'method' => 'favorite'],
            '/Retirer_Favorite' => ['controller' => $Favorites, 'method' => 'revokeFavorite'],
            '/Logements_Favoris' => ['controller' => $Favorites, 'method' => 'favoriteProperty'],
            '/Reservation' => ['controller' => $Reservation, 'method' => 'Reservation'],
            '/Reservations' => ['controller' => $Reservation, 'method' => 'ReservationsProperty'],
            '/Publier_avis' => ['controller' => $Review, 'method' => 'PublishReview'],

            //---------- Admin Account ---------//
            '/Admin/Accueil' => ['controller' => $PanelAdmin, 'method' => 'home'],
            '/Admin/Utilisateurs' => ['controller' => $PanelAdmin, 'method' => 'users'],
            '/Admin/Admin' => ['controller' => $PanelAdmin, 'method' => 'admin'],
            '/Admin/Logements' => ['controller' => $PanelAdmin, 'method' => 'properties'],
            '/Admin/Reservations' => ['controller' => $PanelAdmin, 'method' => 'reservation'],
            '/Admin/Publier_Logement' => ['controller' => $Publier, 'method' => 'addProperty'],
            '/Admin/Ajouter_Utilisateur' => ['controller' => $Publier, 'method' => 'addUser'],
            '/Traitement_logement' => ['controller' => $Publier, 'method' => 'traitementProperty'],
            '/Traitement_utilisateur' => ['controller' => $Publier, 'method' => 'traitementUser'],
            '/Admin/Ajouter_admin' => ['controller' => $PanelAdmin, 'method' => 'grantAdminRole'],
            '/Admin/Supprimer_admin' => ['controller' => $PanelAdmin, 'method' => 'revokeAdminRole'],
            '/Admin/Supprimer_utilisateur' => ['controller' => $PanelAdmin, 'method' => 'deleteUsers'],
            '/Admin/Supprimer_logement' => ['controller' => $PanelAdmin, 'method' => 'deleteProperty'],
            '/Recherche' => ['controller' => $Search, 'method' => 'index'],
            '/Traitement_recherche' => ['controller' => $Search, 'method' => 'traitement']
        ];
        if (strpos($route, '/Admin/') === 0 && !isset($_SESSION['user']['IsAdmin'])) {
            header("Location: /");
            exit;
        }
        if (($route == "/Utilisateur") && (isset($_SESSION['user']) == False)) {
            $Inscription->index();
            exit;
        }
        if (strpos($route, '/Logements/') === 0) {
            $propertyId = substr($route, strlen('/Logements/'));
            $Properties->showProperty($propertyId);
            return;
        }
        if (strpos($route, '/Utilisateur/') === 0) {
            $userId = substr($route, strlen('/Utilisateur/'));
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
