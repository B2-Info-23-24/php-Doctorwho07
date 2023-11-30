<?php

namespace Controllers;

use Models\PropertiesModel, Models\UserModel, Models\PropertiesTypesModel;

class PublishController
{
    public function addProperty()
    {
        $loader = new \Twig\Loader\FilesystemLoader('App/Views/');
        $twig = new \Twig\Environment($loader);
        $template = $twig->load('pages/AddProperty.html.twig');
        $propertiesTypes = PropertiesTypesModel::getAllPropertiesType();
        echo $template->display(
            [
                'title' => "Publier un logement",
                'propertiesTypes' => $propertiesTypes,
            ]
        );
    }
    public function addUser()
    {
        $loader = new \Twig\Loader\FilesystemLoader('App/Views/');
        $twig = new \Twig\Environment($loader);
        $template = $twig->load('pages/AddUser.html.twig');
        echo $template->display();
    }
    public function pushProperty()
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
            $propertyAdded = PropertiesModel::addProperties($title, $description, $fileName, $price, $location, $city);
            if ($propertyAdded) {
                header('Location: /');
            } else {
                header('Location: /admin/property_publish');
            }
        } else {
            header('Location: /admin/property_publish');
            exit();
        }
    }
    public function pushUser()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $LastName = $_POST['LastName'];
            $FirstName = $_POST['FirstName'];
            $Phone = $_FILES['Phone'];
            $Email = $_POST['Email'];
            $Password = $_POST['Password'];
            $userAdded = UserModel::createUser($LastName, $FirstName, $Phone, $Email, $Password);
            if ($userAdded) {
                header('Location: admin/users');
            } else {
                header('Location: /admin/user_add');
            }
        } else {
            header('Location: /admin/user_add');
            exit();
        }
    }
}
