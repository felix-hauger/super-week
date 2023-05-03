<?php

require 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$router = new AltoRouter();

$router->setBasePath(DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR);

echo 'coucou';