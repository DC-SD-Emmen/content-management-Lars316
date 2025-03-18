<?php

  class Database {
    private $servername = "mysql";
    private $username = "root";
    private $password = "root";
    private $dbname = "gamelibrary";
    private $conn;

    //construct function immediately gets executed
    //at the moment that you make a new DbConnect()
    public function __construct() {

      try {
        $this->conn = new PDO("mysql:host=$this->servername; dbname=$this->dbname", $this->username, $this->password);
        // set the PDO error mode to exception
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
      }

    }

    public function getConnection() {
      return $this->conn;
    } 

  }

?>