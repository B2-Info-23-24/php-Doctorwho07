<?php
class AmenitiesModel
{
    private $connexion;

    public function __construct()
    {
        $this->connexion = ConnectDB();
    }

    public function getAllAmenitiesTypes()
    {
        try {
            $sql = "SELECT * FROM amenities";
            $amenitiesList = $this->connexion->query($sql)->fetchAll(PDO::FETCH_ASSOC);
            return $amenitiesList !== false ? $amenitiesList : array();
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des types de services : " . $e->getMessage();
            return [];
        }
    }
}
