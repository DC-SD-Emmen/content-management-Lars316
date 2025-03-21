<?php

session_start();

if (!isset($_SESSION['username']) || !isset($_SESSION['userid'])) {
    header("Location: index.php");
    exit();
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

    <p class="header">' . $sessionUser . '\'s Game Library Account</p>

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

    <button class='pageButtons' id='addGame'> Add new Game </button>

    <div id='gameForm' style='display: none;'>
        <?php
            include 'add_game.php';
        ?>
    </div><br><br>

    <a href="your_games.php" class='pageButtons'>
        <button class='pageButtons'> Your Library </button>
    </a>

    <br><br>

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

<div id='accountContainer'>

    <!-- EMAIL -->

    <form method="post" enctype="multipart/form-data">

        <p>Do you want to change your email? Then please fill in your account details so we can make sure you are who you say you are.<br>
        These details must also include your old email. After that, you can enter in your new email.</p>

        <label for="emailV">Your old email:</label><br>
        <input type="emailV" class="input" name="emailV" id="emailV" required><br>

        <br>

        <label for="email">Your new email:</label><br>
        <input type="email" class="input" name="email" id="email" required><br>

        <br>

        <label for="usernameV">Your username:</label><br>
        <input type="text" class="input" name="usernameV" id="usernameV" required><br>

        <br>

        <label for="passwordV">Your password:</label><br>
        <input type="passwordV" class="input" name="passwordV" id="passwordV" required><br>

        <br>

        <button type="submit" class="loginNregister">Change email</button>
    
    </form>

    <br>

    <!-- USERNAME -->

    <form method="post" enctype="multipart/form-data">

        <p>Do you want to change your username? Then please fill in your account details so we can make sure you are who you say you are.<br>
        These details must also include your old username. After that, you can enter in your new username.</p>

        <label for="emailV">Your email:</label><br>
        <input type="emailV" class="input" name="emailV" id="emailV" required><br>

        <br>

        <label for="usernameV">Your old username:</label><br>
        <input type="text" class="input" name="usernameV" id="usernameV" required><br>

        <br>

        <label for="username">Your new username:</label><br>
        <input type="text" class="input" name="username" id="username" required><br>

        <br>

        <label for="passwordV">Your password:</label><br>
        <input type="passwordV" class="input" name="passwordV" id="passwordV" required><br>

        <br>

        <button type="submit" class="loginNregister">Change username</button>
    
    </form>

    <br>

    <!-- PASSWORD -->

    <form method="post" enctype="multipart/form-data">

        <p>Do you want to change your password? Then please fill in your account details so we can make sure you are who you say you are.<br>
        These details must also include your old password. After that, you can enter in your new password.</p>

        <label for="emailV">Your email:</label><br>
        <input type="emailV" class="input" name="emailV" id="emailV" required><br>

        <br>

        <label for="usernameV">Your username:</label><br>
        <input type="text" class="input" name="usernameV" id="usernameV" required><br>

        <br>

        <label for="passwordV">Your old password:</label><br>
        <input type="passwordV" class="input" name="passwordV" id="passwordV" required><br>

        <br>

        <label for="password">Your new password:</label><br>
        <input type="password" class="input" name="password" id="password" required><br>

        <br>

        <button type="submit" class="loginNregister">Change password</button>
    
    </form>

    <br>

    <?php

        // $userManager = new UserManager($db);

        // $user = $userManager->getUser($username);

        // $email = $user['email'];
        // $displayedUsername = $user['username'];
        
    ?>

</div>

</div>

<script src='script.js'></script>


</body>
</html>