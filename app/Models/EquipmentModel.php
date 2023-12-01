<?php

namespace Models;

use PDO;

class EquipmentModel
{
    public static function getAllEquipment()
    {
        $connexion = ConnectDB::getConnection();
        $sql = "
        SELECT e.*, p.Title AS linked_properties
        FROM equipments e
        LEFT JOIN selected_equipments se ON e.ID = se.foreign_key_equipments
        LEFT JOIN properties p ON se.foreign_key_property = p.ID
        
        ";
        $stmt = $connexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function addEquipment($equipmentName)
    {
        $connexion = ConnectDB::getConnection();
        $stmt = $connexion->prepare("INSERT INTO equipments (Type) VALUES (?)");
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
        $sql = "UPDATE equipments SET Type = ? WHERE ID = ?";
        $stmt = $connexion->prepare($sql);
        $stmt->execute([$newName, $equipmentId]);
        return true;
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
    public static function getEquipmentById($equipmentId)
    {
        $connexion = ConnectDB::getConnection();

        try {
            $stmt = $connexion->prepare("SELECT * FROM equipments WHERE ID = ?");
            $stmt->execute([$equipmentId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "Erreur lors de la récupération de l'équipement : " . $e->getMessage();
            return null;
        }
    }
}
