
<?php

spl_autoload_register(function ($class) {
    include 'classes/' . $class . '.php';
});

?>

<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
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

<h1>Get registered</h1>

<form action="Formhandling.php" method="post" enctype="multipart/form-data">

<p>Please pick a username. You can use letters and numbers,<br>
   but no special characters with the exception of underscores are allowed.
</p>

<br>

<label for="username">Username:</label><br>
<input type="text" class="textfield" name="username" required><br>

<p>Please choose a password, and make sure to remember it and keep it safe.<br>
   Please use a combination of letters, numbers, and special characters,<br>
   and make sure it's at least 8 characters long.
</p>

<br>

<label for="password">Password:</label><br>
<input type="password" class="textfield" name="password" required><br>

<label for="passwordRepeat">Repeat password:</label><br>
<input type="password" class="textfield" name="passwordRepeat" required><br>

<br>

<button type="submit" class="button">Register</button>

</form>

<br>

<p>Don't have an account?</p>
<br>
<a href="">Get registered</a>
<br><br>

<p>Forgot your password?</p>
<br>
<a href="">I forgot my password</a>
<br><br>

</body>

</html>