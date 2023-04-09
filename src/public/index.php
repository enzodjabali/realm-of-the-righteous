<?php
    session_start();
    echo "My ID:" . $_SESSION["player_id"];

    if ($_SESSION["player_id"]) {
        echo "<br>You're connected!";
    }
?>


<!DOCTYPE html>
<html>
<head>
    <title>Realm of the righteous - Lobby</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="icon" type="image/x-icon" href="assets/images/website/favicon.ico">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="assets/css/gamesearch.css">
    <style>
        body,h1,h2{font-family: "Raleway", sans-serif}
        body, html {height: 100%}
        p {line-height: 2}
        .bgimg{
            min-height: 100%;
            background-position: center;
            background-size: cover;
        }
        .bgimg {background-image: url("assets/images/website/frame.jpg  ")}
        .box {
            background-color: black;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        p {
            font-size: 17px;
            align-items: center;
        }

        .modal {
            align-items: center;
            display: flex;
            justify-content: center;
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.5);
            transition: all 0.4s;
            visibility: hidden;
            opacity: 0;
            z-index:999
        }

        .modal2 {
            align-items: center;
            display: flex;
            justify-content: center;
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.5);
            transition: all 0.4s;
            visibility: hidden;
            opacity: 0;
            z-index:999
        }

        .content {
            position: absolute;
            background: white;
            width: 400px;
            padding: 1em 2em;
            border-radius: 4px;
        }
        .modal:target {
            visibility: visible;
            opacity: 1;
        }
        .modal2:target {
            visibility: visible;
            opacity: 1;
        }
        .box-close {
            position: absolute;
            top: 0;
            right: 15px;
            color: #fe0606;
            text-decoration: none;
            font-size: 30px;

    </style>
</head>
    <body>
        <!-- Header / Home-->
        <header class="w3-display-container w3-wide bgimg w3-grayscale-min" id="home">
            <div class="w3-display-topmiddle w3-text-white w3-center">

                <h1 class="w3-jumbo" style="color: navy;font-family: 'Old English Text MT'">Realm Of The Righteous</h1>
                <h2 class="w3-center" style="color: navy">The best tower defense in all the realm</h2>
                <br><h2 style="color: navy">Your games</h2>

                <a href="#popup-box">
                    <div style="background-color: maroon;width: 20%;position: absolute;left: 40%;padding: 20px;border-radius: 25px">Create a new game</div>
                </a>
            </div>

            <div id="popup-box" class="modal">
                <div class="content">
                    <h1 style="color: navy;">
                        What will you call your game
                    </h1>
                    <input type="text" id="gamename" style="border-radius: 25px;">
                    <b>
                        <a href="#popup-box2">

                            <div class="w3-center" style="background-color: maroon;color: white;width: 20%; border-radius: 25px;">ok!</div>
                        </a>
                    </b>
                    <a href="#"
                       class="box-close">
                        ×
                    </a>
                </div>
            </div>
            <div id="popup-box2" class="modal2">
                <div class="content">
                    <h1 style="color: navy;">
                        What difficulty do you want
                    </h1>
                    <b>
                        <form>
                            <input type="radio" id="easy" name="difficulty">
                            <label for="easy">Easy</label><br>
                            <input type="radio" id="medium" name="difficulty">
                            <label for="medium">Normal</label><br>
                            <input type="radio" id="hard" name="difficulty">
                            <label for="hard"> Hard</label>
                        </form>
                        <a href="">

                            <div class="w3-center" style="background-color: maroon;color: white;width: 35% ;border-radius: 7px;">  Let's go !  </div>
                        </a>
                    </b>
                    <a href="#"
                       class="box-close">
                        ×
                    </a>
                </div>
            </div>
            <br>
            <div class="w3-center search">Current Games</div>

        </header>

        <!-- Navbar (sticky bottom) -->
        <div class="w3-bottom w3-hide-small">
            <div class="w3-bar w3-black w3-center w3-padding w3-opacity-min">
                <a href="story.html" style="width:25%" class="w3-bar-item w3-button">The Story</a>
                <a href="#" style="width:50%" class="w3-bar-item w3-button">Match History</a>
                <a href="credits.html" style="width:25%" class="w3-bar-item w3-button">Credits</a>
            </div>
        </div>

    </body>
</html>

