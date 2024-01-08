<?php

namespace Controllers;

use Models\PropertiesTypeModel;

class TypeController
{
    public function type()
    {
        $loader = new \Twig\Loader\FilesystemLoader('App/Views/');
        $admin = isset($_SESSION['user']) ? $_SESSION['user']['IsAdmin'] : 0;

        $twig = new \Twig\Environment($loader);
        $propertiesTypes = PropertiesTypeModel::getAllPropertiesType();
        $template = $twig->load('pages/AdminType.html.twig');
        echo $template->display(
            [
                'title' => "Property Type",
                'propertiesTypes' => $propertiesTypes,
                'admin' => $admin,
            ]
        );
    }
    public function addType()
    {
        $type = $_POST['type'] ?? '';
        PropertiesTypeModel::addPropertyType($type);
        header('Location: /admin/type');
    }
    public function deleteType($id)
    {

        PropertiesTypeModel::deletePropertyType($id);
        header('Location: /admin/type');
    }
    public function updateType()
    {
        $id = $_POST['id'] ?? '';
        $name = $_POST['name'] ?? '';
        PropertiesTypeModel::updatePropertyType($id, $name);
        header('Location: /admin/type');
    }
}
