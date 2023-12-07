<?php

namespace Models;

use PDO;

class FilterModel
{
    public static function getFilteredProperties($minPrice, $maxPrice, $city, $propertyType, $selectedEquipments, $selectedServices)
    {
        $db = ConnectDB::getConnection();
        $sql = "SELECT * FROM properties WHERE 1 = 1";

        $parameters = [];

        if ($minPrice !== null) {
            $sql .= " AND Price >= :minPrice";
            $parameters[':minPrice'] = $minPrice;
        }

        if ($maxPrice !== null) {
            $sql .= " AND Price <= :maxPrice";
            $parameters[':maxPrice'] = $maxPrice;
        }

        if ($city !== null && $city !== "Choisissez une ville") {
            $sql .= " AND City = :city";
            $parameters[':city'] = $city;
        }

        if ($propertyType !== null && $propertyType !== "Choisissez un type") {
            $sql .= " AND foreign_key_lodging_type = :propertyType";
            $parameters[':propertyType'] = $propertyType;
        }

        if (!empty($selectedEquipments)) {
            $placeholders = implode(',', array_fill(0, count($selectedEquipments), '?'));
            $sql .= " AND ID IN (SELECT foreign_key_property FROM selected_equipments WHERE foreign_key_equipments IN ($placeholders))";
            $parameters = array_merge($parameters, $selectedEquipments);
        }

        if (!empty($selectedServices)) {
            $placeholders = implode(',', array_fill(0, count($selectedServices), '?'));
            $sql .= " AND ID IN (SELECT foreign_key_property FROM selected_services WHERE foreign_key_services IN ($placeholders))";
            $parameters = array_merge($parameters, $selectedServices);
        }

        $stmt = $db->prepare($sql);
        $stmt->execute($parameters);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public static function searchProperties($searchTerm)
    {
        $db = ConnectDB::getConnection();
        $sql = "SELECT * FROM properties WHERE Title LIKE :searchTerm OR City LIKE :searchTerm";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(
            ':searchTerm',
            '%' . $searchTerm . '%',
            PDO::PARAM_STR
        );
        $stmt->execute(); // Exécution de la requête préparée
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC); // Récupération des résultats
        return $result; // Retourne les résultats de la recherche
    }
}
