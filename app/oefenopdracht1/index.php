
<?php

$host = "mysql"; // Le host est le nom du service, présent dans le docker-compose.yml
$dbname = "my-wonderful-website";
$charset = "utf8";
$port = "3306";

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

<h2>Hello world!</h2>

<form action="index.php" method="post" enctype="multipart/form-data">

<label for="username">Username:</label><br>
<input type="text" class="textfield" name="username" required>

<br>

<label for="password">Password:</label><br>
<input type="password" class="textfield" name="password" required>

<br>

<button type="submit" class="button">Login</button>

</form>

<?php

// if ($_SERVER["REQUEST_METHOD"] == "POST") { }

?>

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