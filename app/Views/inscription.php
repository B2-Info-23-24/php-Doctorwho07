<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
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

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        form {
            width: 300px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #555;
        }

        a {
            width: 20% !important;
            margin: 4%;
            text-decoration: none;
            background-color: #007bff;
        }

        input[type="text"],
        input[type="tel"],
        input[type="email"],
        input[type="password"] {
            width: calc(100% - 10px);
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .signin-button {
            display: block;
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 4px;
            background-color: #28a745;
            color: #fff;
            text-align: center;
            text-decoration: none;
            transition: background-color 0.3s ease;
            margin-top: 15px;
        }

        .signin-button:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>
    <h2>Inscription</h2>
    <form action="/traitement_inscription" method="post">
        <input type="text" id="lastname" name="lastname" placeholder="Nom" required><br>
        <input type="text" id="firstname" name="firstname" placeholder="Prénom" required><br>
        <input type="tel" id="phone" name="phone" placeholder="Numéro de téléphone" pattern="[0-9]{10}" title="Le numéro de téléphone doit comporter 10 chiffres" required><br>
        <input type="email" id="email" name="email" placeholder="Email" required><br>
        <input type="password" id="password" name="password" placeholder="Mot de passe" required><br>
        <input type="submit" value="S'inscrire">
    </form>
    <a href="/connexion" class="signin-button">Se connecter</a>

</body>

</html>