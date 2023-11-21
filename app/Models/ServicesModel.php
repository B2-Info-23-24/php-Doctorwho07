<?php

namespace Models;

use PDOException, PDO;

class ServiceModel
{
    public function ReadServices()
    {
        $connexion = ConnectDB();
        try {
            $sql = "SELECT * FROM services";
            $servicesList = $connexion->query($sql)->fetchAll(PDO::FETCH_ASSOC);
            return $servicesList !== false ? $servicesList : array();
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des types de services : " . $e->getMessage();
            return [];
        }
    }
}
