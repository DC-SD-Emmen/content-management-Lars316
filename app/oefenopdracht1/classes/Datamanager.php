
<?php

class GameManager {
    private $servername = "mysql";
    private $username = "root";
    private $password = "root";
    private $dbname = "gamelibrary";
    private $conn;

    public function __construct(Database $db) {
        $this->conn = $db->getConnection();
    }

};

?>