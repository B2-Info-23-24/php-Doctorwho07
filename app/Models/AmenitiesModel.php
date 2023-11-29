<?php

namespace Models;

use PDOException;
use PDO;

class AmenitiesModel
{
    public function getAllAmenitiesTypes()
    {
        try {
            $connexion = ConnectDB::getConnection();
            if (!$connexion) {
                throw new PDOException("Erreur de connexion à la base de données.");
            }

            $sql = "SELECT * FROM amenities";
            $amenitiesList = $connexion->query($sql)->fetchAll(PDO::FETCH_ASSOC);

            if ($amenitiesList === false) {
                throw new PDOException("Erreur lors de la récupération des données.");
            }

            return $amenitiesList;
        } catch (PDOException $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }
}
