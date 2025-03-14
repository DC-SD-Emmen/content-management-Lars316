<?php

session_start();

if (!isset($_SESSION['username']) || !isset($_SESSION['userid'])) {
    header("Location: index.php");
    exit();
}
// session user id
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

    <a href='homepage.php'>
        <img id=back_arrow src='backtohomepage.png'>
    </a>

    <div id=libraryHeader>
        <p id=libraryName>Welcome, to the National Game Library!!!</p>
    </div>

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

            <button id='addGame'> Add New Game </button>

            <div id='gameForm' style='display: none;'>
                <?php
                    include 'add_game.php';
                ?>
            </div><br><br>

            <div id="sidebarforSmallScreen">

                <!-- <button>Menu</button> -->

                <div id="sidebarContent">

                    <?php
                        foreach($games as $data) {

                            echo "<a href='game_details.php?id=".$data->getID()."'>
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