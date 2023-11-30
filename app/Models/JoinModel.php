<?php

namespace Models;

class JoinModel
{
    public static function getEquipmentByPropertyId($propertyId)
    {
        $connexion = ConnectDB::getConnection();
        $stmt = $connexion->prepare("
            SELECT equipment.ID, equipment.Type
            FROM equipments
            INNER JOIN selected_equipments ON equipments.id = selected_equipments.foreign_key_equipments
            WHERE selected_equipments.foreign_key_property = ?
        ");
        $stmt->execute([$propertyId]);
        return $stmt->fetchAll();
    }

    public static function getServicesByPropertyId($propertyId)
    {
        $connexion = ConnectDB::getConnection();
        $stmt = $connexion->prepare("
            SELECT services.ID, services.Type
            FROM services
            INNER JOIN selected_services ON services.id = selected_services.foreign_key_services
            WHERE selected_services.foreign_key_property = ?
        ");
        $stmt->execute([$propertyId]);
        return $stmt->fetchAll();
    }
}
