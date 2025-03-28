<?php
// I have tested this site and its functions a lot, but because humans are humans, I can't guarantee that I didn't just miss something,
// or that someone, somehow, finds a way to break the site in a way I couldn't have thought of.

session_start(); // Here I call a session_start() cuz if I only do that once logged in, I doesn't really work.

spl_autoload_register(function ($class) {
    require_once 'classes/' . $class . '.php';
});

$db = new Database();
$userManager = new UserManager($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['login'])) {

        $username = $_POST['username'];
        $password = $_POST['password'];
    
        $user = $userManager->getUser($username);
    
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['userid'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: homepage.php");
            exit();
        } else {
            echo "<p>Sorry, the login failed because you filled in an invalid username and/or password.</p>";
        }
    
    }

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

<!-- I'm pretty sure this code explains itself. -->
<div id=libraryHeader>
    <p class="header">Entering the National Game Library</p>
</div>

<div class="loginNregisterContainer">

    <div class="loginNregisterForm">

        <p class="header">Please login.</p>

        <form method="post" enctype="multipart/form-data">

            <div class="textFieldContainer">

                <p>Please enter your username.</p>

                <label for="username">Username:</label><br>
                <input type="text" class="input" name="username" id="username" required><br>

                <br>

                <p>Please enter your password.</p>

                <label for="password">Password:</label><br>
                <input type="password" class="input" name="password" id="password" required><br>

                <br>

                <input type='submit' class='loginNregister' name='login' value='Login'>

            </div>

        </form>

        <br>

        <div class="textFieldContainer">

            <p>Don't have an account?</p>
            <br>
            <a href="signup.php" class="link">Sign up</a>
            <br><br>

            <p>Forgot your password?</p>
            <br>
            <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" class="link">I forgot my password</a>
            <!-- I didn't actually make anything in case someone forgot their password cause that most likely involve verification via email and such,
            and I think that's a liiittle too complicated for a first-year student. -->
            <br><br>
                
        </div>

    </div>

</div>

</body>

</html>