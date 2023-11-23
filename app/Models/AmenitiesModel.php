<?php

namespace Models;

use PDOException, PDO;

class AmenitiesModel
{

    public function getAllAmenitiesTypes()
    {
        $connexion = ConnectDB::getConnection();

        try {
            $sql = "SELECT * FROM amenities";
            $amenitiesList = $connexion->query($sql)->fetchAll(PDO::FETCH_ASSOC);
            return $amenitiesList !== false ? $amenitiesList : array();
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des types de services : " . $e->getMessage();
            return [];
        }
    }
}
