<?php

namespace Models;

use PDO;

class FavoriteModel
{
    public static function addToFavorites($userId, $propertyId)
    {
        $db = ConnectDB::getConnection();
        $sql = "INSERT INTO favorites (foreign_key_user, foreign_key_property) VALUES (?, ?)";
        $query = $db->prepare($sql);
        return $query->execute([$userId, $propertyId]); 
    }

    public static function removeFromFavorites($userId, $propertyId)
    {
        $db = ConnectDB::getConnection();
        $sql = "DELETE FROM favorites WHERE foreign_key_user = ? AND foreign_key_property = ?";
        $query = $db->prepare($sql);
        return $query->execute([$userId, $propertyId]);
    }

    public static function isPropertyFavoritedByUser($userId, $propertyId)
    {
        $db = ConnectDB::getConnection();
        $sql = "SELECT * FROM favorites WHERE foreign_key_user = ? AND foreign_key_property = ?";
        $query = $db->prepare($sql);
        $query->execute([$userId, $propertyId]);
        $result = $query->fetch(PDO::FETCH_ASSOC); 
        return $result !== false;
    }
}
