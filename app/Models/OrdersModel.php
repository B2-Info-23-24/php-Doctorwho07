<?php

namespace Models;

use PDOException, PDO;

class OrdersModel
{

    static function AddOrder($reservation)
    {
        $db = ConnectDB::getConnection();
        $startDate = $reservation['startDate'];
        $endDate = $reservation['endDate'];
        $dateOrder = $reservation['DateOrder'];
        $price = $reservation['price'];
        $propertyId = $reservation['propertyId'];
        $userId = $reservation['userId'];
        $sql = "INSERT INTO orders (Start, End, DateOrder, Price, foreign_key_property, foreign_key_user) VALUES ('$startDate', '$endDate', '$dateOrder', '$price', '$propertyId', '$userId')";
        $query = $db->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    static function GetOrderById($OrderId)
    {
        $db = ConnectDB::getConnection();
        $sql = "SELECT * FROM orders WHERE ID = '$OrderId'";
        $query = $db->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    static function GetAllOrders()
    {
        $db = ConnectDB::getConnection();
        $sql = "SELECT * FROM orders";
        $query = $db->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    static function UpdateOrdersById($OrderId, $newOrderData)
    {
        $db = ConnectDB::getConnection();
        $currentUserData = OrdersModel::GetOrderById($OrderId);
        foreach ($newOrderData as $key => $value) {
            $currentUserData[$key] = $value;
        }
        $sql = "UPDATE orders SET ";
        foreach ($currentUserData as $key => $value) {
            $sql .= "$key = '$value', ";
        }
        $sql = rtrim($sql, ", ");
        $sql .= " WHERE ID = '$OrderId'";
        $query = $db->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    static function isPropertyOrderByUser($UserId, $propertyId)
    {
        $db = ConnectDB::getConnection();
        $sql = "SELECT * FROM orders WHERE foreign_key_user = '$UserId' AND foreign_key_property = '$propertyId'";
        $query = $db->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    static function GetAllOrdersWithDetails()
    {
        $db = ConnectDB::getConnection();
        $sql = "SELECT o.ID, p.Title, o.Start, o.End, o.DateOrder, o.Price, p.City, o.foreign_key_property
                FROM orders o
                INNER JOIN properties p ON o.foreign_key_property = p.ID";
        $query = $db->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public static function checkAvailability($propertyId, $Start, $End)
    {
        $connexion = ConnectDB::getConnection();
        $query = "SELECT COUNT(*) AS count FROM orders WHERE foreign_key_property = :propertyId AND Start <= :End AND End >= :Start";
        $stmt = $connexion->prepare($query);
        $stmt->bindParam(':propertyId', $propertyId);
        $stmt->bindParam(':Start', $Start);
        $stmt->bindParam(':End', $End);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $count = (int)$result['count'];
        return $count === 0;
    }
    static function hasUserReviewedProperty($userId, $propertyId)
    {
        $db = ConnectDB::getConnection();
        $sql = "SELECT * FROM reviews WHERE foreign_key_user = ? AND foreign_key_property = ?";
        $query = $db->prepare($sql);
        $query->execute([$userId, $propertyId]);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public static function getOrdersByUserId($userId)
    {
        $connexion = ConnectDB::getConnection();
        try {
            $sql = "SELECT * FROM orders WHERE foreign_key_user = :userId";
            $stmt = $connexion->prepare($sql);
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
            $stmt->execute();
            $userOrders = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $userOrders !== false ? $userOrders : array();
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des réservations de l'utilisateur : " . $e->getMessage();
            return array();
        }
    }
}
