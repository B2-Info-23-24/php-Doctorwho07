<?php

namespace Models;

use PDO, PDOException;

class ServiceModel
{
    public static function getAllServices()
    {
        $connexion = ConnectDB::getConnection();
        $sql = "
            SELECT 
                s.*, 
                GROUP_CONCAT(DISTINCT p.Title) AS linked_properties
            FROM services s
            LEFT JOIN services_logement sl ON s.ID = sl.service_id
            LEFT JOIN properties p ON sl.logement_id = p.ID
            GROUP BY s.ID
        ";
        $stmt = $connexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function addService($serviceName)
    {
        $connexion = ConnectDB::getConnection();
        $stmt = $connexion->prepare("INSERT INTO services (Type) VALUES (?)");
        return $stmt->execute([$serviceName]);
    }

    public static function deleteService($serviceId)
    {
        $connexion = ConnectDB::getConnection();
        $stmt = $connexion->prepare("DELETE FROM services WHERE ID = ?");
        return $stmt->execute([$serviceId]);
    }

    public static function updateService($serviceId, $newName)
    {
        $connexion = ConnectDB::getConnection();
        $stmt = $connexion->prepare("UPDATE services SET Type = ? WHERE ID = ?");
        return $stmt->execute([$newName, $serviceId]);
    }
    public static function linkServiceToLogement($serviceId, $logementId)
    {
        $connexion = ConnectDB::getConnection();
        $stmt = $connexion->prepare("INSERT INTO services_logement (service_id, logement_id) VALUES (?, ?)");
        return $stmt->execute([$serviceId, $logementId]);
    }

    public static function unlinkServiceFromLogement($serviceId, $logementId)
    {
        $connexion = ConnectDB::getConnection();
        $stmt = $connexion->prepare("DELETE FROM services_logement WHERE service_id = ? AND logement_id = ?");
        return $stmt->execute([$serviceId, $logementId]);
    }
    public static function getServiceById($serviceId)
    {
        $connexion = ConnectDB::getConnection();

        try {
            $sql = "SELECT * FROM services WHERE ID = ?";
            $stmt = $connexion->prepare($sql);
            $stmt->execute([$serviceId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération du service : " . $e->getMessage();
            return null;
        }
    }
}
