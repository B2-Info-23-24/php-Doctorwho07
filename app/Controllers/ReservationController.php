<?php

namespace Controllers;

use Models\OrdersModel;
use Models\PropertiesModel;

class FavoritesController
{
    static public function Reservation()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $startDate = $_POST['startDate'];
            $endDate = $_POST['endDate'];
            $DateOrder = date("Y-m-d");
            $propertyId = $_POST['propertyId'];
            $userId = $_SESSION['user']['ID'];

            //_________________ Price Per Night _________________//
            $pricePerNight = PropertiesModel::getPropertiesPrice($propertyId);
            $startDateObj = new DateTime($startDate);
            $endDateObj = new DateTime($endDate);
            $duration = $startDateObj->diff($endDateObj)->days;
            $totalPrice = $duration * $pricePerNight - 1;

            $reservation = array(
                'startDate' => $startDate,
                'endDate' => $endDate,
                'DateOrder' => $DateOrder,
                'price' => $totalPrice,
                'propertyId' => $propertyId,
                'userId' => $userId
            );
            PropertiesModel::AddReservation($reservation);
            header('Location: /');
            exit();
        } else {
            header('Location: inscription');
            exit();
        }
    }
    public function Cancel()
    {
        $userId = $_SESSION['user']['ID'] ?? null;
        $OrderId = $_POST['ID'] ?? null;
        OrdersModel::DeleteOrder($userId, $OrderId);
        header("Location: /user");
        exit();
    }

    public function Modify()
    {
        $userId = $_SESSION['user']['ID'] ?? null;
        $OrderId = $_POST['ID'] ?? null;
        OrdersModel::ModifyOrder($userId, $OrderId);
        header("Location: /user");
        exit();
    }
    public function ReservationsProperty()
    {
        $userId = $_SESSION['user']['ID'] ?? null;
        $propertiesReserv = OrdersModel::GetAllOrders();

        // $userId = $_SESSION['user']['ID'] ?? null;

        // $properties = PropertiesModel::GetAllProperties();
        // $propertiesandfavorites = array();
        // foreach ($properties as $property) {
        //     $isFavorite = FavoriteModel::isPropertyFavoritedByUser($userId, $property['ID']);
        //     $accommodationAndFavorite = array('isFavorite' => $isFavorite) + $property;
        //     array_push($propertiesandfavorites, $accommodationAndFavorite);
        // }
        // $loader = new \Twig\Loader\FilesystemLoader('App/Views/');
        // $twig = new \Twig\Environment($loader);
        // echo $twig->render(
        //     'pages/favoriteProperties.html.twig',
        //     [
        //         'title' => "Favorite",
        //         'properties' => $propertiesandfavorites,
        //     ]
        // );
        exit();
    }
}
