<?php
require_once "app/Models/init_database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lastname = $_POST["lastname"]; // Changement du nom de la variable
    $firstname = $_POST["firstname"]; // Changement du nom de la variable
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Changement du nom de la variable
    $isAdmin = ($email == "alexis.rouches@icloud.com") ? 1 : 0; // Changement du casse pour correspondre à l'email
    $foreign_key_favorites = null; // Vous devez définir la logique pour la clé étrangère

    $connexion = ConnectDB();

    if ($connexion) {
        $sql = "INSERT INTO users (Lastname, Firstname, Email, Password, IsAdmin, foreign_key_favorites) 
                VALUES (:lastname, :firstname, :email, :password, :isAdmin, :foreign_key_favorites)";

        $stmt = $connexion->prepare($sql);
        $stmt->bindParam(":lastname", $lastname);
        $stmt->bindParam(":firstname", $firstname);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $password);
        $stmt->bindParam(":isAdmin", $isAdmin);
        $stmt->bindParam(":foreign_key_favorites", $foreign_key_favorites);

        if ($stmt->execute()) {
            echo "Inscription réussie. Vous pouvez maintenant vous connecter.";
        } else {
            echo "Erreur lors de l'inscription : " . $stmt->errorInfo()[2];
        }

        $connexion = null;
    }
}