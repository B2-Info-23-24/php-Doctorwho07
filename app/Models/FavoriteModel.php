<?php

namespace Models;

class FavoriteModel
{
    public static function addFavorite($userId, $propertyId)
    {
        $connexion = ConnectDB::getConnection();
        $stmt = $connexion->prepare("INSERT INTO favorites (foreign_key_user, foreign_key_property) VALUES (?, ?)");
        return $stmt->execute([$userId, $propertyId]);
    }

    public static function deleteFavorite($userId, $propertyId)
    {
        $connexion = ConnectDB::getConnection();
        $stmt = $connexion->prepare("DELETE FROM favorites WHERE foreign_key_user = ? AND foreign_key_property = ?");
        return $stmt->execute([$userId, $propertyId]);
    }
    public static function checkFavoriteExists($userId, $propertyId)
    {
        $connexion = ConnectDB::getConnection();
        $stmt = $connexion->prepare("SELECT * FROM favorites WHERE foreign_key_user = ? AND foreign_key_property = ?");
        $stmt->execute([$userId, $propertyId]);
        return $stmt->rowCount() > 0;
    }
}
