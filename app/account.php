<?php

session_start();

if (!isset($_SESSION['username']) || !isset($_SESSION['userid'])) {
    header("Location: index.php");
    exit();
}

$username = $_SESSION['username'];

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

<div id=libraryHeader>
            
    <a href="homepage.php">
        <img id=back_arrow src="backtohomepage.png" alt="Back to homepage">
    </a>

    <p class="header">Your Game Library Account</p>

    <a href="account.php">
        <img id="account" src="AccountIcon.png" alt="Account">
    </a>
    
</div>   


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
            include 'add_game.php';
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

<div id='wishlistContainer'>

    <?php

        $userManager = new UserManager($db);

        $user = $userManager->getUser($username);

        $email = $user['email'];
        $displayedUsername = $user['username'];
        
    ?>

</div>

</div>

<script src='script.js'></script>


</body>
</html>