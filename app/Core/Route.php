<?php

namespace Core;

use Controllers\HomeController;
use Controllers\AdminPanelController;
use Controllers\PublishController;
use Controllers\UserController;
use Controllers\ControllerErreur;
use Controllers\FavoritesController;
use Controllers\LoginController;
use Controllers\PropertiesController;
use Controllers\RegisterController;
use Controllers\ReviewsController;
use Controllers\OrderController;
use Controllers\EquipmentController;
use Controllers\ServicesController;



class Route
{
    static function Route($route)
    {
        session_start();


        $Home = new HomeController;
        $Login = new LoginController;
        $Register = new RegisterController;
        $PanelAdmin = new AdminPanelController;
        $Publish = new PublishController;
        $User = new UserController;
        $ControllerErreur = new ControllerErreur;
        $Properties = new PropertiesController;
        $Favorites = new FavoritesController;
        $Review = new ReviewsController;
        $Order = new OrderController;
        $AdminEquipment = new EquipmentController;
        $AdminService = new ServicesController;
        $Filter = new HomeController;


        $routes = [
            //---------- Accueil ---------//
            '/home' => ['controller' => $Home, 'method' => 'index'],
            '/' => ['controller' => $Home, 'method' => 'index'],
            //---------- Inscription ---------//
            '/register' => ['controller' => $Register, 'method' => 'index'],
            '/register_post' => ['controller' => $Register, 'method' => 'push'],
            //---------- Connexion ---------//
            '/login' => ['controller' => $Login, 'method' => 'index'],
            '/login_push' => ['controller' => $Login, 'method' => 'push'],
            //---------- Disconnect ---------//
            '/disconnect' => ['controller' => $User, 'method' => 'disconnect'],
            //---------- User Account ---------//
            '/delete' => ['controller' => $User, 'method' => 'delete'],
            '/user' => ['controller' => $User, 'method' => 'home'],
            '/modify' => ['controller' => $User, 'method' => 'Modify'],
            '/favorite' => ['controller' => $Favorites, 'method' => 'favorite'],
            '/revokeFavorite' => ['controller' => $Favorites, 'method' => 'revokeFavorite'],
            '/favoriteProperty' => ['controller' => $Favorites, 'method' => 'favoriteProperty'],
            '/order' => ['controller' => $Order, 'method' => 'reservation'],
            '/orders' => ['controller' => $Order, 'method' => 'reservationsProperty'],
            '/review_push' => ['controller' => $Review, 'method' => 'publishReview'],

            //---------- Admin Account ---------//
            '/admin/home' => ['controller' => $PanelAdmin, 'method' => 'home'],
            '/admin/users' => ['controller' => $PanelAdmin, 'method' => 'users'],
            '/admin/admin' => ['controller' => $PanelAdmin, 'method' => 'admin'],
            '/admin/properties' => ['controller' => $PanelAdmin, 'method' => 'properties'],
            '/admin/reservation' => ['controller' => $PanelAdmin, 'method' => 'reservation'],
            '/admin/addProperty' => ['controller' => $Publish, 'method' => 'addProperty'],
            '/admin/addUser' => ['controller' => $Publish, 'method' => 'addUser'],
            '/property_push' => ['controller' => $Publish, 'method' => 'pushProperty'],
            '/user_push' => ['controller' => $Publish, 'method' => 'pushUser'],
            '/admin/grantAdminRole' => ['controller' => $PanelAdmin, 'method' => 'grantAdminRole'],
            '/admin/revokeAdminRole' => ['controller' => $PanelAdmin, 'method' => 'revokeAdminRole'],
            '/admin/deleteUsers' => ['controller' => $PanelAdmin, 'method' => 'deleteUsers'],
            '/admin/deleteProperties' => ['controller' => $PanelAdmin, 'method' => 'deleteProperty'],
            '/publishReview' => ['controller' => $Review, 'method' => 'PublishReview'],
            '/admin/equipment' => ['controller' => $AdminEquipment, 'method' => 'adminEquipment'],
            '/admin/addEquipment' => ['controller' => $AdminEquipment, 'method' => 'addEquipment'],
            '/admin/deleteEquipment/{equipmentID}' => ['controller' => $AdminEquipment, 'method' => 'deleteEquipment'],
            '/admin/updateEquipment/{equipmentID}' => ['controller' => $AdminEquipment, 'method' => 'updateEquipment'],
            '/admin/services' => ['controller' => $AdminService, 'method' => 'index'],
            '/admin/addService' => ['controller' => $AdminService, 'method' => 'addService'],
            '/admin/deleteService/{serviceID}' => ['controller' => $AdminService, 'method' => 'deleteService'],
            '/admin/updateService/{serviceID}' => ['controller' => $AdminService, 'method' => 'updateService']
        ];
        if (strpos($route, '/admin/') === 0 && !isset($_SESSION['user']['IsAdmin'])) {
            header("Location: /");
            exit;
        }
        if (($route == "/user") && (isset($_SESSION['user']) == False)) {
            $Register->index();
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
    }
}
