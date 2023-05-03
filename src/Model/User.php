<?php

namespace App\Model;

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
           $this->_db->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
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
}