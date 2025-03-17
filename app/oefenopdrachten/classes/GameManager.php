<?php

class GameManager {
    private $conn;

    public function __construct(Database $db) {
      $this->conn = $db->getConnection();
    }

  public function insert($data, $fileName) {

    $title = htmlspecialchars($data['title']); 
    $genre = htmlspecialchars($data['genre']); 
    $platform = htmlspecialchars($data['platform']);
    $release_year = htmlspecialchars($data['release_year']);
    $rating = htmlspecialchars($data['rating']);
    $price = htmlspecialchars($data['price']);

    $generalRegex = '/(?!<>\/;\\[\\]{}`~)[A-Za-z0-9 ]*/';

    if (!preg_match($generalRegex, $title)) {
      echo "<p>Sorry, the title you filled in contains one or more characters that are not accepted.</p>";
    } else if (!preg_match($generalRegex, $genre)) {
      echo "<p>Sorry, the genre(s) you filled in contain one or more characters that are not accepted.</p>";
    } else if (!preg_match($generalRegex, $platform)) {
      echo "<p>Sorry, the platform(s) you filled contain one or more characters that are not accepted.</p>";
    } else {

      try {
        // use exec() because no results are returned

        //!stmt moet nog worden aangepast om ook de filename in de database te zetten
        $stmt = $this->conn->prepare("INSERT INTO games (image, title, genre, platform, release_year, rating, price)
        VALUES (:image, :title, :genre, :platform, :release_year, :rating, :price)");

        $stmt->bindParam(':image', $fileName);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':genre', $genre);
        $stmt->bindParam(':platform', $platform);
        $stmt->bindParam(':release_year', $release_year);
        $stmt->bindParam(':rating', $rating);
        $stmt->bindParam(':price', $price);

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
        $game = new Game($result['id'], $result['image'], $result['title'], $result['genre'], $result['platform'], $result['release_year'], $result['rating'], $result['price']);
        array_push($games, $game);
      }

      return $games;

    } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
    }

  }

  public function fileUpload($file) {

    //target dir locatie waar het plaatje wordt neergezet
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($file["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($file["tmp_name"]);
    if($check !== false) {
      echo "File is an image - " . $check["mime"] . ".";
      $uploadOk = 1;
    } else {
      echo "File is not an image.";
      $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
      echo "Sorry, file already exists.";
      $uploadOk = 0;
    }

    // Check file size
    if ($file["size"] > 500000) {
      echo "Sorry, your file is too large.";
      $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
      echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
      echo "Sorry, your file was not uploaded.";
      return false;
    // if everything is ok, try to upload file
    } else {
      if (move_uploaded_file($file["tmp_name"], $target_file)) {
        echo "The file ". htmlspecialchars( basename( $file["name"])). " has been uploaded.";
        return true;
      } else {
        echo "Sorry, there was an error uploading your file.";
        return false;
      }
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

  public function getUserGames($sessionID) {

    $stmt = $this->conn->prepare("SELECT games.title FROM games INNER JOIN user_games ON games.id = user_games.game_id WHERE user_games.user_id = $sessionID");

    $stmt->execute();

    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    return $stmt->fetch();

  }

}

// return this->conn
// this->conn $db getConnection

?>