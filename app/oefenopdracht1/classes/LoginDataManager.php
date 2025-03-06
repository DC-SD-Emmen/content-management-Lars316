
<?php

class LoginDataManager {
  private $servername = "mysql";
  private $username = "root";
  private $password = "root";
  private $dbname = "user_login";
  private $conn;

  public function __construct(Database $db) {
    $this->conn = $db->getConnection();
  }

}

?>