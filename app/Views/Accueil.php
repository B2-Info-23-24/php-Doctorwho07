<?php
require_once "app/Models/init_DB.php";
InitDB();
// Connexion à la base de données
$connexion = ConnectDB();

// Vérifier la connexion
if (!$connexion) {
    die("Erreur de connexion à la base de données.");
}

// Requête SQL pour sélectionner toutes les lignes de la table "users"
$sql = "SELECT * FROM users";

try {
    // Exécution de la requête SQL
    $resultat = $connexion->query($sql);

    // Vérification des résultats
    if ($resultat->rowCount() > 0) {
        // Afficher les données
        echo "<h2>Informations des utilisateurs :</h2>";
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Nom</th><th>Prénom</th><th>Email</th><th>Mot de passe</th><th>IsAdmin</th><th>foreign_key_favorites</th></tr>";

        while ($row = $resultat->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>{$row['ID']}</td>";
            echo "<td>{$row['Lastname']}</td>"; // Changement du nom de la colonne
            echo "<td>{$row['Firstname']}</td>"; // Changement du nom de la colonne
            echo "<td>{$row['Email']}</td>";

            // Vérifier si la clé existe avant de l'afficher
            echo "<td>" . (isset($row['Password']) ? $row['Password'] : "") . "</td>"; // Changement du nom de la colonne
            echo "<td>" . (isset($row['IsAdmin']) ? $row['IsAdmin'] : "") . "</td"; // Changement du nom de la colonne
            echo "<td>" . (isset($row['foreign_key_favorites']) ? $row['foreign_key_favorites'] : "") . "</td>"; // Changement du nom de la colonne

            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "Aucun résultat trouvé.";
    }
} catch (PDOException $e) {
    echo "Erreur d'exécution de la requête SQL : " . $e->getMessage();
}

// Fermer la connexion
$connexion = null;
