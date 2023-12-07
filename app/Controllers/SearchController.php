<?php

namespace Controllers;

use Models\PropertiesModel;

class SearchController
{
    public function searchProperty()
    {
        $title = $_GET['search'];
        $filteredProperties = PropertiesModel::GetPropertiesByTitle($title);
        $loader = new \Twig\Loader\FilesystemLoader('App/Views/');
        $twig = new \Twig\Environment($loader);
        $template = $twig->load('pages/AdminProperties.html.twig');

        echo $template->display([
            'title' => "Admin Properties",
            'properties' => $filteredProperties,
        ]);
    }
}
