<?php

namespace Models;

use PDO, PDOException;

class FilterModel
{
    public function getFilteredResults($minPrice, $maxPrice, $location, $propertyType, $selectedEquipments, $selectedServices)
    {
        $connexion = ConnectDB::getConnection();

        $query = "SELECT * FROM properties WHERE price BETWEEN :minPrice AND :maxPrice AND location = :location";

        if ($propertyType !== "Choisissez un type") {
            $query .= " AND foreign_key_lodging_type = :propertyType";
        }

        $stmt = $connexion->prepare($query);
        $stmt->bindParam(':minPrice', $minPrice);
        $stmt->bindParam(':maxPrice', $maxPrice);
        $stmt->bindParam(':location', $location);

        if ($propertyType !== "Choisissez un type") {
            $stmt->bindParam(':propertyType', $propertyType);
        }

        $stmt->execute();

        $filteredResults = $stmt->fetchAll();

        if (!empty($selectedEquipments)) {
            $queryEquipments = "SELECT foreign_key_property FROM selected_equipments WHERE foreign_key_equipments IN (" . implode(',', $selectedEquipments) . ")";
            $stmtEquipments = $connexion->query($queryEquipments);
            $propertiesWithEquipments = $stmtEquipments->fetchAll(PDO::FETCH_COLUMN);

            $filteredResults = array_filter($filteredResults, function ($property) use ($propertiesWithEquipments) {
                return in_array($property['ID'], $propertiesWithEquipments);
            });
        }

        if (!empty($selectedServices)) {
            $queryServices = "SELECT foreign_key_property FROM selected_services WHERE foreign_key_services IN (" . implode(',', $selectedServices) . ")";
            $stmtServices = $connexion->query($queryServices);
            $propertiesWithServices = $stmtServices->fetchAll(PDO::FETCH_COLUMN);

            $filteredResults = array_filter($filteredResults, function ($property) use ($propertiesWithServices) {
                return in_array($property['ID'], $propertiesWithServices);
            });
        }

        return $filteredResults;
    }
}
