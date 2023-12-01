<?php

namespace Controllers;

use Models\PropertiesModel, Models\FavoriteModel, Controllers\LoginController, Models\JoinModel;


class PropertiesController
{
    public function showProperty($propertyId)
    {
        $connected = LoginController::isConnected();
        $propertyIsFavorite = false;
        if ($connected) {
            $userId = $_SESSION['user']['ID'];
            $propertyIsFavorite = FavoriteModel::isPropertyFavoritedByUser($userId, $propertyId);
        } else {
            $propertyIsFavorite = false;
        }
        $propertyDetails = PropertiesModel::getPropertyDetailsById($propertyId);
        $loader = new \Twig\Loader\FilesystemLoader('App/Views/');
        $twig = new \Twig\Environment($loader);
        $template = $twig->load('pages/property.html.twig');
        echo $template->display(
            [
                'property' => $propertyDetails[0], // Sélection du premier élément du tableau des détails de la propriété
                'propertyIsFavorite' => $propertyIsFavorite,
                'connected' => $connected,
            ]
        );
    }
}
