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
$userManager = new UserManager($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['emailN'])) {

        $sessionID = $_SESSION['userid'];
        $emailO = $_POST['emailV']; // POST gets it data via the name, NOT the id.
        $email = $_POST['email'];
        $username = $_POST['usernameV'];
        $password = $_POST['passwordV'];

        $userManager->changeEmail($sessionID, $emailO, $email, $username, $password);
        // Just a heads up, the $emailO stores the old email to be checked, and just $email stores the new one.
        // I did it this way so I can reuse a function in the usermanager class.
        // This applies to the other $[BLANK]O and $[BLANK] variables as well.

    }

    if (isset($_POST['usernameN'])) {

        $sessionID = $_SESSION['userid'];
        $email = $_POST['emailV'];
        $usernameO = $_POST['usernameV'];
        $username = $_POST['username'];
        $password = $_POST['passwordV'];

        $userManager->changeUsername($sessionID, $email, $usernameO, $username, $password);

    }

    if (isset($_POST['passwordN'])) {

        $sessionID = $_SESSION['userid'];
        $email = $_POST['emailV'];
        $username = $_POST['usernameV'];
        $passwordO = $_POST['passwordV'];
        $password = $_POST['password'];

        $userManager->changePassword($sessionID, $email, $username, $passwordO, $password);

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

    <button class='pageButtons' id='addGame'> Add New Game </button>

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

        <label for="emailO">Your old email:</label><br> <!-- the label knows what it is for via the id of the input -->
        <input type="email" class="input" name="emailV" id="emailO" required><br>

        <br>

        <label for="email">Your new email:</label><br>
        <input type="email" class="input" name="email" id="email" required><br>

        <br>

        <label for="usernameV">Your username:</label><br>
        <input type="text" class="input" name="usernameV" id="usernameV" required><br>

        <br>

        <label for="passwordV">Your password:</label><br>
        <input type="password" class="input" name="passwordV" id="passwordV" required><br>

        <br>

        <input type='submit' class='loginNregister' name='emailN' value='Change email'>
    
    </form>

    <br>

    <!-- USERNAME -->

    <form method="post" enctype="multipart/form-data">

        <p>Do you want to change your username? Then please fill in your account details so we can make sure you are who you say you are.<br>
        These details must also include your old username. After that, you can enter in your new username.</p>

        <label for="emailV">Your email:</label><br>
        <input type="email" class="input" name="emailV" id="emailV" required><br>

        <br>

        <label for="usernameO">Your old username:</label><br>
        <input type="text" class="input" name="usernameV" id="usernameO" required><br>

        <br>

        <label for="username">Your new username:</label><br>
        <input type="text" class="input" name="username" id="username" required><br>

        <br>

        <label for="passwordC">Your password:</label><br> <!-- had to change up the id's here so the code will stop complaining. -->
        <input type="password" class="input" name="passwordV" id="passwordC" required><br>

        <br>

        <input type='submit' class='loginNregister' name='usernameN' value='Change username'>
    
    </form>

    <br>

    <!-- PASSWORD -->

    <form method="post" enctype="multipart/form-data">

        <p>Do you want to change your password? Then please fill in your account details so we can make sure you are who you say you are.<br>
        These details must also include your old password. After that, you can enter in your new password.</p>

        <label for="emailC">Your email:</label><br>
        <input type="email" class="input" name="emailV" id="emailC" required><br>

        <br>

        <label for="usernameC">Your username:</label><br>
        <input type="text" class="input" name="usernameV" id="usernameC" required><br>

        <br>

        <label for="passwordO">Your old password:</label><br>
        <input type="password" class="input" name="passwordV" id="passwordO" required><br>

        <br>

        <label for="password">Your new password:</label><br>
        <input type="password" class="input" name="password" id="password" required><br>

        <br>

        <input type='submit' class='loginNregister' name='passwordN' value='Change password'>
    
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