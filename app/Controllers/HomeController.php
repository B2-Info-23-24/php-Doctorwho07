<?php

namespace Controllers;

use Models\PropertiesModel, Models\UserModel, Models\FavoriteModel;


class HomeController
{
    public function index()
    {
        if (isset($_SESSION['user'])) {
            $users = UserModel::GetAllUsers();
            $user = $_SESSION['user']['IsAdmin'];
        } else {
            $users = 0;
            $user = 0;
        }
        $loader = new \Twig\Loader\FilesystemLoader('App/Views/');
        $twig = new \Twig\Environment($loader);
        $template = $twig->load('pages/Home.html.twig');
        $properties = PropertiesModel::GetAllProperties();
        $propertiesandfavorites = array();
        $connected = LoginController::isConnected();
        foreach ($properties as $property) {
            if (isset($_SESSION['user'])) {
                $isFavorite = FavoriteModel::checkFavoriteExists($_SESSION['user']['ID'], $property['ID']);
            } else {
                $isFavorite = false;
            }

            $accommodationAndFavorite = array('isFavorite' => $isFavorite) + $property;
            array_push($propertiesandfavorites, $accommodationAndFavorite);
        }
        echo $template->display(
            [
                'title' => "Home",
                'properties' => $propertiesandfavorites,
                'users' => $users,
                'user' =>  $user,
                'connected' => $connected,
            ]
        );
    }
}
