<?php

session_start(); // Once logged in is when the session actually starts proper.

if (!isset($_SESSION['username']) || !isset($_SESSION['userid'])) {
    header("Location: index.php");
    exit(); // It then also sets the session variables for various uses.
}

$sessionUser = $_SESSION['username'];

if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}

spl_autoload_register(function ($class) {
    require_once 'classes/' . $class . '.php';
});

$db = new Database();
$gameManager = new GameManager($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if($gameManager->fileUpload($_FILES["fileToUpload"])) {

        $gameManager->insert($_POST, $_FILES["fileToUpload"]['name']);

    } else {
        echo "There was an error in the file upload, database entry not uploaded";
    }
    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Library</title>
    <link rel="icon" type="image/icon" href="controller.jpg">
    <link rel='stylesheet' href='styles.css'>
</head>

<body>

    <?php

    echo '<div id=libraryHeader>
            
        <a href="homepage.php">
            <img class="back_arrow" src="backtohomepage.png" alt="Back to homepage">
        </a>

        <!-- <div class="backarrow"></div> -->
 
        <p class="header">Welcome, ' . $sessionUser . ', to the National Game Library!!!</p>

        <a href="account.php">
            <img id="account" src="AccountIcon.png" alt="Account">
        </a>

    </div>';

    ?>

    <?php
        $games = $gameManager->select();
    ?>

    <div id='main-container'>

        <div id='sideBar'>

            <div>

                <form method="POST">

                    <input type="submit" value="Logout" id="logout" name="logout">

                </form>

            </div>

            <br>

            <button class='pageButtons' id='addGame'> Add New Game </button>

            <div id='gameForm' style='display: none;'>
                <?php
                    require_once 'add_game.php';
                ?>
            </div>
            
            <br><br>

            <a href="your_games.php" class='pageButtons'>
                <button class='pageButtons'> Your Library </button>
            </a>

            <br><br>

            <div id="sidebarforSmallScreen">

                <div id="sidebarContent">

                    <?php
                        foreach($games as $data) {

                            echo "<a href='game_details.php?id=".$data->getID()."' class='sideBarGame'>
                                <img class='gameIconSmall' src='uploads/" . $data->getImage() . "'><p class='gameTitle'>" . $data->getTitle() . "</p>
                            </a>";
                    
                        }
                    ?>

                </div>

            </div>

        </div>

        <div id='gameIcons'>

            <?php
                foreach($games as $data) {

                    echo "<a href='game_details.php?id=".$data->getID()."'>
                      <img class='gameIcon' src='uploads/" . $data->getImage() . "'>
                    </a>";
                    
                }
            ?>

        </div>

    </div>

    <script src='script.js'></script>

</body>
</html>