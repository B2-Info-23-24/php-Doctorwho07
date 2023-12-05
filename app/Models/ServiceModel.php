<?php

namespace Models;

use PDO, PDOException;

class ServiceModel
{
    public static function getAllServices()
    {
        $db = ConnectDB::getConnection();
        $sql = "SELECT s.*, GROUP_CONCAT(DISTINCT p.Title) AS linked_properties
                FROM services s
                LEFT JOIN selected_services sl ON s.ID = sl.foreign_key_services
                LEFT JOIN properties p ON sl.foreign_key_property = p.ID
                GROUP BY s.ID";
        $query = $db->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public static function addService($serviceName)
    {
        $db = ConnectDB::getConnection();
        $sql = "INSERT INTO services (Type) VALUES (?)";
        $query = $db->prepare($sql);
        $query->execute([$serviceName]);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public static function deleteService($serviceId)
    {
        $db = ConnectDB::getConnection();
        $sql = "DELETE FROM services WHERE ID = ?";
        $query = $db->prepare($sql);
        $query->execute([$serviceId]);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public static function updateService($serviceId, $newName)
    {
        $db = ConnectDB::getConnection();
        $sql = "UPDATE services SET Type = ? WHERE ID = ?";
        $query = $db->prepare($sql);
        $query->execute([$newName, $serviceId]);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public static function linkServiceToLogement($serviceId, $logementId)
    {
        $db = ConnectDB::getConnection();
        $sql = "INSERT INTO selected_services (foreign_key_services, foreign_key_property) VALUES (?, ?)";
        $query = $db->prepare($sql);
        $query->execute([$serviceId, $logementId]);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public static function unlinkServiceFromLogement($serviceId, $logementId)
    {
        $db = ConnectDB::getConnection();
        $sql = "DELETE FROM selected_services WHERE foreign_key_services = ? AND foreign_key_property = ?";
        $query = $db->prepare($sql);
        $query->execute([$serviceId, $logementId]);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public static function getServiceById($serviceId)
    {
        $db = ConnectDB::getConnection();
        $sql = "SELECT * FROM services WHERE ID = ?";
        $query = $db->prepare($sql);
        $query->execute([$serviceId]);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}
