<?php

namespace Controllers;

use Models\PropertiesModel, Models\FavoriteModel, Controllers\LoginController;


class PropertiesController
{
    public function showProperty($propertyId)
    {
        $connected = LoginController::isConnected();
        if ($connected) {
            $userId = $_SESSION['user']['ID'];
            $propertyIsFavorite = FavoriteModel::checkFavoriteExists($userId, $propertyId);
        } else {
            $propertyIsFavorite = false;
        }
        $property = PropertiesModel::getPropertiesById($propertyId);
        $loader = new \Twig\Loader\FilesystemLoader('App/Views/');
        $twig = new \Twig\Environment($loader);
        $template = $twig->load('pages/Property.html.twig');
        // $order = ReservationController::isOrder();
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
                // 'order' => $order,
            ]
        );
    }
}
