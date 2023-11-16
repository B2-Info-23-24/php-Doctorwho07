<?php

class UserModel
{
    private $connexion;

    public function __construct()
    {
        $this->connexion = ConnectDB();
    }
    public function GetPropertiesById($propertyId)
    {
        try {
            $sql = "SELECT * FROM properties WHERE ID = '$propertyId'";
            $propertyData = $this->connexion->query($sql)->fetch(PDO::FETCH_ASSOC);

            return $propertyData !== false ? $propertyData : null;
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération de la propriété : " . $e->getMessage();
            return null;
        }
    }

    public function UpdatePropertiesById($propertyId, $newPropertyData)
    {
        try {
            $currentPropertyData = $this->GetPropertiesById($propertyId);

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

                $affectedRows = $this->connexion->exec($sql);

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
    public function DeletePropertiesById($propertyId)
    {
        try {
            $sql = "DELETE FROM properties WHERE ID = '$propertyId'";
            $affectedRows = $this->connexion->exec($sql);

            return $affectedRows !== false ? true : false;
        } catch (PDOException $e) {
            echo "Erreur lors de la suppression de la propriété : " . $e->getMessage();
            return false;
        }
    }
    public function AddProperties($propertyData)
    {
        try {
            $columns = implode(", ", array_keys($propertyData));
            $values = "'" . implode("', '", array_values($propertyData)) . "'";
            $sql = "INSERT INTO properties ($columns) VALUES ($values)";
            $affectedRows = $this->connexion->exec($sql);

            return $affectedRows !== false ? true : false;
        } catch (PDOException $e) {
            echo "Erreur lors de l'ajout de la propriété : " . $e->getMessage();
            return false;
        }
    }

    public function GetAllProperties()
    {
        try {
            $sql = "SELECT * FROM properties";
            $propertyList = $this->connexion->query($sql)->fetchAll(PDO::FETCH_ASSOC);

            return $propertyList !== false ? $propertyList : array();
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des propriétés : " . $e->getMessage();
            return array();
        }
    }
    public function CheckPropertiesExist($propertyId)
    {
        try {
            $sql = "SELECT COUNT(*) FROM properties WHERE ID = '$propertyId'";
            $result = $this->connexion->query($sql)->fetchColumn();
            return $result > 0;
        } catch (PDOException $e) {
            echo "Erreur lors de la vérification de la propriété : " . $e->getMessage();
            return false;
        }
    }

    public function GetPropertiesByTitle($propertyTitle)
    {
        try {
            $sql = "SELECT * FROM properties WHERE Title = '$propertyTitle'";
            $propertyData = $this->connexion->query($sql)->fetch(PDO::FETCH_ASSOC);

            return $propertyData !== false ? $propertyData : null;
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération de la propriété par titre : " . $e->getMessage();
            return null;
        }
    }
}
