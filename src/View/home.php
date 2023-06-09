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
        <button id="get-all-users">Display all users</button>

        <button id="get-all-books">Display all books</button>

        <input type="number" name="user-id" id="user-id" placeholder="User Id">
        <button id="get-user">Display user infos</button>

        <input type="number" name="book-id" id="book-id" placeholder="Book Id">
        <button id="get-book">Display book infos</button>
    </div>

    <div id="content-container"></div>

    <script>

        const
            contentContainer = document.querySelector('#content-container'),
            getAllUsersButton = document.querySelector('#get-all-users'),
            getAllBooksButton = document.querySelector('#get-all-books'),
            getUserButton = document.querySelector('#get-user'),
            getBookButton = document.querySelector('#get-book');
    
        const getAllUsers = async function() {

            const request = await fetch('/super-week/users');

            const content = await request.text();

            contentContainer.innerHTML = content;            
        };
    
        const getOneUser = async function() {
            
            const userId = document.querySelector('#user-id').value;
            
            const request = await fetch('/super-week/users/' + userId);

            const content = await request.text();

            contentContainer.innerHTML = content;            
        };
    
        const getAllBooks = async function() {

            const request = await fetch('/super-week/books');

            const content = await request.text();

            contentContainer.innerHTML = content;            
        };

        const getOneBook = async function() {
            
            const bookId = document.querySelector('#book-id').value;
            
            const request = await fetch('/super-week/books/' + bookId);

            const content = await request.text();

            contentContainer.innerHTML = content;            
        };

        getAllUsersButton.addEventListener("click", getAllUsers);
        getUserButton.addEventListener("click", getOneUser);
        getAllBooksButton.addEventListener("click", getAllBooks);
        getBookButton.addEventListener("click", getOneBook);

    </script>
</body>
</html>