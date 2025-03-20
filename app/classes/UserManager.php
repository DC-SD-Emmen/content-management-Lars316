<?php

class UserManager {
  private $conn;

  public function __construct(Database $db) {
    $this->conn = $db->getConnection();
  }

  public function checkPassword($password, & $errors) {

    // The variables userName and userPassword refer to the username and password the user filled in,
    // I just gave them a different name to differentiate them from the username and password used for the database.
    // (And just in case the code decides to be annoying and use the wrong ones.)
    $errors_init_count = count($errors);

    if (strlen($password) < 8) {
      $errors[] = "Password must be at least 8 characters long.";
    }

    if (!preg_match("#[0-9]+#", $password)) {
      $errors[] = "Password must include at least one number.";
    }

    if (!preg_match("#[a-zA-Z]+#", $password)) {
      $errors[] = "Password must include at least one letter.";
    }

    if (!preg_match("#[^a-zA-Z0-9'\"\\\\]+#", $password)) {
      $errors[] = "Password must include at least one special character.";
    }

    return (count($errors) == $errors_init_count);
    
  }

  public function insert($data) {

    $username = htmlspecialchars($data['username']);
    $password = htmlspecialchars($data['password']);

    $emailRegex = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
    $emailRegex = '/^[A-Za-z0-9@._-]+$/'
    $usernameRegex = '/^[A-Za-z0-9_]+$/';

    if (!preg_match($usernameRegex, $username)) {
      echo "<p>Sorry, the username you filled in contains one or more characters that are not accepted.</p>";
    } else {

      $errors = [];

      if (!$this->checkPassword($password, $errors)) {

        echo "<p>You did not include one or more conditions in your password, those being:</p>";
        foreach ($errors as $error) {
            echo "<p>" . $error . "</p>";
        }

        return;

      }

      $passwordHashed = password_hash($password, PASSWORD_DEFAULT);

      try {

        //:username and :password are placeholders
        $stmt = $this->conn->prepare("INSERT INTO users (username, password)
        VALUES (:username, :password)");

        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $passwordHashed);

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

  public function getUserGames($sessionID) {

    $stmt = $this->conn->prepare("SELECT games.id, games.image FROM games INNER JOIN user_games ON games.id = user_games.game_id WHERE user_games.user_id = $sessionID");

    $stmt->execute();

    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    return $stmt->fetchAll();

  }
 
}

?>