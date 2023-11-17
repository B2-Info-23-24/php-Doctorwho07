<?php
class ServiceModel
{
    private $connexion;

    public function __construct()
    {
        $this->connexion = ConnectDB();
    }

    public function getAllServicesTypes()
    {
        try {
            $sql = "SELECT * FROM services";
            $servicesList = $this->connexion->query($sql)->fetchAll(PDO::FETCH_ASSOC);
            return $servicesList !== false ? $servicesList : array();
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des types de services : " . $e->getMessage();
            return [];
        }
    }
}
