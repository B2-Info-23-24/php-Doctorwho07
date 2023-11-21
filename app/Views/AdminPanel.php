<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
</head>

<body>
    <h1>Panel Admin</h1>
    <div>
        <button onclick="redirectTo('/admin/users')">Utilisateurs</button>
        <button onclick="redirectTo('/admin/properties')">Logements</button>
        <button onclick="redirectTo('/admin/admin')">Administrateurs</button>
    </div>

    <script>
        function redirectTo(route) {
            window.location.href = route;
        }
    </script>
</body>

</html>