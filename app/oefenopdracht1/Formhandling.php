
<?php

spl_autoload_register(function ($class) {
    include 'classes/' . $class . '.php';
});

$db = new Database();
$gameManager = new GameManager($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if($gameManager->fileUpload($_FILES["fileToUpload"])) {

        $gameManager->insert($_POST, $_FILES["fileToUpload"]['name']);

    } else {
        echo "There was an error in the file upload, database entry not uploaded";
    }
    
}

?>