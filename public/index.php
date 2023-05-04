<?php

use App\Controller\Auth;
use App\Controller\User;
use Faker\Factory;

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$router = new AltoRouter();

$router->setBasePath('/super-week');

// Map homepage
$router->map('GET', '/', 'App\\Controller\\Home#index', 'home');

// Map register form page
$router->map('GET', '/register', function() {
    require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'View' . DIRECTORY_SEPARATOR . 'register.php';
}, 'user_register');

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
$router->map('GET', '/login', function() {
    require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'View' . DIRECTORY_SEPARATOR . 'login.php';
}, 'user_login');

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
    echo 'Bonjour utilisateur ' . $id;
}, 'user_page');

$router->map('GET', '/users/fill', function() {
    $pdo = new PDO('mysql:host=localhost;dbname=superweek;charset=utf8mb4', 'root', '');

    $sql = 'INSERT INTO user (email, password, first_name, last_name) VALUES (:email, :password, :first_name, :last_name)';

    $insert = $pdo->prepare($sql);

    for ($i = 0; $i < 30; $i++) {
        $faker = Faker\Factory::create('fr_FR');

        $unwanted_chars = [
            'À'=>'A', 'Â'=>'A', 'Ä'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
            'Ê'=>'E', 'Ë'=>'E', 'Î'=>'I', 'Ï'=>'I', 'Ô'=>'O', 'Ö'=>'O', 'Ù'=>'U',
            'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'à'=>'a', 'â'=>'a', 'ä'=>'a', 'æ'=>'a', 'ç'=>'c',
            'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'î'=>'i', 'ï'=>'i', 'ñ'=>'n', 'ô'=>'o'
        ];

        $first_name = $faker->firstName();
        $last_name = $faker->lastName();
        $email = strtolower(strtr($first_name . '.' . $last_name, $unwanted_chars)) . '@' . $faker->freeEmailDomain();
        $password = password_hash($first_name, PASSWORD_DEFAULT);

        $insert->execute([
            ':email' => $email,
            ':password' => $password,
            ':first_name' => $first_name,
            ':last_name' => $last_name
        ]);
    }
});

// Match current request url
$match = $router->match();

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

?>