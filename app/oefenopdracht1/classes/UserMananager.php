
<?php

class UserManager {

    private $conn;

    public function __construct(Database $db)
    {
        $this->conn = $db->getConnection();
    }

    public function insertUser($username, $password) {

        $stmt = $this->conn->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");

        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);

        $stmt->execute();

    }

    public function GetUser($username) {

        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = :username");

        $stmt->bindParam(':username', $username);

        $stmt->execute();

        return $stmt->fetch();

    }

}

?>