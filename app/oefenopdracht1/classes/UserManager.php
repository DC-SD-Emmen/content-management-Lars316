<?php

class UserManager {
  private $conn;

  public function __construct(Database $db) {
    $this->conn = $db->getConnection();
  }

  public function checkPassword($userPassword, & $errors) {

    // The variables userName and userPassword refer to the username and password the user filled in,
    // I just gave them a different name to differentiate them from the username and password used for the database.
    // (And just in case the code decides to be annoying and use the wrong ones.)
    $errors_init_count = count($errors);

    if (strlen($userPassword) < 8) {
      $errors[] = "Password must be at least 8 characters long.";
    }

    if (!preg_match("#[0-9]+#", $userPassword)) {
      $errors[] = "Password must include at least one number.";
    }

    if (!preg_match("#[a-zA-Z]+#", $userPassword)) {
      $errors[] = "Password must include at least one letter.";
    }

    if (!preg_match("#[^a-zA-Z0-9'\"\\\\]+#", $userPassword)) {
      $errors[] = "Password must include at least one special character.";
    }

    return (count($errors) == $errors_init_count);
    
  }

  public function insert($data) {

    $userName = htmlspecialchars($data['username']);
    $userPassword = htmlspecialchars($data['password']);

    // $generalRegex = '/(?!<>\/;\\[\\]{}`~)[A-Za-z0-9 ]*/';
    $userNameRegex = '/^[A-Za-z0-9_]+$/';

    if (!preg_match($userNameRegex, $userName)) {
      echo "<p>Sorry, the username you filled in contains one or more characters that are not accepted.</p>";
    } else {

      $errors = [];

      // $this->checkPassword($userPassword, $errors);

      if (!$this->checkPassword($userPassword, $errors)) {

        echo "<p>You did not include one or more conditions in your password, those being:</p>";
        foreach ($errors as $error) {
            echo "<p>" . $error . "</p>";
        }

        return;

      }

      $userPasswordHashed = password_hash($userPassword, PASSWORD_DEFAULT);

      try {
        // use exec() because no results are returned

        //in de prepare statement hieronder zie j staan: VALUES (:username, :password)
        //de dubbele punt is een placeholder
        //dan zie je daaronder binParam.. hier wordt de data pas ingevuld
        $stmt = $this->conn->prepare("INSERT INTO users (username, password)
        VALUES (:username, :password)"); // the 'users' here isn't an array, it's the table in the db.

        $stmt->bindParam(':username', $userName); // username
        $stmt->bindParam(':password', $userPasswordHashed); // password

        // $this->conn->exec($sql);
        $stmt->execute();
        echo "<p>Your account has been created successfully.</p>";
      } catch(PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
      }

    }
    
  }

  public function GetUser($username) {

    $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = :username");

    $stmt->bindParam(':username', $username);

    $stmt->execute();

    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    return $stmt->fetch();

  }
 
}

?>