<?php

if (!isset($_SESSION['username']) || !isset($_SESSION['userid'])) {
    header("Location: index.php");
    exit();
}

?>