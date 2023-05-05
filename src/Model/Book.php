<?php

namespace App\Model;

use App\Entity\Book as EntityBook;
use PDO;
use PDOException;

class Book
{
    private $_db;

    /**
     * Set Database connection & store it in $_db property
     */
    public function __construct()
    {
        try {
            // Get database infos from ini file in config folder
            $db = parse_ini_file(dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR .  'db.ini');
    
            // Define PDO dsn & auth infos with retrieved data
            $this->_db = new PDO($db['type'] . ':dbname=' . $db['name'] . ';host=' . $db['host'] . ';charset=' . $db['charset'], $db['user'], $db['password']);
    
            // Prevent emulation of prepared requests
           $this->_db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * @return array|false Database result if request is successfull, false otherwise
     */
    public function findAll(): array|false
    {
        $sql = 'SELECT * FROM book';
        
        $select = $this->_db->prepare($sql);

        $select->execute();

        return $select->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @return array|false Database result if request is successfull, false otherwise
     */
    public function find(int $id): array|false
    {
        $sql = 'SELECT * FROM book WHERE id = :id';

        $select = $this->_db->prepare($sql);

        $select->bindParam(':id', $id, PDO::PARAM_INT);

        $select->execute();

        return $select->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Search book in the database using an array of values as conditions
     * @param array $fields Associative array parameters used as conditions in the SQL query
     * @return array|false The book data if row is found, else false
     */
    public function findBy(array $fields) : array|false
    {
        $sql = 'SELECT * FROM book WHERE ';

        foreach ($fields as $column_name => $value) {
            $sql .= $column_name . ' = :' . $column_name . ' AND ' ;
        }

        $sql = substr($sql, 0, -5);

        $select = $this->_db->prepare($sql);

        $select->execute($fields);
        
        return $select->fetch(PDO::FETCH_ASSOC);
    }

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