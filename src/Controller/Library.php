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
 * @method void  getWriteForm()
 * @method bool  writeBook()
 */
class Library
{
    /**
     * Display infos of all books json formatted
     */
    public function list(): void
    {
        $book_model = new ModelBook();

        $books = $book_model->findAll();

        echo json_encode($books, JSON_UNESCAPED_UNICODE);
    }

    /**
     * @param int $id The book id
     * @return string Infos of one book json formatted
     */
    public function getBookInfos(int $id): string
    {
        $book_model = new ModelBook();

        $book = $book_model->find($id);

        return json_encode($book, JSON_UNESCAPED_UNICODE);
    }

    /**
     * Require book writing form, to be used in the adequate route
     * Only accessible for logged users
     */
    public function getWriteForm(): void
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /super-week', true, 403);
            die();
        }

        require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'View' . DIRECTORY_SEPARATOR . 'write-book.php';
    }

    /**
     * Submit book to the model & create it
     * Only accessible for logged users
     * @return bool Depending if the written book is successfully submitted
     */
    public function writeBook(): bool
    {
        if (!isset($_SESSION['user'])) {
            header('Location: super-week/', true, 403);
            die();
        }

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

        $book_model = new ModelBook();

        $book = new Book();

        $book
            ->setTitle($input['title'])
            ->setSummary($input['summary'])
            ->setContent($input['content'])
            ->setUserId($_SESSION['user']->getId());

        return $book_model->create($book);
    }
}