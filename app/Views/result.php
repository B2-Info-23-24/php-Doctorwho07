<!DOCTYPE html>
<html>

<head>
    <title>Résultats de la recherche</title>
</head>

<body>
    <h2>Résultats de la recherche :</h2>
    <?php
    if (!empty($searchResults)) {
        echo "<ul>";
        foreach ($searchResults as $result) {
            echo "<li>" . $result['Title'] . "</li>";
        }
        echo "</ul>";
    } else {
        echo "Aucun résultat trouvé.";
    }
    ?>
</body>

</html>