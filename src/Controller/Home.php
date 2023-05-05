<?php

namespace App\Controller;

class Home
{
    public function index()
    {
        require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'View' . DIRECTORY_SEPARATOR . 'home.php';
    }
}