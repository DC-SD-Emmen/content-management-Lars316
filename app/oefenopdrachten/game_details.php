<?php

if (!isset($_SESSION['username']) || !isset($_SESSION['userid'])) {
    header("Location: index.php");
    exit();
}
// session user id
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

$gm = new GameManager($db);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Library</title>
    <link rel="icon" type="image/icon" href="controller.jpg">
    <link rel='stylesheet' href='styles.css'>
</head>

<body>

    <a href='homepage.php'>
        <img id=back_arrow src='backtohomepage.png'>
    </a>

    <div id=libraryHeader>
        <p id=libraryName>The National Game Library</p>
    </div>

    <div id="main-container">

        <?php

            $id = $_GET['id'];

            // echo "<p> The ID should be " . $id . " right now.</p>";
            // echo "<br>";

            $gameManager = new GameManager($db);

            $games = $gameManager->select();

            echo "<div id='sideBar'>
                
                <button id='addGame'> Add New Game </button>

                <div>

                    <form method='POST'>

                        <br>

                        <input type='submit' value='Logout' id='logout' name='logout'>

                    </form>

                </div>

                <div id='gameForm'>
                    <?php
                    include 'add_game.php';
                    ?>
                </div><br><br>";

                foreach($games as $data) {

                    echo "<a href='game_details.php?id=".$data->getID()."'>
                        <img class='gameIconSmall' src='uploads/" . $data->getImage() . "'><p class='gameTitle'>" . $data->getTitle() . "</p>
                    </a>";
                
                }

            echo "</div>";

            $gameResult = $gm->getGame($id);

            foreach($gameResult as $game) {

                echo "<div id='detailsContainer'>

                    <div id=quickInfo>

                        <img src='uploads/" . $game['image'] . "' id=gameImage>

                        <div id=gameDetails>

                            <p>Developer: placeholder<br>
                                Publisher: placeholder
                            </p>

                            <br>

                            <p>Release date: " . $game['release_year'] . "</p>

                            <br>

                            <p>Genre(s) (Gameplay): " . $game['genre'] . "<br>
                                Genre(s) (Story): placeholder
                            </p>

                            <br>

                            <p>Platform(s): " . $game['platform'] . "</p>

                        </div>

                    </div>

                    <div>

                        <p id=detailpageGameTitle>Title: " . $game['title'] . "</p>

                        <p>We're no strangers to love<br> 
                        You know the rules and so do I<br>
                        A full commitment's what I'm thinkin' of<br>
                        You wouldn't get this from any other guy<br>
                        I just wanna tell you how I'm feeling<br>
                        Gotta make you understand<br>
                        Never gonna give you up<br>
                        Never gonna let you down<br>
                        Never gonna run around and desert you<br>
                        Never gonna make you cry<br>
                        Never gonna say goodbye<br>
                        Never gonna tell a lie and hurt you<br>
                        We've known each other for so long<br>
                        Your heart's been aching, but you're too shy to say it<br>
                        Inside, we both know what's been going on<br>
                        We know the game and we're gonna play it<br>
                        And if you ask me how I'm feeling<br>
                        Don't tell me you're too blind to see<br>
                        Never gonna give you up<br>
                        Never gonna let you down<br>
                        Never gonna run around and desert you<br>
                        Never gonna make you cry<br>
                        Never gonna say goodbye<br>
                        Never gonna tell a lie and hurt you<br>
                        Never gonna give you up<br>
                        Never gonna let you down<br>
                        Never gonna run around and desert you<br>
                        Never gonna make you cry<br>
                        Never gonna say goodbye<br>
                        Never gonna tell a lie and hurt you<br> 
                        We've known each other for so long<br>
                        Your heart's been aching, but you're too shy to say it<br>
                        Inside, we both know what's been going on<br>
                        We know the game and we're gonna play it<br>
                        I just wanna tell you how I'm feeling<br>
                        Gotta make you understand<br>
                        Never gonna give you up<br>
                        Never gonna let you down<br>
                        Never gonna run around and desert you<br>
                        Never gonna make you cry<br>
                        Never gonna say goodbye<br>
                        Never gonna tell a lie and hurt you<br>
                        Never gonna give you up<br>
                        Never gonna let you down<br>
                        Never gonna run around and desert you<br>
                        Never gonna make you cry<br>
                        Never gonna say goodbye<br>
                        Never gonna tell a lie and hurt you<br>
                        Never gonna give you up<br>
                        Never gonna let you down<br>
                        Never gonna run around and desert you<br>
                        Never gonna make you cry<br>
                        Never gonna say goodbye<br>
                        Never gonna tell a lie and hurt you</p>

                        <p>Additional information:<br>
                            placeholder
                        </p>

                    </div>

                    <div id=gameWorth>

                        <p>Current rating: " . $game['rating'] . "<br>
                            Current price: €" . $game['price'] . 
                        "</p>

                    </div>

                </div>";
                
            }

        // ('d-m-Y', strtotime($row['Day']))

        //  " . $game['developer'] . "
        //  " . $game['publisher'] . "
        //  " . $game['storygenre'] . "
        //  " . $game['description'] . "
        //  " . $game['additional information'] . "

        ?>

    </div>

</body>
</html>