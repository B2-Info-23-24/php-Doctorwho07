<?php
$connexionDB = require_once(dirname(__DIR__) . '/Models/connexion_DB.php');

if (!$connexionDB) {
    echo "Le fichier connexion_DB.php n'a pas été trouvé.";
}

$connexionUser = require_once(dirname(__DIR__) . '/Models/UserModel.php');

if (!$connexionUser) {
    echo "Le fichier UserModel.php n'a pas été trouvé.";
}

class ConnexionController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        require_once(dirname(__DIR__) . '/Views/connexion.php');
    }

    public function traitement()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $checkedSuccessfull = $this->userModel->CheckUser($email, $password);
            if ($checkedSuccessfull == true) {
                header('Location: accueil');
                exit();
            } else {
                //echo "Email ou Mot de passe incorrect";
                header('Location: /connexion');
            }
        } else {
            header('Location: /inscription');
            exit();
        }
    }
}