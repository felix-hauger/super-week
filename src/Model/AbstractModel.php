<?php

namespace App\Model;

use App\Database\DbConnection;
use PDO;
use PDOException;

/**
 * Parent class model handling database connection + simple methods & table names
 * 
 * @package AbstractModel
 * 
 * @method void         __construct()
 * @method array|false  findAll()
 * @method array|false  findOne(int $id)
 * @method array|false  findBy(array $fields)
 */
abstract class AbstractModel implements Template
{
    /**
     * @var PDO Database connection
     */
    protected PDO $_db;

    /**
     * @var string Current class table
     */
    protected string $_table;

    /**
     * Set Database connection & store it in $_db property
     */
    public function __construct()
    {
        $this->_db = DbConnection::getInstance();

        // get child class (on the context where it is called)
        $class = get_class($this);

        // explode the namespace into an array
        $class = explode('\\', $class);

        // set $_table property value to the last array entry case lowered
        $this->_table = '`' . strtolower(array_pop($class)) . '`';
    }

    /**
     * @return array|false Database result if request is successfull, false otherwise
     */
    public function findAll(): array|false
    {
        $sql = 'SELECT * FROM ' . $this->_table;
        
        $select = $this->_db->prepare($sql);

        $select->execute();

        return $select->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @return array|false Database result if request is successfull, false otherwise
     */
    public function find(int $id): array|false
    {
        $sql = 'SELECT * FROM ' . $this->_table . ' WHERE id = :id';

        $select = $this->_db->prepare($sql);

        $select->bindParam(':id', $id, PDO::PARAM_INT);

        $select->execute();

        return $select->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Search in the database using an array of values as conditions
     * @param array $fields Associative array parameters used as conditions in the SQL query
     * @return array|false The retrieved data if row is found, else false
     */
    public function findBy(array $fields) : array|false
    {
        $sql = 'SELECT * FROM ' . $this->_table . ' WHERE ';

        foreach ($fields as $column_name => $value) {
            $sql .= $column_name . ' = :' . $column_name . ' AND ' ;
        }

        $sql = substr($sql, 0, -5);

        $select = $this->_db->prepare($sql);

        $select->execute($fields);
        
        return $select->fetch(PDO::FETCH_ASSOC);
    }
}