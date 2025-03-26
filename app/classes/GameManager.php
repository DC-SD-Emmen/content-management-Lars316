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

        $stmt = $this->conn->prepare("INSERT INTO games (image, title, genre, platform, release_year, rating, price)
        VALUES (:image, :title, :genre, :platform, :release_year, :rating, :price)");

        $stmt->bindParam(':image', $fileName);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':genre', $genre);
        $stmt->bindParam(':platform', $platform);
        $stmt->bindParam(':release_year', $release_year);
        $stmt->bindParam(':rating', $rating);
        $stmt->bindParam(':price', $price);

        $stmt->execute();
        echo " New record created successfully.";
      } catch(PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
      }

    }
  
  }

  public function select() {

    $games = [];

    try {
    
      $stmt = $this->conn->prepare("SELECT * FROM games");
      $stmt->execute();
    
      $results = $stmt->setFetchMode(PDO::FETCH_ASSOC);
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
    // The comments in this function (and also rest of the code) are I think from ChatGPT...? Might be from somewhere else tho.

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
    
      $results = $stmt->setFetchMode(PDO::FETCH_ASSOC);
      $results = $stmt->fetchAll();

      return $results;

    } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
    }

  }

  public function getGameUsers($id) {
    // This function gets all the users who have a specific game in their personal library.
    // Due to it not really adding much and privacy reasons, it isn't actually ever called, but I could reuse it at a later date.

    try {

      $stmt = $this->conn->prepare("SELECT users.username FROM users INNER JOIN user_games ON users.id = user_games.user_id WHERE user_games.game_id = $id;");

      $stmt->execute();

      $stmt->setFetchMode(PDO::FETCH_ASSOC);
      return $stmt->fetchAll();
    
    } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
    }

  }

  public function addGameToFavs($user_id, $game_id) {

    try {

      $stmt = $this->conn->prepare("INSERT INTO user_games (user_id, game_id) VALUES (:user_id, :game_id)");

      $stmt->bindParam(':user_id', $user_id);
      $stmt->bindParam(':game_id', $game_id);

      $stmt->execute();

    } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
    }

  }

  public function isGameInFavs($user_id, $game_id) {

    try {

      $stmt = $this->conn->prepare("SELECT COUNT(*) FROM user_games WHERE user_id = :user_id AND game_id = :game_id");

      $stmt->bindParam(':user_id', $user_id);
      $stmt->bindParam(':game_id', $game_id);
      
      $stmt->execute();
      return $stmt->fetchColumn() > 0;

    } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
    }

  }

  public function removeGameFromFavs($user_id, $game_id) {

    try {

    $stmt = $this->conn->prepare("DELETE FROM user_games WHERE user_id = :user_id AND game_id = :game_id");

    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':game_id', $game_id);

    $stmt->execute();

    } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
    }

  }
 
}

?>