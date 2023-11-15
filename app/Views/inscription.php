<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
</head>

<body>
    <h2>Inscription</h2>
    <form action="traitement_inscription" method="post">
        <label for="lastname">Nom:</label>
        <input type="text" id="lastname" name="lastname" required><br>
        <label for="firstname">Prénom:</label>
        <input type="text" id="firstname" name="firstname" required><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>
        <label for="password">Mot de passe:</label>
        <input type="password" id="password" name="password" required><br>
        <input type="submit" value="S'inscrire">
    </form>

</body>

</html>