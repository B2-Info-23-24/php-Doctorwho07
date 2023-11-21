<?php

namespace Views;

use Models\UserModel;

$url = $_SERVER['REQUEST_URI'];
$parts = explode('/', $url);
$userId = $parts[count($parts) - 1];

$userModel = new UserModel();

$userDetails = $userModel->GetUserById($userId);

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Détails de l'utilisateur</title>
</head>

<body>
    <h1>Détails de l'utilisateur</h1>
    <?php
    if ($userDetails) {
    ?>
        <p>ID: <?php echo $userDetails['ID']; ?></p>
        <p>Nom: <?php echo $userDetails['Lastname']; ?></p>
        <p>Prenom: <?php echo $userDetails['Firstname']; ?></p>
        <p>telephone: <?php echo $userDetails['Phone']; ?></p>
        <p>Email: <?php echo $userDetails['Email']; ?></p>
        <p>Admin: <?php echo $userDetails['IsAdmin']; ?></p>
        <p>Mot de passe: <?php echo $userDetails['Password']; ?></p>
    <?php
    } else {
        echo "utilisateur non trouvée.";
    }
    ?>
    <h2>Connexion</h2>
    <form action="/delete" method="post">
        <input type="email" id="email" name="email" placeholder="Email" required><br>
        <input type="password" id="password" name="password" placeholder="Mot de passe" required><br>
        <input type="submit" value="Supprimer mon compte définitivement">
    </form>
    <a href="/" class="signin-button">Annuler</a>
    <a href="/disconnect" class="signin-button">Se deconnecter</a>
</body>

</html>