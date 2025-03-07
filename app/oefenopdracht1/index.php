
<?php

spl_autoload_register(function ($class) {
    require_once 'classes/' . $class . '.php';
});

$db = new Database();
$dataManager = new LoginDataManager($db);
$userManager = new UserManager($db->getConnection());

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $dataManager->insert($_POST);

    if isset($_POST['login']) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $user = $userManager->getUser($username);

        if (password_verify($password, $user['password'])) {
            echo "Login successful.";

            header("Location: index.php");
        } else {
            echo "Login failed.";
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

<form action="index.php" method="post" enctype="multipart/form-data">

<p>Please enter your username.</p>

<label for="username">Username:</label><br>
<input type="text" class="textfield" name="username" required><br>

<br>

<p>Please enter your password.</p>

<label for="password">Password:</label><br>
<input type="password" class="textfield" name="password" required><br>

<!-- <label for="passwordRepeat">Repeat password:</label><br>
<input type="password" class="textfield" name="passwordRepeat" required><br> -->
<!-- Okay since Google is refusing to give me an anwser on how to compare the inputs, this idea is gonna have to be saved until later. -->

<br>

<button type="submit" class="button">Login</button>

</form>

<br>

<p>Don't have an account?</p>
<br>
<a href="registration.php">Get registered</a>
<br><br>

<p>Forgot your password?</p>
<br>
<a href="">I forgot my password</a>
<br><br>

</body>

</html>