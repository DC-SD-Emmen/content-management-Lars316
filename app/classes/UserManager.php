<?php

class UserManager {
  private $conn;

  public function __construct(Database $db) {
    $this->conn = $db->getConnection();
  }

  public function checkPassword($password, & $errors) {

    // At first these variables were named differently juuust in case the code confused them with those for the database, but that isn't actually a problem lol.
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
  } // This regex is actually pretty neat, because you can fill in a lot, but you NEED to have an '@' and at least one dot. Nice going Copilot.

  public function checkUsername($username) {
    return preg_match("/^[A-Za-z0-9_]+$/", $username);
  } // The username allows underscores, cause this. Is an EPIC. GAMER. WEBSITE. (Sorry if that made you cringe.)

  public function insert($data) { // This function does a bunch of checks to make sure the data is valid, and if it is, it inserts it into the database.

    $email = htmlspecialchars($data['email']);
    $username = htmlspecialchars($data['username']);
    $password = htmlspecialchars($data['password']);

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

        //:email, :username and :password are placeholders that then get bindParam'd to the actual variables.
        $stmt = $this->conn->prepare("INSERT INTO users (email, username, password)
        VALUES (:email, :username, :password)");

        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $passwordHashed);

        $stmt->execute();
        // echo "<p>Your account has been created successfully. You can now login</p>";
        // I wanted to make it so once you've signed up, you automatically go to homepage.php, but I couldn't find out how to do that.

        $_SESSION['userid'] = $this->conn->lastInsertId();
        $_SESSION['username'] = $username;

        header("Location: homepage.php");
        exit(); 

      } catch(PDOException $e) {
        echo "<p>Error: " . $e->getMessage() . "</p>";
      }

    }
    
  }

  public function GetUser($username) { // This function is used to get a user's data so the data in the login can be checked.

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

  // THIS FUNCTION IS FOR CHANGING EMAILS (The functions look very similar, so I'm just going to scream which function does what.)

  public function changeEmail($sessionID, $emailO, $email, $username, $password) {
    
    $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = :id");

    $stmt->bindParam(':id', $sessionID);

    $stmt->execute();

    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $user = $stmt->fetch();

    if ($user['email'] != $emailO) {
      echo "<p>The email you filled in does not match the email we have in our databases.</p>";
      return; // Gotta make sure the user is who they say they are, and that involves their old data too.
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

  // THIS FUNCTION IS FOR CHANGING USERNAMES

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

  // THIS FUNCTION IS FOR CHANGING PASSWORDS

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

  // THIS FUNCTION IS FOR DELETING ACCOUNTS

  public function deleteAccount($sessionID, $email, $username, $password) {
    // Can't just delete an account, so we check the data before we delete it.
    
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
      // This query gets the games that a user has stored in their personal library.

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