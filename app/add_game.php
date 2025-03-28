<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Library</title>
    <link rel="icon" type="image/icon" href="controller.jpg">
</head>

<body>

    <p id="formHeader">Have a game you'd like to add to the library?<br>
        Well, just fill in this form,<br>
        and your game should appear on the list.
    </p>

    <br>

    <div id="formContainer">

        <form action="index.php" method="post" enctype="multipart/form-data">

            <div id='uploadImg'>
                <label for='fileToUpload' class="custom-file-upload">Image Upload</label><br>
                <input type="file" name="fileToUpload" id="fileToUpload" required>
            </div>

            <br>
            
            <div class='textFieldContainer'>
                <label for="title">Title:</label><br>
                <input type="text" class="input" id="title" name="title" required>
            </div>

            <br>

            <div class='textFieldContainer'>
                <label for="release-year">Release date:</label><br>
                <input type="date" class="input" id="release-year" name="release-year" required>
            </div>

            <br>

            <!-- <div class='textFieldContainer'>
                <label for="storyGenre">Genre(s) (Story) (Not required if the game has no story):</label><br>
                <input type="text" class="input" id="storyGenre" name="storyGenre" placeholder="e.g. fantasy, romance">
            </div>-->

            <div class='textFieldContainer'>
                <label for="playGenre">Genre(s) (Gameplay):</label><br>
                <input type="text" class="input" id="playGenre" name="playGenre" placeholder="e.g. platformer, sandbox" required>
            </div>

            <br>

            <div class='textFieldContainer'>
                <label for="platform">Platform(s):</label><br>
                <input type="text" class="input" id="platform" name="platform" required>
            </div>

            <!--<br>
            
            <div class='textFieldContainer'>
                <label for="description">Description/Story summary:</label><br>
                <input type="text" class="input" id="description" name="description" placeholder="description/story summary">
            </div>

            <br>

            <div class='textFieldContainer'>
                <label for="addInfo">Additional information (Any extra information that does not fit the other fields. Optional.):</label><br>
                <input type="text" class="input" id-"addInfo" name="addInfo" placeholder="additional information">
            </div>-->

            <br>

            <div class='textFieldContainer'>
                <label for="rating">Rating:</label><br>
                <input type="number" class="input" id="rating" name="rating" step="0.1" required>
            </div>

            <br>

            <div class='textFieldContainer'>
                <label for="price">Price (in euros):</label><br>
                <input type="number" class="input" id="price" name="price" step="0.01" required>
            </div>

            <br>

            <div id="submitAndResetButton">
                <input type="submit" class="submitNreset" name="submit" value="Submit">
                <input type="reset" class="submitNreset" value="Reset">
            </div>

            <br>

        </form>

    </div>

</body>
</html>