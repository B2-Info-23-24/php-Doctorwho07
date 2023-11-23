<?php

namespace Views;

use Models\ConnectDB;
use Models\PropertiesModel;

$connexion = ConnectDB::getConnection();

$url = $_SERVER['REQUEST_URI'];
$parts = explode('/', $url);
$propertyId = $parts[count($parts) - 1];

$propertiesModel = new PropertiesModel();

$propertyDetails = $propertiesModel->getPropertyDetailsById($propertyId);

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Détails de la propriété</title>
</head>

<body>
    <h1>Détails de la propriété</h1>
    <?php
    if ($propertyDetails) {
    ?>
        <p>ID: <?php echo $propertyDetails['ID']; ?></p>
        <img src="/public/images/<?php echo $propertyDetails['Image']; ?>" width="50px" alt="Image du logement">
        <p>Title: <?php echo $propertyDetails['Title']; ?></p>
        <p>Description: <?php echo $propertyDetails['Description']; ?></p>
        <p>Image: <?php echo $propertyDetails['Image']; ?></p>
        <p>Prix: <?php echo $propertyDetails['Price']; ?></p>
        <p>Localisation: <?php echo $propertyDetails['Location']; ?></p>
        <p>Type de logement: <?php echo $propertyDetails['foreign_key_lodging_type']; ?></p>
        <a href="/admin/editProperty?id=<?php echo $propertyDetails['ID']; ?>" class="btn btn-primary">
            Modifier les informations
        </a>
    <?php
    } else {
        echo "Propriété non trouvée.";
    }
    ?>
</body>

</html>