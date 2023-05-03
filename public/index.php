<?php

use App\Controller\User;
use Faker\Factory;

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$router = new AltoRouter();

$router->setBasePath('/super-week');

// map homepage
$router->map('GET', '/', function() {
    echo 'Bienvenue sur l\'accueil';
}, 'home');

// map users list page
$router->map('GET', '/users', function() {
    $user = new User();

    echo 'Bienvenue sur la liste des Utilisateurs<br />' . $user->list();    
}, 'users_list');

// map user detail page
$router->map('GET', '/users/[i:id]', function($id) {
    echo 'Bonjour utilisateur ' . $id;
}, 'user_page');

$router->map('GET', '/users/fill', function() {
    $pdo = new PDO('mysql:host=localhost;dbname=superweek;charset=utf8mb4', 'root', '');

    $sql = 'INSERT INTO user (email, password, first_name, last_name) VALUES (:email, :password, :first_name, :last_name)';

    $insert = $pdo->prepare($sql);

    for ($i = 0; $i < 30; $i++) {
        $faker = Faker\Factory::create('fr_FR');

        $first_name = $faker->firstName();
        $last_name = $faker->lastName();
        $email = strtolower($first_name . '.' . $last_name) . '@' . $faker->freeEmail();
        $password = password_hash($first_name, PASSWORD_DEFAULT);

        $insert->execute([
            ':email' => $email,
            ':password' => $password,
            ':first_name' => $first_name,
            ':last_name' => $last_name,
        ]);
    }
});

// match current request url
$match = $router->match();

// call closure or throw 404 status
if( is_array($match) && is_callable( $match['target'] ) ) {
	call_user_func_array($match['target'], $match['params']);
} else {
	// no route was matched
	header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
}

?>