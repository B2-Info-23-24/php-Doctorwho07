<?php

namespace Controllers;

use Models\PropertiesModel, Models\FavoriteModel, Controllers\LoginController, Models\ReviewsModel;


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
        $property = PropertiesModel::GetPropertiesById($propertyId);
        $loader = new \Twig\Loader\FilesystemLoader('App/Views/');
        $twig = new \Twig\Environment($loader);
        $template = $twig->load('pages/PropertyModify.html.twig');

        echo $template->render([
            'title' => "Modifier la propriété",
            'property' => $property,
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

        $success = PropertiesModel::UpdatePropertiesById($propertyId, [
            'Title' => $title,
            'Description' => $description,
            'Image' => $image,
            'Price' => $price,
            'Location' => $location,
            'City' => $city,
        ]);

        if ($success) {
            header("Location: /admin/properties");
            exit();
        } else {
            echo "Échec de la mise à jour de la propriété.";
        }
    }
}
