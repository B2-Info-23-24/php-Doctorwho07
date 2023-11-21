<?php

$connexion = ConnectDB();

if (!$connexion) {
    die("Erreur de connexion à la base de données.");
}

$sqlUser = "SELECT * FROM users WHERE IsAdmin = 1;";

try {
    $resultat = $connexion->query($sqlUser);
    if ($resultat->rowCount() > 0) {
        echo "<h2>Informations des utilisateurs :</h2>";
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Nom</th><th>Prénom</th><th>Email</th><th>Mot de passe</th><th>IsAdmin</th></tr>";

        while ($row = $resultat->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>{$row['ID']}</td>";
            echo "<td>{$row['Lastname']}</td>";
            echo "<td>{$row['Firstname']}</td>";
            echo "<td>{$row['Email']}</td>";
            echo "<td>" . (isset($row['Password']) ? $row['Password'] : "") . "</td>";
            echo "<td>" . (isset($row['IsAdmin']) ? $row['IsAdmin'] : "") . "</td";
            echo "<td><a href='/user/{$row['ID']}'><button>Voir détails</button></a></td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "Aucun résultat trouvé.";
    }
} catch (PDOException $e) {
    echo "Erreur d'exécution de la requête SQL : " . $e->getMessage();
}
