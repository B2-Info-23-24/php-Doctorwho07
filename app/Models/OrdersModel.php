<?php

namespace Models;

use PDOException, PDO;

class OrdersModel
{

    static function AddOrder($reservation)
    {
        $db = ConnectDB::getConnection();
        $sql = "INSERT INTO orders (Start, End, DateOrder, Price, foreign_key_property, foreign_key_user) VALUES (?, ?, ?, ?, ?, ?)";
        $query = $db->prepare($sql);
        $query->execute([$reservation['startDate'], $reservation['endDate'], $reservation['DateOrder'], $reservation['price'], $reservation['propertyId'], $reservation['userId']]);
        return true;
    }

    static function GetOrderById($orderId)
    {
        $db = ConnectDB::getConnection();
        $sql = "SELECT * FROM orders WHERE ID = ?";
        $query = $db->prepare($sql);
        $query->execute([$orderId]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result !== false ? $result : array();
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

    static function UpdateOrdersById($orderId, $newOrderData)
    {
        $db = ConnectDB::getConnection();
        $sql = "UPDATE orders SET ";
        $params = [];
        foreach ($newOrderData as $key => $value) {
            $sql .= "$key = ?, ";
            $params[] = $value;
        }
        $params[] = $orderId;
        $sql = rtrim($sql, ", ");
        $sql .= " WHERE ID = ?";
        $query = $db->prepare($sql);
        return $query->execute($params);
    }
    static function isPropertyOrderByUser($userId, $propertyId)
    {
        $db = ConnectDB::getConnection();
        $sql = "SELECT * FROM orders WHERE foreign_key_user = ? AND foreign_key_property = ?";
        $query = $db->prepare($sql);
        $query->execute([$userId, $propertyId]);
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
        $query = "SELECT COUNT(*) AS count FROM orders WHERE foreign_key_property = ? AND Start <= ? AND End >= ?";
        $stmt = $connexion->prepare($query);
        $stmt->execute([$propertyId, $End, $Start]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $count = (int)$result['count'];
        return $count === 0;
    }

    public static function getOrdersByUserId($userId)
    {
        $connexion = ConnectDB::getConnection();
        $sql = "SELECT * FROM orders WHERE foreign_key_user = ?";
        $stmt = $connexion->prepare($sql);
        $stmt->execute([$userId]);
        $userOrders = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $userOrders !== false ? $userOrders : array();
    }
    static function hasUserCommentedOnReservation($userId, $propertyId)
    {
        $db = ConnectDB::getConnection();
        $sql = "SELECT * FROM reviews WHERE foreign_key_user = ? AND foreign_key_property = ?";
        $query = $db->prepare($sql);
        $query->execute([$userId, $propertyId]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result !== false;
    }
}
