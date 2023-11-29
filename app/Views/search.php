<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
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

        input[type="text"] {
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

        #searchResults li {
            list-style: none;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        ul {
            padding: 0;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <h2>Search Properties</h2>
    <form id="searchForm" action="/Traitement_recherche" method="post">
        <input type="text" id="search" name="search" placeholder="Name" required>
        <div id="searchResults"></div>
        <input type="submit" value="Envoyer">
    </form>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/public/js/search.js"></script>
</body>


</html>