<?php

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$router = new AltoRouter();

$router->setBasePath('/super-week');

// map homepage
$router->map('GET', '/', function() {
    echo 'Bienvenue sur l\'accueil';
}, 'home');

// map users list page
$router->map('GET', '/users', function() {
    echo 'Bienvenue sur la liste des Utilisateurs';
}, 'users_list');

// map user detail page
$router->map('GET', '/users/[i:id]', function($id) {
    echo 'Bonjour utilisateur ' . $id;
}, 'user_page');

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