<?php

namespace App\Model;

use App\Entity\User as EntityUser;
use PDO;
use PDOException;

/**
 * Class model accessing the user table in the database
 * 
 * @package User
 * 
 * @method void         __construct()
 * @method array|false  findAll()
 * @method array|false  findOne(int $id)
 * @method array|false  findBy(array $fields)
 * @method bool         create()
 * @method bool         isFieldInDb(string $column, mixed $value, bool $case_sensitive = false)
 * @method int|false    findIdByField(string $column, string $value, bool $case_sensitive = false)
 */
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

    /**
     * @return array|false Database result if request is successfull, false otherwise
     */
    public function find(int $id): array|false
    {
        $sql = 'SELECT * FROM user WHERE id = :id';

        $select = $this->_db->prepare($sql);

        $select->bindParam(':id', $id, PDO::PARAM_INT);

        $select->execute();

        return $select->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Search user in the database using an array of values as conditions
     * @param array $fields Associative array parameters used as conditions in the SQL query
     * @return array|false The user data if row is found, else false
     */
    public function findBy(array $fields) : array|false
    {
        $sql = 'SELECT * FROM user WHERE ';

        foreach ($fields as $column_name => $value) {
            $sql .= $column_name . ' = :' . $column_name . ' AND ' ;
        }

        $sql = substr($sql, 0, -5);

        $select = $this->_db->prepare($sql);

        $select->execute($fields);
        
        return $select->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @param EntityUser $user Represents one user
     * @return bool Depending if insert request is successfull or not
     */
    public function create(EntityUser $user): bool
    {
        $sql = 'INSERT INTO user (email, password, first_name, last_name) VALUES (:email, :password, :first_name, :last_name)';

        $insert = $this->_db->prepare($sql);

        $insert->bindValue(':email', $user->getEmail());
        $insert->bindValue(':password', $user->getPassword());
        $insert->bindValue(':first_name', $user->getFirstName());
        $insert->bindValue(':last_name', $user->getLastName());

        return $insert->execute();
    }

    /**
     * Test if one column is already filled with a specific value
     * @param string $column The column name
     * @param mixed $value The researched value
     * @param bool $case_sensitive If the query must be case sensitive for strings
     * @return bool If one database result is found or not
     */
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

    /**
     * Search an id in the database using by column name & value
     * @param string $column The name of the column in the table
     * @param string $value The value to search
     * @param bool $case_sensitive Determine if the query is case sensitive or not
     * @return int|false The id if row is found, else null
     */
    public function findIdByField(string $column, string $value, bool $case_sensitive = false) : int|false
    {
        if ($case_sensitive) {
            $sql = 'SELECT id FROM user WHERE BINARY ' . $column . ' = :' . $column;
        } else {
            $sql = 'SELECT id FROM user WHERE UPPER(' . $column . ') LIKE UPPER(:' . $column . ')';
        }

        $select = $this->_db->prepare($sql);

        $select->bindParam(':' . $column, $value);

        $select->execute();
        
        return $select->fetchColumn();
    }
}