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
    // Have to make make different issets so you don't change your password to your email or something like that.

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

    if (isset($_POST['affirmative'])) {

        $sessionID = $_SESSION['userid'];
        $email = $_POST['emailV'];
        $username = $_POST['usernameV'];
        $password = $_POST['passwordV'];

        $userManager->deleteAccount($sessionID, $email, $username, $password);

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
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <!-- Gotta use some jQuery for the confirmation div. I would use a library so it can work offline, but if something relating to this site is offline,
    the site probably wouldn't be working anyway, so... 
    (Also if you wondering why the comments have a newline where they do, it's because that way it fits on screen in Visual Studio Code and makes my OCD happy.)-->
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
            require_once 'add_game.php';
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

                    echo "<a href='game_details.php?id=".$data->getID()."' class='sideBarGame'>
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
        <!-- would probably be a good idea to change the name of the class since it isn't used only for login and signup -->
    
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

    <form id='deleteForm' method="post" enctype="multipart/form-data">

        <p>Do you want to delete your account? Then please fill in your account details so we can make sure you are who you say you are.</p>

        <label for="emailD">Your email:</label><br>
        <input type="email" class="input" name="emailV" id="emailD" required><br>

        <br>

        <label for="usernameD">Your username:</label><br>
        <input type="text" class="input" name="usernameV" id="usernameD" required><br>

        <br>

        <label for="passwordD">Your password:</label><br>
        <input type="password" class="input" name="passwordV" id="passwordD" required><br>

        <br>

        <button id='deleteButton' class="loginNregister" name="deleteAccount">Delete account?</button>

        <div id='deleteAccountConfirmation' style='display: none;'>

            <div class='textFieldContainer'>
                <p>Are you absolutely sure you want to delete your account?<br>
                This action cannot be undone!</p>
            </div>

            <div id='confirmationButtons'>
                <!-- I'm going to try changing only the affirmative button to submit to see if that works. If it does that be stupid, but oh well. -->
                <!-- LMAO it actually worked -->
                <input type='submit' class='confirmationButton' id='affirmative' name='affirmative' value='Yes'>
                <button class='confirmationButton' id='negative'>No</button>
            </div>

        </div>

    </form>

</div>

<script src='script.js'></script>

</body>
</html>