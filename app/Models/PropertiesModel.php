<?php

namespace Models;

use PDOException, PDO;

class PropertiesModel
{
    static function GetPropertiesById($propertyId)
    {
        $db = ConnectDB::getConnection();
        $sql = "SELECT * FROM properties WHERE ID = '$propertyId'";
        $query = $db->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    static function UpdatePropertiesById($propertyId, $newPropertyData)
    {
        $connexion = ConnectDB::getConnection();
        $currentPropertyData = PropertiesModel::GetPropertiesById($propertyId);
        foreach ($newPropertyData as $key => $value) {
            $currentPropertyData[$key] = $value;
        }
        $sql = "UPDATE properties SET ";
        foreach ($currentPropertyData as $key => $value) {
            $sql .= "$key = '$value', ";
        }
        $sql = rtrim($sql, ", ");
        $sql .= " WHERE ID = '$propertyId'";
        $affectedRows = $connexion->exec($sql);
        return $affectedRows !== false ? true : false;
    }
    static function DeletePropertiesById($propertyId)
    {
        $db = ConnectDB::getConnection();
        $sql = "DELETE FROM properties WHERE ID = '$propertyId'";
        $query = $db->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    static function addProperties($title, $description, $image, $price, $location, $city, $propertyType, $selectedEquipments, $selectedServices)
    {
        $db = ConnectDB::getConnection();
        $IdPropertyType = intval($propertyType);
        $address = $location . "," . $city;
        $sql = "INSERT INTO properties (Title, Description, Image, Price, Location, City, foreign_key_lodging_type) 
                VALUES ('$title', '$description', '$image', '$price', '$address', LOWER('$city'), '$IdPropertyType')";
        $query = $db->prepare($sql);
        $query->execute();
        $lastInsertedId = $db->lastInsertId();
        foreach ($selectedEquipments as $equipment) {
            $equipmentId = intval($equipment);
            $sqlEquipment = "INSERT INTO selected_equipments (foreign_key_property, foreign_key_equipments)
                            VALUES ('$lastInsertedId', '$equipmentId')";
            $queryEquipment = $db->prepare($sqlEquipment);
            $queryEquipment->execute();
        }
        foreach ($selectedServices as $service) {
            $serviceId = intval($service);
            $sqlService = "INSERT INTO selected_services (foreign_key_property, foreign_key_services) 
                            VALUES ('$lastInsertedId', '$serviceId')";
            $queryService = $db->prepare($sqlService);
            $queryService->execute();
        }
        return true;
    }
    static function GetAllProperties()
    {
        $db = ConnectDB::getConnection();
        $sql = "SELECT * FROM properties";
        $query = $db->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    static function CheckPropertiesExist($id)
    {
        $db = ConnectDB::getConnection();
        $sql = "SELECT COUNT(*) FROM properties WHERE ID = '$id'";
        $query = $db->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    static function getReservedDatesForProperty($propertyId)
    {
        $db = ConnectDB::getConnection();
        $sql = "SELECT Start, End FROM orders WHERE foreign_key_property = '$propertyId'";
        $query = $db->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    static function GetPropertiesByTitle($propertyTitle)
    {
        $db = ConnectDB::getConnection();
        $sql = "SELECT * FROM properties WHERE Title = LOWER('$propertyTitle')";
        $query = $db->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    static function getPropertyDetailsById($propertyId)
    {
        $db = ConnectDB::getConnection();
        $sql = "SELECT p.*, l.Type AS LodgingType, GROUP_CONCAT(DISTINCT e.Type) AS EquipmentTypes, GROUP_CONCAT(DISTINCT s.Type) AS ServiceTypes
                FROM properties p
                LEFT JOIN selected_equipments se ON p.ID = se.foreign_key_property
                LEFT JOIN equipments e ON se.foreign_key_equipments = e.ID
                LEFT JOIN selected_services ss ON p.ID = ss.foreign_key_property
                LEFT JOIN services s ON ss.foreign_key_services = s.ID
                LEFT JOIN lodging_types l ON p.foreign_key_lodging_type = l.ID
                WHERE p.ID = :propertyId
                GROUP BY p.ID";
        $query = $db->prepare($sql);
        $query->bindParam(':propertyId', $propertyId, PDO::PARAM_INT);
        $query->execute();
        $propertyData = $query->fetchAll(PDO::FETCH_ASSOC);
        return $propertyData;
    }
    static function getAllEquipments()
    {
        $db = ConnectDB::getConnection();
        $sql = "SELECT * FROM equipments";
        $query = $db->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    static function getAllServices()
    {
        $db = ConnectDB::getConnection();
        $sql = "SELECT * FROM services";
        $query = $db->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    static function getPropertiesPrice($propertyId)
    {
        $db = ConnectDB::getConnection();
        $sql = "SELECT Price FROM properties WHERE ID = '$propertyId'";
        $query = $db->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    static function AddReservation($reservation)
    {
        $db = ConnectDB::getConnection();
        $sql = "INSERT INTO orders (Start, End, DateOrder, Price, foreign_key_property, foreign_key_user) 
                VALUES ('{$reservation['startDate']}','{$reservation['endDate']}','{$reservation['DateOrder']}','{$reservation['price']}','{$reservation['propertyId']}','{$reservation['userId']}')";
        $query = $db->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
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
}
