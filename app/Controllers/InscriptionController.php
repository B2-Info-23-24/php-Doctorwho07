<?php
// $connexionDbPath =  __DIR__ . '../Models/connexion_DB.php';
// if (file_exists($connexionDbPath)) {
//     require_once $connexionDbPath;
// } else {
//     die("Le fichier connexion_DB.php n'a pas été trouvé.");
// }
require_once(dirname(__DIR__) . '/Models/connexion_DB.php');

class InscriptionController
{
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
            $result = $this->addUser($lastname, $firstname, $email, $password);
            if ($result) {
                header('/accueil');
                exit();
            } else {
                echo "Erreur lors de l'inscription.";
            }
        } else {
            header('/inscription');
            exit();
        }
    }

    function addUser($lastname, $firstname, $email, $password)
    {
        try {
            $connexion = ConnectDB();
            $stmt = $connexion->prepare("INSERT INTO users (Lastname, Firstname, Email, Password) VALUES (:lastname, :firstname, :email, :password)");
            $stmt->bindParam(':lastname', $lastname);
            $stmt->bindParam(':firstname', $firstname);
            $stmt->bindParam(':email', $email);
            $stmt->bindValue(':password', password_hash($password, PASSWORD_DEFAULT));

            $result = $stmt->execute();

            return $result;
        } catch (PDOException $e) {
            echo "Erreur lors de l'ajout de l'utilisateur : " . $e->getMessage();
            return false;
        }
    }
}
