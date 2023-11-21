<?php

namespace Controllers;

use Models\PropertiesModel;

class PublierController
{
    public function index()
    {
        require_once(dirname(__DIR__) . '/Views/addProperties.php');
    }
    public function traitement()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $title = $_POST['Title'];
            $description = $_POST['Description'];
            $image = $_FILES['Image'];
            $price = $_POST['Price'];
            $location = $_POST['Location'] . $_POST['City'];
            $city = $_POST['City'];
            $uploadDirectory = (__DIR__ . '../../../public/images/');
            $tempName = $image['tmp_name'];
            $fileName = basename($image['name']);
            $destination = $uploadDirectory . $fileName;
            if (!move_uploaded_file($tempName, $destination)) {
                echo "Une erreur est survenue lors du téléchargement de l'image.";
                exit;
            }
            $propertyAdded = PropertiesModel::AddProperties($title, $description, $fileName, $price, $location, $city);
            if ($propertyAdded) {
                header('Location: accueil');
            } else {
                header('Location: publier');
            }
        } else {
            header('Location: publier');
            exit();
        }
    }
}
