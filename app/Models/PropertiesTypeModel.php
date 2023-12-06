<?php

namespace Models;

use PDO, PDOException;

class PropertiesTypeModel
{
    static function getAllPropertiesType()
    {
        $db = ConnectDB::getConnection();
        $sql = "SELECT * FROM lodging_types";
        $query = $db->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    static function addPropertyType($type)
    {
        $db = ConnectDB::getConnection();
        $sql = "INSERT INTO lodging_types (Type) VALUES (?)";
        $query = $db->prepare($sql);
        $query->execute([$type]);
        return true;
    }

    static function deletePropertyType($typeId)
    {
        $db = ConnectDB::getConnection();
        $sql = "DELETE FROM lodging_types WHERE ID = ?";
        $query = $db->prepare($sql);
        return  $query->execute([$typeId]);
    }

    static function updatePropertyType($typeId, $newTypeName)
    {
        $db = ConnectDB::getConnection();
        $sql = "UPDATE lodging_types SET Type = ? WHERE ID = ?";
        $query = $db->prepare($sql);
        return $query->execute([$newTypeName, $typeId]);;
    }
}
