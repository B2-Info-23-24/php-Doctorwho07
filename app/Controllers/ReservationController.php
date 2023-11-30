<?php

namespace Controllers;

use Models\OrdersModel;
use Models\PropertiesModel, DateTime;

class ReservationController
{
    static public function Reservation()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $startDate = $_POST['startDate'];
            $endDate = $_POST['endDate'];
            $DateOrder = date("Y-m-d");
            $propertyId = $_POST['propertyId'];
            $userId = $_SESSION['user']['ID'];

            if (!strtotime($startDate) || !strtotime($endDate)) {
                echo '<script>displayError("Les dates que vous avez entrées sont incorrectes.");</script>';
                exit();
            }

            if ($endDate <= $startDate) {
                echo '<script>displayError("La date de fin doit être ultérieure à la date de début.");</script>';
                exit();
            }

            $isAvailable = OrdersModel::checkAvailability($propertyId, $startDate, $endDate);

            if ($isAvailable) {
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

                OrdersModel::AddOrder($reservation);

                header('Location: /reservation');
                exit();
            } else {
                echo '<script>displayError("Le logement n\'est pas disponible pour les dates sélectionnées.");</script>';
                exit();
            }
        } else {
            header('Location: inscription');
            exit();
        }
    }





    public function Modify()
    {
        $newOrderData = "";
        $OrderId = $_POST['ID'] ?? null;
        OrdersModel::UpdateOrdersById($OrderId, $newOrderData);
        header("Location: /user");
        exit();
    }
    public function ReservationsProperty()
    {
        $userId = $_SESSION['user']['ID'] ?? null;
        $propertiesReserv = OrdersModel::GetAllOrdersWithDetails();

        $propertiesandorders = $this->calculateNumberOfNights($propertiesReserv, $userId);

        $this->renderReservationsPage($propertiesandorders);
    }


    private function calculateNumberOfNights($propertiesReserv, $userId)
    {
        $propertiesandorders = [];

        foreach ($propertiesReserv as $property) {
            $startDate = new DateTime($property['Start']);
            $endDate = new DateTime($property['End']);
            $numberOfNights = $startDate->diff($endDate)->days;
            $property['NumberOfNights'] = $numberOfNights;
            $isReserv = OrdersModel::isPropertyOrderByUser($userId, $property['ID']);
            $PropertyAndOrder = ['isFavorite' => $isReserv] + $property;
            array_push($propertiesandorders, $PropertyAndOrder);
        }

        return $propertiesandorders;
    }

    private function renderReservationsPage($propertiesandorders)
    {
        $loader = new \Twig\Loader\FilesystemLoader('App/Views/');
        $twig = new \Twig\Environment($loader);
        echo $twig->render(
            'pages/Reservations.html.twig',
            [
                'title' => "Reservations",
                'reservations' => $propertiesandorders,
            ]
        );
        exit();
    }
}

