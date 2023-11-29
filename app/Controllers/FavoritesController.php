<?php

namespace Controllers;

use Models\FavoriteModel, Models\PropertiesModel;

class FavoritesController
{
    public function favorite()
    {
        $userId = $_SESSION['user']['ID'] ?? null;
        $propertyId = $_POST['ID'] ?? null;

        if ($userId && $propertyId) {
            FavoriteModel::addToFavorites($userId, $propertyId);
        }

        header("Location: /");
        exit();
    }

    public function revokeFavorite()
    {
        $userId = $_SESSION['user']['ID'] ?? null;
        $propertyId = $_POST['ID'] ?? null;

        if ($userId && $propertyId) {
            FavoriteModel::removeFromFavorites($userId, $propertyId);
        }
        header("Location: /");
        exit();
    }
    public function isPropertyFavorited()
    {
        $userId = $_SESSION['user']['ID'] ?? null;
        $propertyId = $_POST['ID'] ?? null;
        $isFavorite = FavoriteModel::isPropertyFavoritedByUser($userId, $propertyId);
        return $isFavorite;
    }

    public function favoriteProperty()
    {
        $userId = $_SESSION['user']['ID'] ?? null;

        $properties = PropertiesModel::GetAllProperties();
        $propertiesandfavorites = array();
        foreach ($properties as $property) {
            $isFavorite = FavoriteModel::isPropertyFavoritedByUser($userId, $property['ID']);
            $accommodationAndFavorite = array('isFavorite' => $isFavorite) + $property;
            array_push($propertiesandfavorites, $accommodationAndFavorite);
        }
        $loader = new \Twig\Loader\FilesystemLoader('App/Views/');
        $twig = new \Twig\Environment($loader);
        echo $twig->render(
            'pages/favoriteProperties.html.twig',
            [
                'title' => "Favorite",
                'properties' => $propertiesandfavorites,
            ]
        );
        exit();
    }
}
