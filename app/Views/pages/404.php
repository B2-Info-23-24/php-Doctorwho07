<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page non trouvée</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        flex-direction: column;
        text-align: center;
    }

    .error-code {
        font-size: 6em;
        color: #555;
    }

    .error-message {
        font-size: 1.5em;
        color: #888;
    }

    .back-to-home {
        margin-top: 20px;
        text-decoration: none;
        padding: 8px 20px;
        background-color: #007bff;
        color: white;
        border-radius: 5px;
    }

    .back-to-home:hover {
        background-color: #0056b3;
    }
    </style>
</head>

<body>
    <div>
        <h1 class="error-code">404</h1>
        <p class="error-message">La page que vous recherchez est introuvable.</p>
        <a href="/accueil" class="back-to-home">Retour à la page d'accueil</a>
    </div>
</body>

</html>