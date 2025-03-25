<?php

session_start();

if (!isset($_SESSION['username']) || !isset($_SESSION['userid'])) {
    header("Location: index.php");
    exit();
}

$sessionID = $_SESSION['userid'];
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
$gm = new GameManager($db);

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
 
        <p class="header">' . $sessionUser . '\'s Personal Game Library</p>

        <a href="account.php">
            <img id="account" src="AccountIcon.png" alt="Account">
        </a>

    </div>';

    ?>

    <div id='main-container'>

        <?php
        
        $gameManager = new GameManager($db);

        $games = $gameManager->select();

        ?>

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
            </div><br><br>

            <div id="sidebarforSmallScreen">

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

                $userManager = new UserManager($db);

                $games = $userManager->getUserGames($sessionID);

                foreach($games as $data) {

                    echo "<a href='game_details.php?id=".$data['id']."'>
                        <img class='gameIcon' src='uploads/" . $data['image'] . "'>
                    </a>";

                }
                
            ?>

        </div>

    </div>

    <script src='script.js'></script>
   
</body>

</html>