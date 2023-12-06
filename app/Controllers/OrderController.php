<?php

namespace Controllers;

use Models\OrdersModel, Models\PropertiesModel, DateTime;

class OrderController
{
    static public function reservation()
    {
        //_________________ Check Request Method _________________//
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            self::handleReservationPostRequest();
        } else {
            self::handleNonPostRequest();
        }
    }

    static private function handleReservationPostRequest()
    {
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];
        $DateOrder = date("Y-m-d");
        $propertyId = $_POST['propertyId'];
        $userId = $_SESSION['user']['ID'];
        if ($endDate <= $startDate) {
            var_dump("dates invalides");
            exit();
        }

        $isAvailable = OrdersModel::checkAvailability($propertyId, $startDate, $endDate);

        if ($isAvailable) {
            self::processReservation($startDate, $endDate, $DateOrder, $propertyId, $userId);
        } else {
            header('Location: /');
            exit();
        }
    }

    static private function processReservation($startDate, $endDate, $DateOrder, $propertyId, $userId)
    {
        $pricePerNight = PropertiesModel::getPropertiesPrice($propertyId);
        $startDateObj = new DateTime($startDate);
        $endDateObj = new DateTime($endDate);
        $duration = $startDateObj->diff($endDateObj)->days;
        $totalPrice = $duration * $pricePerNight - 1;
        $reservation = [
            'startDate' => $startDate,
            'endDate' => $endDate,
            'DateOrder' => $DateOrder,
            'price' => $totalPrice,
            'propertyId' => $propertyId,
            'userId' => $userId
        ];

        OrdersModel::addOrder($reservation);

        header('Location: orders');
        exit();
    }

    static private function handleNonPostRequest()
    {
        header('Location: /');
        exit();
    }


    public function modify()
    {
        $newOrderData = "";
        $OrderId = $_POST['ID'] ?? null;
        //_________________ Update Order and Redirect _________________//
        OrdersModel::UpdateOrdersById($OrderId, $newOrderData);
        header("Location: user");
        exit();
    }

    public function reservationsProperty()
    {
        if (isset($_SESSION['user']['ID'])) {
            $userId = $_SESSION['user']['ID'];
            $userReservations = OrdersModel::getOrdersByUserId($userId);
            $propertiesWithNights = $this->calculateNumberOfNights($userReservations, $userId);
            $this->renderReservationsPage($propertiesWithNights);
        } else {
            header('Location: /login');
            exit();
        }
    }

    private function calculateNumberOfNights($propertiesReserv)
    {
        $propertiesandorders = [];
        foreach ($propertiesReserv as $property) {
            //_________________ Calculate Nights _________________//
            $startDate = new DateTime($property['Start']);
            $endDate = new DateTime($property['End']);
            $numberOfNights = $startDate->diff($endDate)->days;
            $property['NumberOfNights'] = $numberOfNights;
            $propertiesandorders[] = $property;
        }
        return $propertiesandorders;
    }
    private function renderReservationsPage($propertiesandorders)
    {
        $loader = new \Twig\Loader\FilesystemLoader('App/Views/');
        $twig = new \Twig\Environment($loader);
        $propertiesIds = array_unique(array_column($propertiesandorders, 'foreign_key_property'));
        $propertiesDetails = [];
        foreach ($propertiesIds as $propertyId) {
            $propertyDetails = PropertiesModel::getPropertyDetailsById($propertyId);
            if ($propertyDetails) {
                $propertiesDetails[$propertyId] = $propertyDetails;
            }
        }
        $userHasCommented = [];
        foreach ($propertiesandorders as $reservation) {
            $propertyId = $reservation['foreign_key_property'];
            $userId = $_SESSION['user']['ID'];
            $hasCommented = OrdersModel::hasUserCommentedOnReservation($userId, $propertyId);
            $userHasCommented[$propertyId] = $hasCommented;
        }

        echo $twig->render(
            'pages/Orders.html.twig',
            [
                'title' => "Reservations",
                'reservations' => $propertiesandorders,
                'propertiesDetails' => $propertiesDetails,
                'userHasCommented' => $userHasCommented,
            ]
        );
        exit();
    }
}
