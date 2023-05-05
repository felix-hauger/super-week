<?php

use App\Controller\Auth;
use App\Controller\Library;
use App\Controller\User;
use Faker\Factory;

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$router = new AltoRouter();

// Set website root
$router->setBasePath('/super-week');

// Map homepage
$router->map('GET', '/', 'App\\Controller\\Home#index', 'home');

// Map register form page
$router->map('GET', '/register', 'App\\Controller\\Auth#getRegisterForm', 'user_register');

// Map register treatment page
$router->map('POST', '/register', function() {
    $auth = new Auth();

    try {
        if ($auth->register()) {
            // Redirect to login page after successfull registration
            header('Location: /super-week/login');

            session_start();

            // Store success message in session
            $_SESSION['successes']['register'] = 'You registered successfully!';
        }
    } catch (Exception $e) {
        // Redirect to form page if registration fails
        header('Location: /super-week/register');

        session_start();

        // Store error message in session
        $_SESSION['errors']['register'] = $e->getMessage();
    }
}, 'user_register_validate');

// Map login treatment page
$router->map('GET', '/login', 'App\\Controller\\Auth#getLoginForm', 'user_login');

// Map login treatment page
$router->map('POST', '/login', function() {

    session_start();

    $auth = new Auth();

    try {
        // Store hydrated User entity in session
        $_SESSION['user'] = $auth->login();

        // Redirect to home page
        header('Location: /super-week/');
    } catch (Exception $e) {
        // Redirect to form page if login fails
        header('Location: /super-week/login');

        session_start();

        // Store error message in session
        $_SESSION['errors']['login'] = $e->getMessage();
    }
}, 'user_login_validate');

// Map users list page
$router->map('GET', '/users', function() {
    $user = new User();

    echo 'Bienvenue sur la liste des Utilisateurs<br />' . $user->list();    
}, 'users_list');

// Map user detail page
$router->map('GET', '/users/[i:id]', function($id) {
    $user = new User();

    echo $user->getInfos($id);
}, 'user_page');

// Map route to fill database with fake users
$router->map('GET', '/users/fill', 'App\\Controller\\User#fill', 'fill_users');

// Map route to get book writing form
$router->map('GET', '/books/write', 'App\\Controller\\Library#getWriteForm', 'write_book_form');

// Map route to write a book
$router->map('POST', '/books/write', function() {
    $library = new Library();

    session_start();

    try {
        if ($library->writeBook()) {
            header('Location: /super-week/books/write');

            session_start();

            $_SESSION['successes']['write_book'] = 'Book submitted successfully!';
        }
    } catch (Exception $e) {
        $_SESSION['errors']['write_book'] = $e->getMessage();
    }

}, 'write_book_validate');

// Match current request url
$match = $router->match();

// If target is a string parse it into a class method
if (is_array($match) && is_string($match['target'])) {
    $match['target'] = explode('#', $match['target']);

    $match['target'][0] = new $match['target'][0];
}

// Call closure or throw 404 status
if(is_array($match) && is_callable( $match['target'])) {
	call_user_func_array($match['target'], $match['params']);
} else {
	// No route was matched
	header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
}