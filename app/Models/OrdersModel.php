<?php

namespace Models;

use PDOException, PDO, DateTime;

class OrdersModel
{

    static function AddOrder($reservation)
    {
        $connexion = ConnectDB::getConnection();

        $startDate = $reservation['startDate'];
        $endDate = $reservation['endDate'];
        $dateOrder = $reservation['DateOrder'];
        $price = $reservation['price'];
        $propertyId = $reservation['propertyId'];
        $userId = $reservation['userId'];

        try {
            // Ajout de la réservation dans la table 'orders'
            $sql = "INSERT INTO orders (Start, End, DateOrder, Price, foreign_key_property, foreign_key_user) VALUES ('$startDate', '$endDate', '$dateOrder', '$price', '$propertyId', '$userId')";
            $connexion->exec($sql);

            // Ajout des disponibilités pour chaque jour entre les dates de début et de fin dans 'orders'
            $availableDates = new \DatePeriod(new DateTime($startDate), new \DateInterval('P1D'), new DateTime($endDate));
            foreach ($availableDates as $date) {
                $formattedDate = $date->format('Y-m-d');
                $sql = "INSERT INTO orders (Start, End, DateOrder, Price, foreign_key_property, foreign_key_user) VALUES ('$formattedDate', '$formattedDate', '$dateOrder', '0', '$propertyId', '$userId')";
                $connexion->exec($sql);
            }

            return true;
        } catch (PDOException $e) {
            echo "Erreur lors de l'ajout de la réservation : " . $e->getMessage();
            return false;
        }
    }

    static function GetOrderById($OrderId)
    {
        $connexion = ConnectDB::getConnection();

        try {
            $sql = "SELECT * FROM orders WHERE ID = '$OrderId'";
            $userData = $connexion->query($sql)->fetch(PDO::FETCH_ASSOC);
            return $userData !== false ? $userData : null;
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération de l'utilisateur : " . $e->getMessage();
            return null;
        }
    }
    static function GetAllOrders()
    {
        $connexion = ConnectDB::getConnection();

        try {
            $sql = "SELECT * FROM orders";
            $userList = $connexion->query($sql)->fetchAll(PDO::FETCH_ASSOC);
            return $userList !== false ? $userList : array();
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des utilisateurs : " . $e->getMessage();
            return array();
        }
    }


    static function UpdateOrdersById($OrderId, $newOrderData)
    {
        $connexion = ConnectDB::getConnection();

        try {
            $currentUserData = OrdersModel::GetOrderById($OrderId);
            if ($currentUserData) {
                foreach ($newOrderData as $key => $value) {
                    $currentUserData[$key] = $value;
                }
                $sql = "UPDATE orders SET ";
                foreach ($currentUserData as $key => $value) {
                    $sql .= "$key = '$value', ";
                }
                $sql = rtrim($sql, ", ");
                $sql .= " WHERE ID = '$OrderId'";
                $affectedRows = $connexion->exec($sql);
                return $affectedRows !== false ? true : false;
            } else {
                echo "Utilisateur non trouvé.";
                return false;
            }
        } catch (PDOException $e) {
            echo "Erreur lors de la mise à jour de l'utilisateur : " . $e->getMessage();
            return false;
        }
    }
    static function isPropertyOrderByUser($UserId, $propertyId)
    {
        $connexion = ConnectDB::getConnection();
        try {
            $sql = "SELECT * FROM orders WHERE foreign_key_user = '$UserId' AND foreign_key_property = '$propertyId'";
            $userData = $connexion->query($sql)->fetch(PDO::FETCH_ASSOC);
            return $userData;
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération de l'utilisateur : " . $e->getMessage();
            return false;
        }
    }
    static function GetAllOrdersWithDetails()
    {
        $connexion = ConnectDB::getConnection();

        try {
            $sql = "SELECT o.ID, p.Title, o.Start, o.End, o.DateOrder, o.Price, p.Location
                FROM orders o
                INNER JOIN properties p ON o.foreign_key_property = p.ID";

            $userList = $connexion->query($sql)->fetchAll(PDO::FETCH_ASSOC);
            return $userList !== false ? $userList : array();
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des utilisateurs : " . $e->getMessage();
            return array();
        }
    }
    public static function checkAvailability($propertyId, $Start, $End)
    {
        // Assurez-vous de sécuriser les entrées pour éviter les injections SQL
        // Ici, $propertyId, $startDate et $endDate doivent être sécurisés contre les injections SQL avant utilisation dans la requête.

        $connexion = ConnectDB::getConnection();

        $query = "SELECT COUNT(*) AS count FROM orders 
                  WHERE foreign_key_property = :propertyId 
                  AND Start <= :End AND End >= :Start";

        $stmt = $connexion->prepare($query);
        $stmt->bindParam(':propertyId', $propertyId);
        $stmt->bindParam(':Start', $Start);
        $stmt->bindParam(':End', $End);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $count = (int)$result['count'];

        // Si count > 0, cela signifie qu'il y a des réservations pour ces dates et cette propriété
        // Donc le logement n'est pas disponible
        return $count === 0;
    }
}
