<?php

namespace Controllers;

use Models\EquipmentModel;

class EquipmentController
{
    public function index()
    {
        $equipments = EquipmentModel::getAllEquipment();
        // Afficher la vue avec la liste des équipements

    }

    public function add()
    {
        if (isset($_POST['equipmentName'])) {
            $equipmentName = $_POST['equipmentName'];
            EquipmentModel::addEquipment($equipmentName);
            // Redirection vers la page listant les équipements
            header("Location: /equipment/index");
            exit();
        }
        // Afficher la vue pour ajouter un équipement
    }

    public function edit($id)
    {
        if (isset($_POST['newEquipmentName'])) {
            $newName = $_POST['newEquipmentName'];
            EquipmentModel::updateEquipment($id, $newName);
            header("Location: /equipment/index");
            exit();
        }
        // Récupérer les détails de l'équipement à éditer
        $equipment = EquipmentModel::getEquipmentById($id);
        // Afficher la vue pour modifier l'équipement
        // ...
    }

    public function delete($id)
    {
        // Supprimer un équipement
        EquipmentModel::deleteEquipment($id);
        // Redirection vers la page listant les équipements
        header("Location: /equipment/index");
        exit();
    }
}
