<?php

namespace Controllers;

use Models\PropertiesModel, Models\FavoriteModel, Controllers\LoginController, Models\JoinModel;


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
        $propertyDetails = PropertiesModel::getPropertyDetailsById($propertyId);
        // $property = PropertiesModel::GetPropertiesById($propertyId);
        $loader = new \Twig\Loader\FilesystemLoader('App/Views/');
        $twig = new \Twig\Environment($loader);
        $template = $twig->load('pages/property.html.twig');
        // echo $template->display(
        //     [
        //         'property' => $property,
        //         'ID' => $property['ID'],
        //         'Title' => $property['Title'],
        //         'Description' => $property['Description'],
        //         'Image' => $property['Image'],
        //         'Price' => $property['Price'],
        //         'Location' => $property['Location'],
        //         'City' => $property['City'],
        //         'foreign_key_lodging_type' => $property['foreign_key_lodging_type'],
        //         'propertyIsFavorite' => $propertyIsFavorite,
        //         'connected' => $connected,
        //     ]
        // );
        echo $template->display(
            [
                'property' => $propertyDetails[0], // Sélection du premier élément du tableau des détails de la propriété
                'propertyIsFavorite' => $propertyIsFavorite,
                'connected' => $connected,
                // 'order' => $order,
            ]
        );
    }
}
