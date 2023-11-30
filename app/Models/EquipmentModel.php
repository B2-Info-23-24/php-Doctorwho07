<?php

namespace Models;

class EquipmentModel
{
    public static function getAllEquipment()
    {
        $connexion = ConnectDB::getConnection();
        $sql = "
            SELECT 
                e.*, 
                GROUP_CONCAT(DISTINCT p.Title) AS linked_properties
            FROM equipments e
            LEFT JOIN selected_equipments se ON e.ID = se.foreign_key_equipments
            LEFT JOIN properties p ON se.foreign_key_property = p.ID
            GROUP BY e.ID
        ";
        $stmt = $connexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }


    public static function addEquipment($equipmentName)
    {
        $connexion = ConnectDB::getConnection();
        $stmt = $connexion->prepare("INSERT INTO equipment (name) VALUES (?)");
        return $stmt->execute([$equipmentName]);
    }

    public static function deleteEquipment($equipmentId)
    {
        $connexion = ConnectDB::getConnection();
        $stmt = $connexion->prepare("DELETE FROM equipments WHERE id = ?");
        return $stmt->execute([$equipmentId]);
    }

    public static function updateEquipment($equipmentId, $newName)
    {
        $connexion = ConnectDB::getConnection();
        $stmt = $connexion->prepare("UPDATE equipments SET name = ? WHERE id = ?");
        return $stmt->execute([$newName, $equipmentId]);
    }
    public static function linkEquipmentToLogement($equipmentId, $logementId)
    {
        $connexion = ConnectDB::getConnection();
        $stmt = $connexion->prepare("INSERT INTO selected_equipments (foreign_key_property, foreign_key_equipments) VALUES (?, ?)");
        return $stmt->execute([$equipmentId, $logementId]);
    }

    public static function unlinkEquipmentFromLogement($equipmentId, $logementId)
    {
        $connexion = ConnectDB::getConnection();
        $stmt = $connexion->prepare("DELETE FROM selected_equipments WHERE foreign_key_equipments = ? AND foreign_key_property = ?");
        return $stmt->execute([$equipmentId, $logementId]);
    }
}
