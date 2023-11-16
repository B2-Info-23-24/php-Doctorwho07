<?php
require_once "app/Models/init_database.php";
InitDB();

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $connexion = ConnectDB();

    if ($connexion) {
        $sql = "SELECT * FROM users WHERE Email = :email";

        $stmt = $connexion->prepare($sql);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['Password'])) {
            $_SESSION['user_id'] = $user['ID'];
            $_SESSION['user_email'] = $user['Email'];
            $_SESSION['user_admin'] = $user['IsAdmin'];

            echo "Connexion réussie. Redirection vers la page d'accueil...";
            header("Location: index.php");
            exit();
        } else {
            echo "Identifiants incorrects. Veuillez réessayer.";
        }

        $connexion = null;
    }
}