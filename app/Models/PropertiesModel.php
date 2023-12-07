<?php

namespace Models;

use PDOException, PDO;

class PropertiesModel
{
    static function GetPropertiesById($propertyId)
    {
        $db = ConnectDB::getConnection();
        $sql = "SELECT * FROM properties WHERE ID = ?";
        $query = $db->prepare($sql);
        $query->execute([$propertyId]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    static function UpdatePropertiesById($propertyId, $newPropertyData)
    {
        $db = ConnectDB::getConnection();
        $currentPropertyData = PropertiesModel::GetPropertiesById($propertyId);
        if (!$currentPropertyData) {
            return false;
        }

        $updateFields = [];
        $updateValues = [];
        foreach ($newPropertyData as $key => $value) {
            if (array_key_exists($key, $currentPropertyData)) {
                $updateFields[] = "$key = ?";
                $updateValues[] = $value;
            }
        }

        $updateValues[] = $propertyId;
        $sql = "UPDATE properties SET " . implode(", ", $updateFields) . " WHERE ID = ?";
        $query = $db->prepare($sql);
        $success = $query->execute($updateValues);
        return $success;
    }
    static function DeletePropertiesById($propertyId)
    {
        $db = ConnectDB::getConnection();
        $sql = "DELETE FROM properties WHERE ID = ?";
        $query = $db->prepare($sql);
        $success = $query->execute([$propertyId]);
        return $success;
    }

    static function addProperties($title, $description, $image, $price, $location, $city, $propertyType, $selectedEquipments, $selectedServices)
    {
        $db = ConnectDB::getConnection();
        $IdPropertyType = intval($propertyType);

        try {
            $db->beginTransaction();

            $sql = "INSERT INTO properties (Title, Description, Image, Price, Location, City, foreign_key_lodging_type) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
            $propertyQuery = $db->prepare($sql);
            $propertyQuery->execute([$title, $description, $image, $price, $location, strtolower($city), $IdPropertyType]);

            $lastInsertedId = $db->lastInsertId();

            $sqlEquipment = "INSERT INTO selected_equipments (foreign_key_property, foreign_key_equipments) VALUES (?, ?)";
            $equipmentQuery = $db->prepare($sqlEquipment);

            foreach ($selectedEquipments as $equipment) {
                $equipmentId = intval($equipment);
                $equipmentQuery->execute([$lastInsertedId, $equipmentId]);
            }

            $sqlService = "INSERT INTO selected_services (foreign_key_property, foreign_key_services) VALUES (?, ?)";
            $serviceQuery = $db->prepare($sqlService);

            foreach ($selectedServices as $service) {
                $serviceId = intval($service);
                $serviceQuery->execute([$lastInsertedId, $serviceId]);
            }
            $db->commit();
            return true;
        } catch (PDOException $e) {
            $db->rollBack();
            return false;
        }
    }

    static function GetAllProperties()
    {
        $db = ConnectDB::getConnection();
        $sql = "SELECT * FROM properties";
        $query = $db->query($sql);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    static function CheckPropertiesExist($id)
    {
        $db = ConnectDB::getConnection();
        $sql = "SELECT COUNT(*) FROM properties WHERE ID = ?";
        $query = $db->prepare($sql);
        $query->execute([$id]);
        $count = $query->fetchColumn();
        return $count > 0;
    }
    static function getReservedDatesForProperty($propertyId)
    {
        $db = ConnectDB::getConnection();
        $sql = "SELECT Start, End FROM orders WHERE foreign_key_property = ?";
        $query = $db->prepare($sql);
        $query->execute([$propertyId]);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    static function getPropertyDetailsById($propertyId)
    {
        $db = ConnectDB::getConnection();
        $sql = "SELECT p.*, l.Type AS LodgingType, 
        GROUP_CONCAT(DISTINCT e.Type) AS EquipmentTypes, 
        GROUP_CONCAT(DISTINCT s.Type) AS ServiceTypes
        FROM properties p
        LEFT JOIN selected_equipments se ON p.ID = se.foreign_key_property
        LEFT JOIN equipments e ON se.foreign_key_equipments = e.ID
        LEFT JOIN selected_services ss ON p.ID = ss.foreign_key_property
        LEFT JOIN services s ON ss.foreign_key_services = s.ID
        LEFT JOIN lodging_types l ON p.foreign_key_lodging_type = l.ID
        WHERE p.ID = ?
        GROUP BY p.ID";
        $query = $db->prepare($sql);
        $query->execute([$propertyId]);
        $propertyData = $query->fetch(PDO::FETCH_ASSOC);

        // Vérification et traitement des chaînes avant d'utiliser explode
        if ($propertyData['EquipmentTypes'] !== null) {
            $propertyData['EquipmentTypes'] = explode(',', $propertyData['EquipmentTypes']);
        }
        if ($propertyData['ServiceTypes'] !== null) {
            $propertyData['ServiceTypes'] = explode(',', $propertyData['ServiceTypes']);
        }

        return $propertyData;
    }



    static function getAllEquipments()
    {
        $db = ConnectDB::getConnection();
        $sql = "SELECT * FROM equipments";
        $query = $db->query($sql);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    static function getAllServices()
    {
        $db = ConnectDB::getConnection();
        $sql = "SELECT * FROM services";
        $query = $db->query($sql);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    static function getPropertiesPrice($propertyId)
    {
        $db = ConnectDB::getConnection();
        $sql = "SELECT Price FROM properties WHERE ID = ?";
        $query = $db->prepare($sql);
        $query->execute([$propertyId]);
        $result = $query->fetchColumn();

        return $result !== false ? $result : null;
    }

    static function AddReservation($reservation)
    {
        $db = ConnectDB::getConnection();
        $sql = "INSERT INTO orders (Start, End, DateOrder, Price, foreign_key_property, foreign_key_user) 
                VALUES ('{$reservation['startDate']}','{$reservation['endDate']}','{$reservation['DateOrder']}','{$reservation['price']}','{$reservation['propertyId']}','{$reservation['userId']}')";
        $query = $db->prepare($sql);
        $query->execute();
        $query->fetchAll(PDO::FETCH_ASSOC);
        return true;
    }
    public static function getAllUniqueCities()
    {
        $db = ConnectDB::getConnection();
        $sql = "SELECT DISTINCT City FROM properties";
        $query = $db->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    static function GetPropertiesByTitle($propertyTitle)
    {
        $db = ConnectDB::getConnection();
        $sql = "SELECT * FROM properties WHERE Title LIKE LOWER('%$propertyTitle%')";
        $query = $db->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}
