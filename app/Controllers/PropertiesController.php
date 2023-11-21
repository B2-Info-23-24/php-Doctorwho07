<?php

namespace Controllers;

use Models\PropertiesModel;

class PropertiesController
{
    public function showProperty($propertyId)
    {
        $property = PropertiesModel::GetPropertiesById($propertyId);

        if ($property) {
            // Charger la vue pour afficher les détails du logement
            require_once(dirname(__DIR__) . '/Views/property_details.php');
        } else {
            header('Location: /');
            exit();
        }
    }
    public function extractPropertyId($route)
    {
        $parts = explode('/', $route);
        return end($parts);
    }
}
