
<?php

class DataManager {
  private $servername = "mysql";
  private $username = "root";
  private $password = "root";
  private $dbname = "user_login";
  private $conn;

  public function __construct(Database $db) {
      $this->conn = $db->getConnection();
  }

  public function insert($data, $fileName) {

      $username = htmlspecialchars($data['username']); 
      $password = htmlspecialchars($data['password']);

      $generalRegex = '/(?!<>\/;\\[\\]{}`~)[A-Za-z0-9 ]*/';
      $usernameRegex = '/[A-Za-z0-9_]*/';

      // $passwordRegex = '/placeholder/';
  
      if (!preg_match($usernameRegex, $username)) { // could probably make this the username
        echo "<p>Sorry, the username you filled in contains one or more characters that are not accepted.</p>";
      } else if (!preg_match($generalRegex, $password)) { // then this one's the password
        echo "<p>Sorry, the password(s) you filled in contain one or more characters that are not accepted.</p>";
      } else if (!preg_match($generalRegex, $paltform)) {
        echo "<p>Sorry, the platform(s) you filled contain one or more characters that are not accepted.</p>";
      } else {
  
        try {
          // use exec() because no results are returned
  
          //!stmt moet nog worden aangepast om ook de filename in de database te zetten
          $stmt = $this->conn->prepare("INSERT INTO users (username, password)
          VALUES (:username, :password)"); // the 'users' here isn't an array, it's the table in the db.

          $stmt->bindParam(':username', $username); // username
          $stmt->bindParam(':password', $password); // password
  
          // $this->conn->exec($sql);
          $stmt->execute();
          echo " New record created successfully.";
        } catch(PDOException $e) {
          echo $sql . "<br>" . $e->getMessage();
        }
  
      }
    
  }

  public function select() {
    //hier komt weer een try / catch
    //bij try, komt SELECT * from games
    //bij catch: error

    $games = [];

    try {
    
      $stmt = $this->conn->prepare("SELECT * FROM games");
      $stmt->execute();
    
      // set the resulting array to associative
      //Dit maakt van een resultset een Array (lijst)
      $results = $stmt->setFetchMode(PDO::FETCH_ASSOC);
      //dit zorgt ervoor dat $result gevult wordt met alle data in een array
      $results = $stmt->fetchAll();

      foreach($results as $result) {
        $game = new Game($result['id'], $result['image'], $result['username'], $result['password'], $result['platform'], $result['release_year'], $result['rating'], $result['price']);
        array_push($games, $game);
      }

      return $games;

    } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
    }

  }
  
  public function getGame($id) {

    try {
    
      $stmt = $this->conn->prepare("SELECT * FROM games WHERE id = $id");
      $stmt->execute();
    
      // set the resulting array to associative
      //Dit maakt van een resultset een Array (lijst)
      $results = $stmt->setFetchMode(PDO::FETCH_ASSOC);
      //dit zorgt ervoor dat $result gevult wordt met alle data in een array
      $results = $stmt->fetchAll();

      return $results;

    } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
    }

  }
  
}

?>