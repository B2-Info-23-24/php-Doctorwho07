<?php

$connexion = ConnectDB();

if (!$connexion) {
    die("Erreur de connexion à la base de données.");
}

$sqlUser = "SELECT * FROM users";
$sqlProperties = "SELECT * FROM properties";



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
            echo "<td><img src='/public/images/{$row['Image']}' width:50px alt='Image du logement'></td>";
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

// search bar
// filter : prix input, type selector, equipements checkbox, services checkbox
// admin panel : user, logements, avis, 
// user panel : reservation, avis, favoris, inormations perso
// more of properties : toutes les infos du logement, ajout en favoris, disponibilites, avis
// reservation
// gestion date dispo et reserve
// upload img
// afficher les img 
// favoris

// numero de telephone !!!!!!!!!