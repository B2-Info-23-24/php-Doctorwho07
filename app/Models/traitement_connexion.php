<?php
require_once "app/Models/init_database.php";
InitDB();

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"]; // Changement du nom de la variable

    $connexion = ConnectDB();

    if ($connexion) {
        $sql = "SELECT * FROM users WHERE Email = :email"; // Changement du nom de la table

        $stmt = $connexion->prepare($sql);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC); // Changement du nom de la variable

        if ($user && password_verify($password, $user['Password'])) { // Changement du nom de la colonne
            // Connexion réussie
            $_SESSION['user_id'] = $user['ID']; // Changement du nom de la colonne
            $_SESSION['user_email'] = $user['Email']; // Changement du nom de la colonne
            $_SESSION['user_admin'] = $user['IsAdmin']; // Changement du nom de la colonne

            echo "Connexion réussie. Redirection vers la page d'accueil...";
            header("Location: index.php");
            exit();
        } else {
            echo "Identifiants incorrects. Veuillez réessayer.";
        }

        $connexion = null;
    }
}
