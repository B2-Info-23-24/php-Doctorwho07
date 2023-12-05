<?php

namespace Core;

use Controllers\HomeController, Controllers\AdminPanelController, Controllers\PublishController, Controllers\UserController, Controllers\ControllerErreur, Controllers\FavoritesController, Controllers\LoginController, Controllers\PropertiesController, Controllers\RegisterController, Controllers\ReviewsController, Controllers\OrderController, Controllers\EquipmentController, Controllers\ServicesController, Controllers\TypeController;

class Routes
{
    public static function getRoutes()
    {
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
        $AdminType = new TypeController;
        return [
            //---------- Accueil ---------//
            '/home' => ['controller' => $Home, 'method' => 'index'],
            '/' => ['controller' => $Home, 'method' => 'index'],
            '/filter' => ['controller' => $Home, 'method' => 'filter'],
            //---------- Inscription ---------//
            '/register' => ['controller' => $Register, 'method' => 'index'],
            '/register_post' => ['controller' => $Register, 'method' => 'push'],
            //---------- Connexion ---------//
            '/login' => ['controller' => $Login, 'method' => 'index'],
            '/login_push' => ['controller' => $Login, 'method' => 'push'],
            //---------- User Account ---------//
            '/user' => ['controller' => $User, 'method' => 'home'],
            '/disconnect' => ['controller' => $User, 'method' => 'disconnect'],
            '/delete' => ['controller' => $User, 'method' => 'delete'],
            '/modify' => ['controller' => $User, 'method' => 'Modify'],
            //---------- Favorites ---------//
            '/favorite' => ['controller' => $Favorites, 'method' => 'favorite'],
            '/revokeFavorite' => ['controller' => $Favorites, 'method' => 'revokeFavorite'],
            '/favoriteProperty' => ['controller' => $Favorites, 'method' => 'favoriteProperty'],
            //---------- Orders ---------//
            '/order' => ['controller' => $Order, 'method' => 'reservation'],
            '/orders' => ['controller' => $Order, 'method' => 'reservationsProperty'],
            //---------- Reviews ---------//
            '/publishReview' => ['controller' => $Review, 'method' => 'PublishReview'],
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
            //---------- Equipment ---------//
            '/admin/equipments' => ['controller' => $AdminEquipment, 'method' => 'index'],
            '/admin/addEquipment' => ['controller' => $AdminEquipment, 'method' => 'addEquipment'],
            '/admin/deleteEquipment' => ['controller' => $AdminEquipment, 'method' => 'deleteEquipment'],
            '/admin/updateEquipment' => ['controller' => $AdminEquipment, 'method' => 'updateEquipment'],
            //---------- Services ---------//
            '/admin/services' => ['controller' => $AdminService, 'method' => 'index'],
            '/admin/addService' => ['controller' => $AdminService, 'method' => 'addService'],
            '/admin/deleteService' => ['controller' => $AdminService, 'method' => 'deleteService'],
            '/admin/updateService' => ['controller' => $AdminService, 'method' => 'updateService'],
            //---------- Reviews ---------//
            '/admin/reviews' => ['controller' => $Review, 'method' => 'index'],
            //---------- Type ---------//
            '/admin/type' => ['controller' => $AdminType, 'method' => 'type'],
            '/admin/addType' => ['controller' => $AdminType, 'method' => 'addType'],
            '/admin/deleteType' => ['controller' => $AdminType, 'method' => 'deleteType'],
            '/admin/updateType' => ['controller' => $AdminType, 'method' => 'updateType'],
            '/info' => ['controller' => $Home, 'method' => 'info']
        ];
    }
}
