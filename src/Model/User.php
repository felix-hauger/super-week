<?php

namespace App\Model;

use App\Entity\User as EntityUser;
use PDO;
use PDOException;

class User
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
        $sql = 'SELECT * FROM user';
        
        $select = $this->_db->prepare($sql);

        $select->execute();

        return $select->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(EntityUser $user)
    {
        $sql = 'INSERT INTO user (email, password, first_name, last_name) VALUES (:email, :password, :first_name, :last_name)';

        $insert = $this->_db->prepare($sql);

        $insert->bindValue(':email', $user->getEmail());
        $insert->bindValue(':password', $user->getPassword());
        $insert->bindValue(':first_name', $user->getFirstName());
        $insert->bindValue(':last_name', $user->getLastName());

        return $insert->execute();
    }

    public function isFieldInDb(string $column, mixed $value, bool $case_sensitive = false): bool
    {
        if ($case_sensitive) {
            $sql = 'SELECT COUNT(id) FROM user WHERE BINARY ' . $column . ' = :' . $column;
        } else {
            $sql = 'SELECT COUNT(id) FROM user WHERE UPPER(' . $column . ') LIKE UPPER(:' . $column . ')';
        }

        $select = $this->_db->prepare($sql);

        $select->bindParam(':' . $column, $value);

        $select->execute();

        return $select->fetchColumn() > 0;
    }
}