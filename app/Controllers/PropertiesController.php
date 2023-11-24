<?php

namespace Controllers;

use Models\PropertiesModel;


class PropertiesController
{
    public function showProperty($propertyId)
    {
        $property = PropertiesModel::GetPropertiesById($propertyId);
        $loader = new \Twig\Loader\FilesystemLoader('App/Views/');
        $twig = new \Twig\Environment($loader);
        $template = $twig->load('pages/property.html.twig');
        echo $template->display(
            [
                'property' => $property,
                'ID' => $propertyId,
                'Title' => $property['Title'],
                'Description' => $property['Description'],
                'Image' => $property['Image'],
                'Price' => $property['Price'],
                'Location' => $property['Location'],
                'City' => $property['City'],
            ]
        );
    }
    public function extractPropertyId($route)
    {
        $parts = explode('/', $route);
        return end($parts);
    }
}
