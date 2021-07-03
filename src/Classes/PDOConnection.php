<?php
namespace TopDog\Classes;

use TopDog\Interfaces\DbConnection;

class PDOConnection implements DbConnection {
    private $db;

    function __construct() {
        $this->db = new \PDO('mysql:host=127.0.0.1;port=3301;dbname=top_dog;', 'root');
    }

    public function getConnection() : \PDO {
     return $this->db;
    }
}
