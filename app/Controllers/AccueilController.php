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
        $userId = $_SESSION['user']['ID'] ?? null;
        $properties = PropertiesModel::GetAllProperties();
        echo $template->display(
            [
                'title' => "Home",
                'properties' => $properties,
                'users' => $users,
                'user' =>  $user,
                'propertyIsFavorite' => function ($propertyId) use ($userId) {
                    FavoriteModel::isPropertyFavoritedByUser($userId, $propertyId);
                },
            ]
        );
    }
}
