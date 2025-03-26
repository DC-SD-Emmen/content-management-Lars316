<?php

spl_autoload_register(function ($class) {
    require_once 'classes/' . $class . '.php';
});

session_start();

$db = new Database();
$userManager = new UserManager($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $userManager->insert($_POST);

}

?>

<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Library</title>
    <!-- <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet"> -->
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" type="image/icon" href="controller.jpg">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    <!-- <script src="jquery-3.7.1.min.js"></script> -->
</head>

<body>

<div id=libraryHeader>
        
    <a href="index.php">
        <img class="back_arrow" src="backtohomepage.png" alt="Back to homepage">
    </a>

    <p class="header">Get your account for the National Game Library!</p>

    <a href="account.php">
        <img id="account" src="AccountIcon.png" alt="Account">
    </a>

</div>

<div class="loginNregisterContainer">

    <div class="loginNregisterForm">

        <p class="header">Sign up</p>

        <form method="post" enctype="multipart/form-data">

            <div class="textFieldContainer">

                <p>Please enter your email.
                    This is useful in cases like losing access to<br>
                    your account, or forgetting your password.
                    <br><br>
                    Do keep in mind though, that our email system only allows<br>
                    letters, numbers, the special characters '-' and '_',<br>
                    and your email must contain an '@', and at least one period after the '@'.<br>
                    If your email adress does not follow these rules,<br>
                    please contact support to see what we can do.
                </p>

                <label for="email">Email:</label><br>
                <input type="email" class="input" name="email" id="email" required><br>

                <br>

                <p>Please pick a username. You can use letters and numbers,<br>
                but no special characters with the exception of underscores are allowed.
                </p>

                <label for="username">Username:</label><br>
                <input type="text" class="input" name="username" id="username" required><br>

                <br>

                <p>Please choose a password, and make sure to remember it and keep it safe.<br>
                Please use a combination of letters, numbers, and special characters,<br>
                and make sure it's at least 8 characters long.
                </p>

                <label for="password">Password:</label><br>
                <input type="password" class="input" name="password" id="password" required><br>

                <!-- <label for="passwordRepeat">Repeat password:</label><br>
                <input type="password" class="input" name="passwordRepeat" required><br> -->
                <!-- Okay since Google is refusing to give me an anwser on how to compare the inputs, this idea is gonna have to be saved until later. -->

                <br>

                <button type="submit" class="loginNregister">Sign up</button>

            </div>

        </form>

    </div>

</div>

</body>

</html>