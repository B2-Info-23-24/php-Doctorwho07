<?php

namespace Controllers;

use Models\EquipmentModel;

class EquipmentController
{
    public function index()
    {
        $equipments = EquipmentModel::getAllEquipment();
        $loader = new \Twig\Loader\FilesystemLoader('App/Views/');
        $twig = new \Twig\Environment($loader);
        $template = $twig->load('pages/AdminEquipment.html.twig');
        echo $template->display(
            [
                'title' => "Tous les équipments",
                'equipments' => $equipments,
            ]
        );
    }

    public function addEquipment()
    {
        if (isset($_POST['equipmentName'])) {
            $equipmentName = $_POST['equipmentName'];
            EquipmentModel::addEquipment($equipmentName);
            header("Location: /admin/equipments");
            exit();
        }
    }

    public function updateEquipment()
    {
        $id = $_POST['id'] ?? '';
        $name = $_POST['name'] ?? '';
        EquipmentModel::updateEquipment($id, $name);
        header('Location: /admin/equipments');
    }

    public function deleteEquipment($id)
    {
        EquipmentModel::deleteEquipment($id);
        header("Location: /admin/equipments");
        exit();
    }
}

