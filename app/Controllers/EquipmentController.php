<?php

namespace Controllers;

use Models\EquipmentModel;

class EquipmentController
{
    public function index()
    {
        $equipments = EquipmentModel::getAllEquipment();
        $admin = isset($_SESSION['user']) ? $_SESSION['user']['IsAdmin'] : 0;
        $loader = new \Twig\Loader\FilesystemLoader('App/Views/');
        $twig = new \Twig\Environment($loader);
        $template = $twig->load('pages/AdminEquipment.html.twig');
        echo $template->display(
            [
                'title' => "Tous les équipments",
                'equipments' => $equipments,
                'admin' => $admin,
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
