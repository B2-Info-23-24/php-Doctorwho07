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
        // Vérifie que l'utilisateur est connecté
        if (isset($_SESSION['user']['ID'])) {
            $userId = $_SESSION['user']['ID'];
            var_dump($userId);
            // Récupère les réservations de l'utilisateur connecté
            $userReservations = OrdersModel::getOrdersByUserId($userId);

            // Calcule le nombre de nuits pour chaque réservation
            $propertiesWithNights = $this->calculateNumberOfNights($userReservations, $userId);

            // Envoie les réservations à la vue pour affichage
            $this->renderReservationsPage($propertiesWithNights);
        } else {
            // Redirige vers la page de connexion si l'utilisateur n'est pas connecté
            header('Location: /login'); // Modifier le chemin selon ta structure
            exit();
        }
    }

    private function calculateNumberOfNights($propertiesReserv, $userId)
    {
        $propertiesandorders = [];

        foreach ($propertiesReserv as $property) {
            //_________________ Calculate Nights _________________//
            $startDate = new DateTime($property['Start']);
            $endDate = new DateTime($property['End']);
            $numberOfNights = $startDate->diff($endDate)->days;
            $property['NumberOfNights'] = $numberOfNights;

            //_________________ Check User's Property Reservations _________________//
            $isReserv = OrdersModel::isPropertyOrderByUser($userId, $property['ID']);

            //_________________ Check if User has Reviewed the Property _________________//
            $Reviewed = OrdersModel::hasUserReviewedProperty($userId, $property['ID']);

            // Add both reservation status and review status to the property entry
            $PropertyAndOrder = [
                'isFavorite' => $isReserv,
                'hasReviewed' => $Reviewed,
            ] + $property;

            array_push($propertiesandorders, $PropertyAndOrder);
        }

        return $propertiesandorders;
    }


    private function renderReservationsPage($propertiesandorders)
    {
        //_________________ Render Reservations Page with Details _________________//
        $loader = new \Twig\Loader\FilesystemLoader('App/Views/');
        $twig = new \Twig\Environment($loader);
        echo $twig->render(
            'pages/Orders.html.twig',
            [
                'title' => "Reservations",
                'reservations' => $propertiesandorders,
            ]
        );
        exit();
    }
}
