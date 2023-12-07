<?php

namespace Controllers;

use Models\PropertiesModel, Models\FavoriteModel, Controllers\LoginController, Models\ReviewsModel, Models\PropertiesTypeModel, Models\EquipmentModel, Models\ServiceModel;


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
        $reservedDatesJSON = PropertiesModel::getReservedDatesForProperty($propertyId);
        $reviewsForProperty = ReviewsModel::getReviewsForProperty($propertyId);
        $reservedDates = json_encode($reservedDatesJSON);
        $loader = new \Twig\Loader\FilesystemLoader('App/Views/');
        $twig = new \Twig\Environment($loader);
        $template = $twig->load('pages/property.html.twig');
        echo $template->display(
            [
                'property' => $propertyDetails,
                'propertyIsFavorite' => $propertyIsFavorite,
                'connected' => $connected,
                'reservedDates' => $reservedDates,
                'reviews' => $reviewsForProperty,
            ]
        );
    }
    public function modifyProperty($propertyId)
    {
        $propertiesTypes = PropertiesTypeModel::getAllPropertiesType();
        $propertiesEquipments = PropertiesModel::getAllEquipments();
        $propertiesServices = PropertiesModel::getAllServices();
        $property = PropertiesModel::GetPropertiesById($propertyId);
        $loader = new \Twig\Loader\FilesystemLoader('App/Views/');
        $twig = new \Twig\Environment($loader);
        $template = $twig->load('pages/PropertyModify.html.twig');

        echo $template->render([
            'title' => "Modifier la propriété",
            'property' => $property,
            'propertiesTypes' => $propertiesTypes,
            'propertiesEquipments' => $propertiesEquipments,
            'propertiesServices' => $propertiesServices,
        ]);
    }

    public function updateProperty()
    {
        $propertyId = $_POST['propertyId'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $image = $_POST['image'];
        $price = $_POST['price'];
        $location = $_POST['location'];
        $city = $_POST['city'];
        $lodgingType = $_POST['lodgingType'] ?? 0;
        $equipments = isset($_POST['equipments']) ? $_POST['equipments'] : [];
        $services = isset($_POST['services']) ? $_POST['services'] : [];

        $success = PropertiesModel::UpdatePropertiesById($propertyId, [
            'Title' => $title,
            'Description' => $description,
            'Image' => $image,
            'Price' => $price,
            'Location' => $location,
            'City' => $city,
            'foreign_key_lodging_type' => $lodgingType,
        ]);

        if ($success) {
            // Supprimer les anciens équipements liés à la propriété
            $currentPropertyEquipments = PropertiesModel::getPropertyDetailsById($propertyId)['EquipmentTypes'];
            foreach ($currentPropertyEquipments as $equipmentId) {
                EquipmentModel::unlinkEquipmentFromLogement($equipmentId, $propertyId);
            }

            // Ajouter les nouveaux équipements sélectionnés à la propriété
            foreach ($equipments as $equipmentId) {
                EquipmentModel::linkEquipmentToLogement($equipmentId, $propertyId);
            }

            // Supprimer les anciens services liés à la propriété
            $currentPropertyServices = PropertiesModel::getPropertyDetailsById($propertyId)['ServiceTypes'];
            foreach ($currentPropertyServices as $serviceId) {
                ServiceModel::unlinkServiceFromLogement($serviceId, $propertyId);
            }

            // Ajouter les nouveaux services sélectionnés à la propriété
            foreach ($services as $serviceId) {
                ServiceModel::linkServiceToLogement($serviceId, $propertyId);
            }

            // Rediriger vers une page ou un emplacement spécifique après la mise à jour
            header("Location: /admin/properties");
            exit();
        } else {
            echo "Échec de la mise à jour de la propriété.";
        }
    }
}
