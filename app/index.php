<?php

session_start();

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

        if (password_verify($password, $user['password'])) {
            $_SESSION['userid'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: homepage.php");
            exit();
        } else {
            echo "<p>Login failed.</p>";
        }

    }

}

?>

<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <!-- <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="stylesheet.css"> -->
    <link rel="icon" type="image/icon" href="Keys.png">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    <!-- <script src="jquery-3.7.1.min.js"></script> -->
</head>

<body>

<h1>Login</h1>

<form method="post" enctype="multipart/form-data">

    <p>Please enter your username.</p>

    <label for="username">Username:</label><br>
    <input type="text" class="textfield" name="username" required><br>

    <br>

    <p>Please enter your password.</p>

    <label for="password">Password:</label><br>
    <input type="password" class="textfield" name="password" required><br>

    <br>

    <input type='submit' class='button' name='login' value='Login'>

</form>

<br>

<p>Don't have an account?</p>
<br>
<a href="registration.php">Get registered</a>
<br><br>

<p>Forgot your password?</p>
<br>
<a href="wishlist.php">I forgot my password</a>
<br><br>

</body>

</html>