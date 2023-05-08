<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | Bookflow</title>
</head>
<body>
    <h1><?= isset($_SESSION['user']) ? 'Welcome ' . $_SESSION['user']->getFirstName() : 'Welcome to homepage' ?></h1>

    <div id="buttons">
        <button id="get-users">Display all users</button>

        <button id="get-books">Display all books</button>

        <input type="number" name="user-id" id="user-id" placeholder="User Id">
        <button id="get-users">Display user infos</button>

        <input type="number" name="book-id" id="book-id" placeholder="Book Id">
        <button id="get-users">Display book infos</button>
    </div>

    <div id="content-container"></div>
</body>
</html>