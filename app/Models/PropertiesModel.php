<?php

namespace Models;

use PDOException, PDO;

class PropertiesModel
{
    static function GetPropertiesById($propertyId)
    {
        $connexion = ConnectDB::getConnection();
        try {
            $sql = "SELECT * FROM properties WHERE ID = '$propertyId'";
            $propertyData = $connexion->query($sql)->fetch(PDO::FETCH_ASSOC);
            return $propertyData !== false ? $propertyData : null;
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération de la propriété : " . $e->getMessage();
            return null;
        }
    }

    static function UpdatePropertiesById($propertyId, $newPropertyData)
    {
        $connexion = ConnectDB::getConnection();

        try {
            $currentPropertyData = PropertiesModel::GetPropertiesById($propertyId);
            if ($currentPropertyData) {
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
            } else {
                echo "Propriété non trouvée.";
                return false;
            }
        } catch (PDOException $e) {
            echo "Erreur lors de la mise à jour de la propriété : " . $e->getMessage();
            return false;
        }
    }

    static function DeletePropertiesById($propertyId)
    {
        $connexion = ConnectDB::getConnection();

        $sql = "DELETE FROM properties WHERE ID = '$propertyId'";
        $deleted = $connexion->exec($sql);
        if ($deleted === false) {
            echo "Erreur lors de la suppression de l'utilisateur";
            return false;
        } else {
            return true;
        }
    }
    static function AddProperties($title, $description, $image, $price, $location, $city, $PropertyType)
    {
        $connexion = ConnectDB::getConnection();

        try {
            $IdPropertyType = intval($PropertyType);
            $sql = "INSERT INTO properties (Title, Description, Image, Price, Location, City, foreign_key_lodging_type) 
                VALUES ('$title', '$description', '$image', '$price', '$location', LOWER('$city'), '$IdPropertyType')";
            $connexion->exec($sql);
            return true;
        } catch (PDOException $e) {
            echo "Erreur lors de l'ajout du bien : " . $e->getMessage();
            return false;
        }
    }
    static function GetAllProperties()
    {
        $connexion = ConnectDB::getConnection();

        try {
            $sql = "SELECT * FROM properties";
            $propertyList = $connexion->query($sql)->fetchAll(PDO::FETCH_ASSOC);
            return $propertyList !== false ? $propertyList : array();
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des propriétés : " . $e->getMessage();
            return array();
        }
    }
    static function CheckPropertiesExist($id)
    {
        $connexion = ConnectDB::getConnection();

        try {
            $sql = "SELECT COUNT(*) FROM properties WHERE ID = '$id'";
            $result = $connexion->query($sql)->fetchColumn();
            return $result > 0;
        } catch (PDOException $e) {
            echo "Erreur lors de la vérification de la propriété : " . $e->getMessage();
            return false;
        }
    }

    static function GetPropertiesByTitle($propertyTitle)
    {
        $connexion = ConnectDB::getConnection();

        try {
            $sql = "SELECT * FROM properties WHERE Title = LOWER('$propertyTitle')";
            $propertyData = $connexion->query($sql)->fetchAll(PDO::FETCH_ASSOC);
            return $propertyData !== false ? $propertyData : array();
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des propriétés par titre : " . $e->getMessage();
            return array();
        }
    }
    static function getProperties($searchTerm = '')
    {
        $connexion = ConnectDB::getConnection();

        $sql = "SELECT * FROM properties";
        if (!empty($searchTerm)) {
            $searchTerm = $connexion->quote("%$searchTerm%");
            $sql .= " WHERE Title LIKE $searchTerm";
        }
        $result = $connexion->query($sql);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
    static function getPropertyDetailsById($propertyId)
    {
        $connexion = ConnectDB::getConnection();

        try {
            $sql = "
            SELECT 
                p.*, 
                r.*, 
                lt.Type AS lodging_type, 
                GROUP_CONCAT(DISTINCT e.Type) AS equipment_list, 
                GROUP_CONCAT(DISTINCT s.Type) AS service_list
            FROM properties p
            LEFT JOIN reviews r ON p.ID = r.foreign_key_property
            LEFT JOIN lodging_types lt ON p.foreign_key_lodging_type = lt.ID
            LEFT JOIN selected_equipments se ON p.ID = se.foreign_key_property
            LEFT JOIN equipments e ON se.foreign_key_equipments = e.ID
            LEFT JOIN selected_services ss ON p.ID = ss.foreign_key_property
            LEFT JOIN services s ON ss.foreign_key_services = s.ID
            WHERE p.ID = :propertyId
            GROUP BY p.ID
        ";
            $stmt = $connexion->prepare($sql);
            $stmt->bindParam(':propertyId', $propertyId, PDO::PARAM_INT);
            $stmt->execute();
            $propertyData = $stmt->fetch(PDO::FETCH_ASSOC);
            return $propertyData !== false ? $propertyData : null;
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des détails de la propriété : " . $e->getMessage();
            return null;
        }
    }


    static function getPropertiesPrice($propertyId)
    {
        $connexion = ConnectDB::getConnection();
        try {
            $sql = "SELECT Price FROM properties WHERE ID = '$propertyId'";
            $propertyPrice = $connexion->query($sql)->fetch(PDO::FETCH_ASSOC);
            return isset($propertyPrice['Price']) ? (int) $propertyPrice['Price'] : 0;
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération du prix de la propriété : " . $e->getMessage();
            return 0;
        }
    }

    static function AddReservation($reservation)
    {
        $connexion = ConnectDB::getConnection();

        try {
            $sql = "INSERT INTO orders (Start, End, DateOrder, Price, foreign_key_property, foreign_key_user) 
                    VALUES (
                        '{$reservation['startDate']}',
                        '{$reservation['endDate']}',
                        '{$reservation['DateOrder']}',
                        '{$reservation['price']}',
                        '{$reservation['propertyId']}',
                        '{$reservation['userId']}'
                    )";
            $connexion->exec($sql);
            return true;
        } catch (PDOException $e) {
            echo "Erreur lors de l'ajout du bien : " . $e->getMessage();
            return false;
        }
    }
}



// recuperer tous les logements qui ont le meme titre
// trier tous les logements en fonction de leur lieu