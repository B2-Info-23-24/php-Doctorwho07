<?php

namespace Controllers;

use Models\PropertiesModel, Models\UserModel, Models\FavoriteModel;


class AccueilController
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
        $template = $twig->load('pages/accueil.html.twig');
        $properties = PropertiesModel::GetAllProperties();
        $propertiesandfavorites = array();
        foreach ($properties as $property) {
            if (isset($_SESSION['user'])) {
                $isFavorite = FavoriteModel::isPropertyFavoritedByUser($_SESSION['user']['ID'], $property['ID']);
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
            ]
        );
    }
}
