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

  public function checkEmail($email) {
    return preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $email);
  }

  public function checkUsername($username) {
    return preg_match("/^[A-Za-z0-9_]+$/", $username);
  }

  public function insert($data) {

    $email = htmlspecialchars($data['email']);
    $username = htmlspecialchars($data['username']);
    $password = htmlspecialchars($data['password']);

    $emailRegex = '/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
    $usernameRegex = '/^[A-Za-z0-9_]+$/';

    if (!$this->checkEmail($email)) {
      echo "<p>Sorry, our system does not see the email you filled in as a valid email address.<br>
      If this is your actual email adress, please contact our support to see what we can do.</p>";
    } elseif (!$this->checkUsername($username)) {
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
        $stmt = $this->conn->prepare("INSERT INTO users (email, username, password)
        VALUES (:email, :username, :password)");

        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $passwordHashed);

        $stmt->execute();
        echo "<p>Your account has been created successfully.</p>";

      } catch(PDOException $e) {
        echo "<p>Error: " . $e->getMessage() . "</p>";
      }

    }
    
  }

  public function GetUser($username) {

    try {

      $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = :username");

      $stmt->bindParam(':username', $username);

      $stmt->execute();

      $stmt->setFetchMode(PDO::FETCH_ASSOC);
      return $stmt->fetch();

    } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
    }

  }

  // THIS FUNCTION IS FOR EMAILS (The functions look very similar, so I'm just going to scream which function does what.)

  public function changeEmail($sessionID, $emailO, $email, $username, $password) {
    
    $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = :id");

    $stmt->bindParam(':id', $sessionID);

    $stmt->execute();

    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $user = $stmt->fetch();

    if ($user['email'] != $emailO) {
      echo "<p>The email you filled in does not match the email we have in our databases.</p>";
      return;
    } elseif ($user['username'] != $username) {
      echo "<p>The username you filled in does not match the username we have in our databases.</p>";
      return;
    } elseif (!password_verify($password, $user['password'])) {
      echo "<p>The password you filled in does not match the password we have in our databases.</p>";
      return;
    } elseif (!$this->checkEmail($email)) {
      echo "<p>Sorry, our system does not see the email you filled in as a valid email address.<br>
      If this is your actual email adress, please contact our support to see what we can do.</p>";
      return;
    } else {
      
      $stmt = $this->conn->prepare("UPDATE users SET email = :email WHERE id = :id");

      $stmt->bindParam(':email', $email);
      $stmt->bindParam(':id', $sessionID);

      $stmt->execute();

      echo "<p>Your email has been changed successfully.</p>";

    }

  }

  // THIS FUNCTION IS FOR USERNAMES

  public function changeUsername($sessionID, $email, $usernameO, $username, $password) {
    
    $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = :id");

    $stmt->bindParam(':id', $sessionID);

    $stmt->execute();

    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $user = $stmt->fetch();

    if ($user['email'] != $email) {
      echo "<p>The email you filled in does not match the email we have in our databases.</p>";
      return;
    } elseif ($user['username'] != $usernameO) {
      echo "<p>The username you filled in does not match the username we have in our databases.</p>";
      return;
    } elseif (!password_verify($password, $user['password'])) {
      echo "<p>The password you filled in does not match the password we have in our databases.</p>";
      return;
    } elseif (!$this->checkUsername($username)) {
      echo "<p>Sorry, the username you filled in contains one or more characters that are not accepted.</p>";
      return;
    } else {
      
      $stmt = $this->conn->prepare("UPDATE users SET username = :username WHERE id = :id");

      $stmt->bindParam(':username', $username);
      $stmt->bindParam(':id', $sessionID);

      $stmt->execute();

      echo "<p>Your username has been changed successfully.</p>";

    }

  }

  // THIS FUNCTION IS FOR PASSWORDS

  public function changePassword($sessionID, $email, $username, $passwordO, $password) {
    
    $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = :id");

    $stmt->bindParam(':id', $sessionID);

    $stmt->execute();

    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $user = $stmt->fetch();

    if ($user['email'] != $email) {
      echo "<p>The email you filled in does not match the email we have in our databases.</p>";
      return;
    } elseif ($user['username'] != $username) {
      echo "<p>The username you filled in does not match the username we have in our databases.</p>";
      return;
    } elseif (!password_verify($passwordO, $user['password'])) {
      echo "<p>The password you filled in does not match the password we have in our databases.</p>";
      return;
    } else {
      
      $errors = [];

      if (!$this->checkPassword($password, $errors)) {

        echo "<p>You did not include one or more conditions in your password, those being:</p>";
        foreach ($errors as $error) {
            echo "<p>" . $error . "</p>";
        }

        return; // REMEMBER TO ADD TRY AND CATCH YOU STUPID IDIOT

      }

      $passwordHashed = password_hash($password, PASSWORD_DEFAULT);

      $stmt = $this->conn->prepare("UPDATE users SET password = :password WHERE id = :id");

      $stmt->bindParam(':password', $passwordHashed);
      $stmt->bindParam(':id', $sessionID);

      $stmt->execute();

      echo "<p>Your password has been changed successfully.</p>";
      
    }

  }

  public function deleteAccount($sessionID, $email, $username, $password) {
    
    $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = :id");

    $stmt->bindParam(':id', $sessionID);

    $stmt->execute();

    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $user = $stmt->fetch();

    if ($user['email'] != $email) {
      echo "<p>The email you filled in does not match the email we have in our databases.</p>";
      return;
    } elseif ($user['username'] != $username) {
      echo "<p>The username you filled in does not match the username we have in our databases.</p>";
      return;
    } elseif (!password_verify($password, $user['password'])) {
      echo "<p>The password you filled in does not match the password we have in our databases.</p>";
      return;
    } else {

      $stmt = $this->conn->prepare("DELETE FROM user_games WHERE user_id = :id");

      $stmt->bindParam(':id', $sessionID);

      $stmt->execute();
      
      $stmt = $this->conn->prepare("DELETE FROM users WHERE id = :id");

      $stmt->bindParam(':id', $sessionID);

      $stmt->execute();

      header("Location: index.php");

      echo "<script>alert('Your account has successfully been deleted.');</script>";

    }

  }

  public function getUserGames($sessionID) {

    try {

      $stmt = $this->conn->prepare("SELECT games.id, games.image FROM games INNER JOIN user_games ON games.id = user_games.game_id WHERE user_games.user_id = $sessionID");

      $stmt->execute();

      $stmt->setFetchMode(PDO::FETCH_ASSOC);
      return $stmt->fetchAll();

    } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
    }

  }
 
}

?>