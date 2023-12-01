<?php

namespace Models;

use PDO, PDOException;

class PropertiesTypeModel
{
    static function getAllPropertiesType()
    {
        $connexion = ConnectDB::getConnection();
        try {
            $sql = "SELECT * FROM lodging_types";
            $TypeList = $connexion->query($sql)->fetchAll(PDO::FETCH_ASSOC);
            return $TypeList !== false ? $TypeList : array();
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des utilisateurs : " . $e->getMessage();
            return array();
        }
    }
    static function addPropertyType($typeName)
    {
        $connexion = ConnectDB::getConnection();
        try {
            $sql = "INSERT INTO lodging_types (Type) VALUES (?)";
            $stmt = $connexion->prepare($sql);
            $stmt->execute([$typeName]);
            return true;
        } catch (PDOException $e) {
            echo "Erreur lors de l'ajout du type de logement : " . $e->getMessage();
            return false;
        }
    }

    static function deletePropertyType($typeId)
    {
        $connexion = ConnectDB::getConnection();
        try {
            $sql = "DELETE FROM lodging_types WHERE ID = ?";
            $stmt = $connexion->prepare($sql);
            $stmt->execute([$typeId]);
            return true;
        } catch (PDOException $e) {
            echo "Erreur lors de la suppression du type de logement : " . $e->getMessage();
            return false;
        }
    }

    static function updatePropertyType($typeId, $newTypeName)
    {
        $connexion = ConnectDB::getConnection();
        try {
            $sql = "UPDATE lodging_types SET Type = ? WHERE ID = ?";
            $stmt = $connexion->prepare($sql);
            $stmt->execute([$newTypeName, $typeId]);
            return true;
        } catch (PDOException $e) {
            echo "Erreur lors de la mise à jour du type de logement : " . $e->getMessage();
            return false;
        }
    }
}
