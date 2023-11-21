<?php

namespace Models;

use PDOException, PDO;

class PropertiesModel
{
    static function GetPropertiesById($propertyId)
    {
        $connexion = ConnectDB();
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
        $connexion = ConnectDB();
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
        $connexion = ConnectDB();
        try {
            $sql = "DELETE FROM properties WHERE ID = '$propertyId'";
            $affectedRows = $connexion->exec($sql);
            return $affectedRows !== false ? true : false;
        } catch (PDOException $e) {
            echo "Erreur lors de la suppression de la propriété : " . $e->getMessage();
            return false;
        }
    }
    static function AddProperties($title, $description, $image, $price, $location, $city)
    {
        $connexion = ConnectDB();
        try {
            $sql = "INSERT INTO properties (Title, Description, Image, Price, Location, City) 
                VALUES ('$title', '$description', '$image', '$price', '$location', LOWER('$city'))";
            $connexion->exec($sql);
            return true;
        } catch (PDOException $e) {
            echo "Erreur lors de l'ajout du bien : " . $e->getMessage();
            return false;
        }
    }
    static function GetAllProperties()
    {
        $connexion = ConnectDB();
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
        $connexion = ConnectDB();
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
        $connexion = ConnectDB();
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
        $connexion = ConnectDB();
        $sql = "SELECT * FROM properties";
        if (!empty($searchTerm)) {
            $searchTerm = $connexion->quote("%$searchTerm%");
            $sql .= " WHERE Title LIKE $searchTerm";
        }
        $result = $connexion->query($sql);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    static function SearchProperties($search)
    {
        $connexion = ConnectDB();
        try {
            $sql = "SELECT * FROM properties WHERE Title LIKE :searchTerm";
            $stmt = $connexion->prepare($sql);
            $searchTerm = '%' . $search . '%';
            $stmt->bindParam(':searchTerm', $searchTerm, PDO::PARAM_STR);
            $stmt->execute();
            $searchResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $searchResults !== false ? $searchResults : array();
        } catch (PDOException $e) {
            echo "Erreur lors de la recherche de propriétés : " . $e->getMessage();
            return array();
        }
    }
    static function getPropertyDetailsById($propertyId)
    {
        $connexion = ConnectDB();
        try {
            $sql = "SELECT * FROM properties WHERE ID = :propertyId";
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
}



// recuperer tous les logements qui ont le meme titre
// trier tous les logements en fonction de leur lieu