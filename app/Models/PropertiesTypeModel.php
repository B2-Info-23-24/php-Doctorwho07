<?php

namespace Models;

use PDO, PDOException;

class PropertiesTypeModel
{
    static function getAllPropertiesType()
    {
        $connexion = ConnectDB::getConnection();
        try {
            $sql = "SELECT * FROM lodging_types";
            $TypeList = $connexion->query($sql)->fetchAll(PDO::FETCH_ASSOC);
            return $TypeList !== false ? $TypeList : array();
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des utilisateurs : " . $e->getMessage();
            return array();
        }
    }
}
