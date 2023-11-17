<?php
$connexionDB = require_once(dirname(__DIR__) . '/Models/connexion_DB.php');

if (!$connexionDB) {
    echo "Le fichier connexion_DB.php n'a pas été trouvé.";
}

$publierModel = require_once(dirname(__DIR__) . '/Models/PropertiesModel.php');

if (!$publierModel) {
    echo "Le fichier BienModel.php n'a pas été trouvé.";
}

class PublierController
{
    private $propertiesModel;

    public function __construct()
    {
        $this->propertiesModel = new PropertiesModel();
    }

    public function index()
    {
        require_once(dirname(__DIR__) . '/Views/addProperties.php');
    }

    public function traitement()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $title = $_POST['Title'];
            $description = $_POST['Description'];
            $image = $_POST['Image'];
            $price = $_POST['Price'];
            $location = $_POST['Location'];
            $propertyAdded = $this->propertiesModel->AddProperties($title, $description, $image, $price, $location);
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
