<?php

namespace Controllers;

use Models\ServiceModel;

class ServicesController
{
    public function index()
    {
        $services = ServiceModel::getAllServices();
        $loader = new \Twig\Loader\FilesystemLoader('App/Views/');
        $twig = new \Twig\Environment($loader);
        $template = $twig->load('pages/AdminServices.html.twig');
        echo $template->display(
            [
                'title' => "Tous les services",
                'services' => $services,
            ]
        );
    }

    public function addService()
    {
        if (isset($_POST['serviceName'])) {
            $serviceName = $_POST['serviceName'];
            ServiceModel::addService($serviceName);
            header("Location: /admin/services");
            exit();
        }
    }

    public function updateService()
    {
        $id = $_POST['id'] ?? '';
        $name = $_POST['name'] ?? '';
        ServiceModel::updateService($id, $name);
        header('Location: /admin/services');
    }

    public function deleteService($id)
    {
        ServiceModel::deleteService($id);
        header("Location: /admin/services");
        exit();
    }
}
