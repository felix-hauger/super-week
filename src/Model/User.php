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
class User extends AbstractModel
{
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