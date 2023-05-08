<?php

namespace App\Model;

use App\Entity\Book as EntityBook;
use PDO;
use PDOException;

/**
 * Class model accessing the book table in the database
 * 
 * @package Book
 * 
 * @method bool create(EntityBook $book)
 */
class Book extends AbstractModel
{
    /**
     * @param EntityBook $book Represents one book
     * @return bool Depending if insert request is successfull or not
     */
    public function create(EntityBook $book): bool
    {
        $sql = 'INSERT INTO book (title, summary, content, user_id) VALUES (:title, :summary, :content, :user_id)';

        $insert = $this->_db->prepare($sql);

        $insert->bindValue(':title', $book->getTitle());
        $insert->bindValue(':summary', $book->getSummary());
        $insert->bindValue(':content', $book->getContent());
        $insert->bindValue(':user_id', $book->getUserId());

        return $insert->execute();
    }
}