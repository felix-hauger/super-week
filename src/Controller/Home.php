<?php

namespace App\Controller;

/**
 * Class managing home page
 * 
 * @package Home
 * 
 * @method void index()
 */
class Home
{
    /**
     * Require home page, to be used in the adequate route
     */
    public function index(): void
    {
        require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'View' . DIRECTORY_SEPARATOR . 'home.php';
    }
}