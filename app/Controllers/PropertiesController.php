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
}
