<?php

namespace Controllers;

use Models\PropertiesModel;

class AccueilTwig
{
    public function index()
    {
        $propertiesModel = new PropertiesModel();
        $properties = $propertiesModel->GetAllProperties();
        $loader = new \Twig\Loader\FilesystemLoader("App/Views/pages/");
        $twig = new \Twig\Environment($loader);

        $navbarContent = $twig->render('templates/navbar.twig', [
            'pageTitle' => 'Accueil', 
            'userName' => 'JohnDoe'
        ]);

        $mainViewContent = $twig->render('Accueil.twig', [
            'navbar' => $navbarContent,
            'properties' => $properties
        ]);

        echo $mainViewContent;
    }
}
