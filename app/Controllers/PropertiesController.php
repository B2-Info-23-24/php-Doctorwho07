<?php

namespace Controllers;

use Models\PropertiesModel, Models\FavoriteModel, Controllers\ConnexionController, DateTime;


class PropertiesController
{
    public function showProperty($propertyId)
    {
        $connected = ConnexionController::isConnected();
        if ($connected) {
            $userId = $_SESSION['user']['ID'];
            $propertyIsFavorite = FavoriteModel::isPropertyFavoritedByUser($userId, $propertyId);
        } else {
            $propertyIsFavorite = false;
        }
        $property = PropertiesModel::GetPropertiesById($propertyId);
        $loader = new \Twig\Loader\FilesystemLoader('App/Views/');
        $twig = new \Twig\Environment($loader);
        $template = $twig->load('pages/property.html.twig');
        echo $template->display(
            [
                'property' => $property,
                'ID' => $property['ID'],
                'Title' => $property['Title'],
                'Description' => $property['Description'],
                'Image' => $property['Image'],
                'Price' => $property['Price'],
                'Location' => $property['Location'],
                'City' => $property['City'],
                'propertyIsFavorite' => $propertyIsFavorite,
                'connected' => $connected,
            ]
        );
    }
}
