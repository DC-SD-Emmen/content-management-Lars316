
<?php

spl_autoload_register(function ($class) {
    include 'classes/' . $class . '.php';
});

$db = new Database();
$dataManager = new DataManager($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if($dataManager->fileUpload($_FILES["fileToUpload"])) {

        $dataManager->insert($_POST, $_FILES["fileToUpload"]['name']);

    } else {
        echo "There was an error in the file upload, database entry not uploaded";
    }
    
}

?>