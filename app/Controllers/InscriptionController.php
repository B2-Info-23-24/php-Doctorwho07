<?php

$connexionDB = require_once(dirname(__DIR__) . '/Models/connexion_DB.php');

if (!$connexionDB) {
    echo "Le fichier connexion_DB.php n'a pas été trouvé.";
}

$connexionUser = require_once(dirname(__DIR__) . '/Models/UserModel.php');

if (!$connexionUser) {
    echo "Le fichier UserModel.php n'a pas été trouvé.";
}

class InscriptionController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        require_once(dirname(__DIR__) . '/Views/inscription.php');
    }

    public function traitement()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $lastname = $_POST['lastname'];
            $firstname = $_POST['firstname'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $addedSuccessfully = $this->userModel->AddUser($lastname, $firstname, $email, $password);
            if ($addedSuccessfully) {
                header('Location: accueil');
                exit();
            } else {
                echo "Erreur lors de l'inscription.";
            }
        } else {
            header('Location: /inscription');
            exit();
        }
    }
}