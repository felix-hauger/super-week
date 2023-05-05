<?php

namespace App\Controller;

/**
 * Class managing books & library
 * 
 * @package Library
 * 
 * @method void getWriteForm()
 */
class Library
{
    /**
     * Require book writing form, to be used in the adequate route
     */
    public function getWriteForm(): void
    {
        require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'View' . DIRECTORY_SEPARATOR . 'write-book.php';
    }
}