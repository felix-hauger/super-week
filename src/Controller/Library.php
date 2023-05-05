<?php

namespace App\Controller;

use App\Entity\Book;
use App\Model\Book as ModelBook;
use FFI\Exception;

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

    public function writeBook()
    {
        $input = [
            'title' => filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'summary' => filter_input(INPUT_POST, 'summary', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'content' => filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
        ];

        foreach ($input as $key => $value) {
            if (!$value) {
                throw new Exception(str_replace('_', ' ', ucwords($key)) . ' input invalid.');
            }
        }

        $user_model = new ModelBook();

        $user = new Book();

        $user
            ->setTitle($input['title'])
            ->setSummary($input['summary'])
            ->setContent($input['content'])
            ->setUserId($_SESSION['user']->getId());

        return $user_model->create($user);
    }
}