<?php

session_start(); // Have to again call session_start(), otherwise this page doesn't work.

if (!isset($_SESSION['username']) || !isset($_SESSION['userid'])) {
    header("Location: index.php");
    exit();
}

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if(isset($_POST['addToFavs'])) {

        $user_id = $_SESSION['userid'];
        $game_id = $_GET['id'];

        $gm->addGameToFavs($user_id, $game_id);

        echo "<p>This game has been added to your library.</p>";

    }

    if(isset($_POST['removeFromFavs'])) {

        $user_id = $_SESSION['userid'];
        $game_id = $_GET['id'];
    
        // Even tho there wouldn't be any errors if I didn't check, I still thought it'd be a nice feature to check if the game is already in the library.
        if ($gm->isGameInFavs($user_id, $game_id)) {
            $gm->removeGameFromFavs($user_id, $game_id);
            echo "<p>This game has been removed from your library.</p>";
        } else {
            echo "<p>This game is not in your library. Can't remove what ain't there.</p>";
        }
    
    }
    
}

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

    <div id=libraryHeader>
            
        <a href="homepage.php">
            <img class="back_arrow" src="backtohomepage.png" alt="Back to homepage">
        </a>
 
        <p class="header">The National Game Library</p>

        <a href="account.php">
            <img id="account" src="AccountIcon.png" alt="Account">
        </a>

    </div>

    <div id="main-container">

        <?php

            $id = $_GET['id'];

            // echo "<p> The ID should be " . $id . " right now.</p>";
            // echo "<br>";

            $gameManager = new GameManager($db);

            $games = $gameManager->select();

            echo "<div id='sideBar'>

                <div>

                    <form method='POST'>

                        <input type='submit' value='Logout' id='logout' name='logout'>

                    </form>

                </div>

                <br>
        
                <button class='pageButtons' id='addGame'> Add New Game </button>

                <div id='gameForm' style='display: none;'>";
                    
                    require_once 'add_game.php';
                    
                echo "</div>
                
                <br><br>

                <a href='your_games.php' class='pageButtons'>
                    <button class='pageButtons'> Your Library </button>
                </a>
            
                <br><br>";

                foreach($games as $data) {

                    echo "<a href='game_details.php?id=".$data->getID()."' class='sideBarGame'>
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

                        <p>Description:<br>
                        We're no strangers to love<br> 
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

                        <br>

                        <p>Additional information:<br>
                            It looks like there's nothing to add.
                        </p>

                    </div>

                    <div id=gameWorth>

                        <p>Current rating: " . $game['rating'] . "<br>
                            Current price: €" . $game['price'] . 
                        "</p>

                    </div>

                    <div class='textFieldContainer'>

                    <form method='post'>
                        <label for='addToFavs'>Do you want to add this game to your library?</label>
                        <input type='submit' value='Add to your library' class='pageButtons' id='addToFavs' name='addToFavs'>
                    </form>

                    <br>

                    <form method='post'>
                        <label for='removeFromFavs'>Or do you want to remove this game from your library?</label>
                        <input type='submit' value='Remove from your library' class='pageButtons' id='removeFromFavs' name='removeFromFavs'>
                    </form>

                    <p class=smallBlankSpace></p>

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

    <script src='script.js'></script>

</body>
</html>