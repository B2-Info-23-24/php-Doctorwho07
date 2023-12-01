<?php

namespace Models;

use PDO;
use PDOException;

class FilterModel
{
    public static function getFilteredProperties($minPrice, $maxPrice, $City, $propertyType, $selectedEquipments, $selectedServices)
    {
        $connection = ConnectDB::getConnection();
        $sql = "SELECT * FROM properties WHERE 1";

        $parameters = [];

        if ($minPrice !== null) {
            $sql .= " AND Price >= :minPrice";
            $parameters[':minPrice'] = $minPrice;
        }
        if ($maxPrice !== null) {
            $sql .= " AND Price <= :maxPrice";
            $parameters[':maxPrice'] = $maxPrice;
        }

        if ($City !== null && $City !== "Choisissez une ville") {
            $sql .= " AND City = :City";
            $parameters[':City'] = $City;
        }

        if ($propertyType !== null && $propertyType !== "Choisissez un type") {
            $sql .= " AND foreign_key_lodging_type = :propertyType";
            $parameters[':propertyType'] = $propertyType;
        }

        if (!empty($selectedEquipments)) {
            $equipmentIds = implode(',', $selectedEquipments);
            $sql .= " AND ID IN (SELECT foreign_key_property FROM selected_equipments WHERE foreign_key_equipments IN ($equipmentIds))";
        }

        if (!empty($selectedServices)) {
            $serviceIds = implode(',', $selectedServices);
            $sql .= " AND ID IN (SELECT foreign_key_property FROM selected_services WHERE foreign_key_services IN ($serviceIds))";
        }
        $stmt = $connection->prepare($sql);
        $stmt->execute($parameters);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
}
