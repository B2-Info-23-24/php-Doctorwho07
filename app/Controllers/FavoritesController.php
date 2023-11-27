<?php

namespace Controllers;

use Models\FavoriteModel;

class FavoritesController
{
    public function favorite()
    {
        $userId = $_SESSION['user']['ID'] ?? null;
        $propertyId = $_POST['ID'] ?? null;

        if ($userId && $propertyId) {
            FavoriteModel::addToFavorites($userId, $propertyId);
        }

        header("Location: /property/$propertyId");
        exit();
    }

    public function revokeFavorite()
    {
        $userId = $_SESSION['user']['ID'] ?? null;
        $propertyId = $_POST['ID'] ?? null;

        if ($userId && $propertyId) {
            FavoriteModel::removeFromFavorites($userId, $propertyId);
        }

        header("Location: /property/$propertyId");
        exit();
    }
    public function isPropertyFavorited()
    {
        $userId = $_SESSION['user']['ID'] ?? null;
        $propertyId = $_POST['ID'] ?? null;
        $isFavorite = FavoriteModel::isPropertyFavoritedByUser($userId, $propertyId);
        return $isFavorite;
    }
}
