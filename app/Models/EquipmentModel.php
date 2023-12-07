<?php

namespace Models;

use PDO;

class EquipmentModel
{
    public static function getAllEquipment()
    {
        $db = ConnectDB::getConnection();
        $sql = "SELECT e.*, p.Title AS linked_properties
                FROM equipments e
                LEFT JOIN selected_equipments se ON e.ID = se.foreign_key_equipments
                LEFT JOIN properties p ON se.foreign_key_property = p.ID";
        $query = $db->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function addEquipment($equipmentName)
    {
        $db = ConnectDB::getConnection();
        $sql = "INSERT INTO equipments (Type) VALUES (?)";
        $query = $db->prepare($sql);
        return $query->execute([$equipmentName]);
    }

    public static function deleteEquipment($equipmentId)
    {
        $db = ConnectDB::getConnection();
        $sql = "DELETE FROM equipments WHERE id = ?";
        $query = $db->prepare($sql);
        return $query->execute([$equipmentId]);
    }

    public static function updateEquipment($equipmentId, $newName)
    {
        $db = ConnectDB::getConnection();
        $sql = "UPDATE equipments SET Type = ? WHERE ID = ?";
        $query = $db->prepare($sql);
        return $query->execute([$newName, $equipmentId]);
    }

    public static function linkEquipmentToLogement($equipmentId, $logementId)
    {
        $db = ConnectDB::getConnection();
        $sql = "INSERT INTO selected_equipments (foreign_key_property, foreign_key_equipments) VALUES (?, ?)";
        $query = $db->prepare($sql);
        return $query->execute([$logementId, $equipmentId]);
    }

    // public static function unlinkEquipmentFromLogement($equipmentId, $logementId)
    // {
    //     $db = ConnectDB::getConnection();
    //     $sql = "DELETE FROM selected_equipments WHERE foreign_key_equipments = ? AND foreign_key_property = ?";
    //     $query = $db->prepare($sql);
    //     return $query->execute([$equipmentId, $logementId]);
    // }

    public static function getEquipmentById($equipmentId)
    {
        $db = ConnectDB::getConnection();
        $sql = "SELECT * FROM equipments WHERE ID = ?";
        $query = $db->prepare($sql);
        $query->execute([$equipmentId]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    public static function getEquipmentIdByName($equipmentName)
    {
        $db = ConnectDB::getConnection();
        $sql = "SELECT ID FROM equipments WHERE Type = ?";
        $query = $db->prepare($sql);
        $query->execute([$equipmentName]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return ($result !== false) ? $result['ID'] : null;
    }

    public static function unlinkEquipmentFromLogement($equipmentId, $propertyId)
    {
        $db = ConnectDB::getConnection();
        $sql = "DELETE FROM selected_equipments WHERE foreign_key_equipments = :equipment_id AND foreign_key_property = :logement_id";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':equipment_id', $equipmentId, PDO::PARAM_INT);
        $stmt->bindValue(':logement_id', $propertyId, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
