<?php

namespace Controllers;

use Models\PropertiesModel, Models\FavoriteModel;


class PropertiesController
{
    public function showProperty($propertyId)
    {
        $property = PropertiesModel::GetPropertiesById($propertyId);
        $loader = new \Twig\Loader\FilesystemLoader('App/Views/');
        $twig = new \Twig\Environment($loader);
        $template = $twig->load('pages/property.html.twig');
        $userId = $_SESSION['user']['ID'];
        $propertyIsFavorite = false;
        $propertyIsFavorite = FavoriteModel::isPropertyFavoritedByUser($userId, $propertyId);
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
                'propertyIsFavorite' => $propertyIsFavorite
            ]
        );
    }
}
