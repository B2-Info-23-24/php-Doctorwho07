<?php

namespace Views;

use Models\ConnectDB, PDO, PDOException;

$connexion = ConnectDB::getConnection();

$sqlProperties = "SELECT * FROM properties";



try {
    $resultatProperties = $connexion->query($sqlProperties);
    if ($resultatProperties->rowCount() > 0) {
        echo "<h2>Informations des biens :</h2>";
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Title</th><th>Description</th><th>Image</th><th>Price</th><th>Location</th><th>City</th></tr>";

        while ($row = $resultatProperties->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>{$row['ID']}</td>";
            echo "<td>{$row['Title']}</td>";
            echo "<td>{$row['Description']}</td>";
            echo "<td><img src='/public/images/{$row['Image']}' width=50px alt='Image du logement'></td>";
            echo "<td>{$row['Price']}</td>";
            echo "<td>{$row['Location']}</td>";
            echo "<td>{$row['City']}</td>";
            echo "<td><a href='/property/{$row['ID']}'><button>Voir détails</button></a></td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "Aucun résultat trouvé.";
    }
} catch (PDOException $e) {
    echo "Erreur d'exécution de la requête SQL : " . $e->getMessage();
}
