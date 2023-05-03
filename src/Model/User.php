<?php

namespace App\Model;

use PDO;

class User
{
    private $_db;

    public function __construct()
    {
        // get database infos from ini file in config folder
        $db = parse_ini_file(dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR .  'db.ini');

        // define PDO dsn & auth infos with retrieved data
        $this->_db = new PDO($db['type'] . ':dbname=' . $db['name'] . ';host=' . $db['host'] . ';charset=' . $db['charset'], $db['user'], $db['password']);

        // prevent emulation of prepared requests
       $this->_db->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
    }
}