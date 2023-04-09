<?php
    session_start();

    $sessionId = $_SESSION["player_id"] ?? 0;

    if ($sessionId > 0) {
        echo "My ID:" . $_SESSION["player_id"];
        echo "<br>You're connected!";
        echo "<br><a href='/logout'>Logout</a>";
    } else {
        header("Location:/login");
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
    <script src="node_modules/jquery/dist/jquery.js"></script>
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

        .modal-name {
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
            z-index:999;
        }

        .modal-difficulty {
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
            z-index:999;
        }

        .modal-result {
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
            z-index:999;
        }

        .content {
            position: absolute;
            background: white;
            width: 400px;
            padding: 1em 2em;
            border-radius: 4px;
        }
        .modal-name:target {
            visibility: visible;
            opacity: 1;
        }
        .modal-difficulty:target {
            visibility: visible;
            opacity: 1;
        }
        .modal-result:target {
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

                <a href="#name">
                    <div style="background-color: maroon;width: 20%;position: absolute;left: 40%;padding: 20px;border-radius: 25px">Create a new game</div>
                </a>
            </div>

            <form method="post" id="create-game-form">
                <div id="name" class="modal-name">
                    <div class="content">
                        <a style="color: navy;margin-bottom: 10px;">What will you call your game?</a>
                        <input type="text" name="name" style="border-radius: 25px;">
                        <b>
                            <a href="#difficulty">
                                <div class="w3-center" style="background-color: maroon;color: white;width: 20%; border-radius: 25px;">Next</div>
                            </a>
                        </b>
                        <a href="#" class="box-close">×</a>
                    </div>
                </div>
                <div id="difficulty" class="modal-difficulty">
                    <div class="content">
                        <a style="color: navy;">What difficulty do you want?</a>
                        <b>
                            <fieldset>
                                <input type="radio" id="easy" value="1" name="difficulty" checked>
                                <label for="easy">Easy</label><br>
                                <input type="radio" id="normal" value="2" name="difficulty">
                                <label for="normal">Normal</label><br>
                                <input type="radio" id="hard" value="3" name="difficulty">
                                <label for="hard"> Hard</label>
                            </fieldset>
                            <div>
                                <a href="#name" style="float: left">
                                    <div class="w3-center" style="background-color: maroon;color: white;border-radius: 7px;">  Go back  </div>
                                </a>

                                <div style="float: right">
                                    <input type="submit" value="Create"  class="w3-center" style="background-color: maroon;color: white;border-radius: 7px;">
                                </div>
                            </div>
                    </div>
                        </b>
                        <a href="#" class="box-close">×</a>
                    </div>
                </div>
            </form>

            <div id="result" class="modal-result">
                <div class="content">
                    <a id="result-message"></a>
                    <div id="go-back-if-failed"></div>
                    <a href="#" class="box-close">×</a>
                </div>
            </div>

            <br>
            <div class="w3-center search" style="overflow-y: scroll;">Current Games
                <br>
                GAME NAME | WAVE NUMBER | MAP NAME<i class="fa-regular fa-trash"></i><br><hr>
                AMANDA GAME | 3 | CITY STREETS<i class="fa-regular fa-trash"></i><br><hr>
                LEO GAME | 2 | UNDERGROUND FACILITY<i class="fa-regular fa-trash"></i><br><hr>
                HANNAH GAME | 7 | ABANDONED LAB<i class="fa-regular fa-trash"></i><br><hr>
                JACOB GAME | 20 | OASIS TOWN<i class="fa-regular fa-trash"></i><br><hr>
                EMMA GAME | 5 | DARK CASTLE<i class="fa-regular fa-trash"></i><br><hr>
                NATHAN GAME | 4 | MYSTIC LANDS<i class="fa-regular fa-trash"></i><br><hr>
                LILA GAME | 12 | SPACE STATION<i class="fa-regular fa-trash"></i><br><hr>
                ETHAN GAME | 8 | UNDERWATER RUINS<i class="fa-regular fa-trash"></i><br><hr>
                ELLA GAME | 15 | FAIRY FOREST<i class="fa-regular fa-trash"></i><br><hr>
                SEBASTIAN GAME | 3 | TROPICAL BEACH<i class="fa-regular fa-trash"></i>
            </div>

        </header>

        <!-- Navbar (sticky bottom) -->
        <div class="w3-bottom w3-hide-small">
            <div class="w3-bar w3-black w3-center w3-padding w3-opacity-min">
                <a href="/story" style="width:25%" class="w3-bar-item w3-button">The Story</a>
                <a href="#" style="width:50%" class="w3-bar-item w3-button">Match History</a>
                <a href="/credits" style="width:25%" class="w3-bar-item w3-button">Credits</a>
            </div>
        </div>
    </body>

    <script>
        $(function(){
            console.log('heyy!!');

            let playerId = <?= $sessionId ?>;

            $.post("methods/GetGameInformation.php", {playerId: playerId}, function(response){

                //console.log("result" + result);
                let data = JSON.parse(JSON.stringify(response));
                //console.log(test);
            });
        });


        $(function(){
            $("#create-game-form").submit(function(){
                let name = $(this).find("input[name=name]").val();
                let playerId = <?= $sessionId ?>;
                let difficulty = $('input[name="difficulty"]:checked').val();

                $.post("methods/CreateGameMethod.php", {name: name, playerId: playerId, difficulty: difficulty}, function(result){

                    if (result === "1") {
                        //success
                       console.log('succeed!');
                       let modalResult = document.getElementById("result-message");
                       let goBackIfFailedButton = document.getElementById("go-back-if-failed");

                       modalResult.innerHTML = "Your game had been successfully created";
                       goBackIfFailedButton.innerHTML = '';

                        window.location = "#result";
                    } else {
                        let modalResult = document.getElementById("result-message");
                        let goBackIfFailedButton = document.getElementById("go-back-if-failed");

                        modalResult.innerHTML = result;
                        goBackIfFailedButton.innerHTML = '<a href="#difficulty" style="float: left"><div class="w3-center" style="background-color: maroon;color: white;border-radius: 7px;">Go back</div></a>';

                        window.location = "#result";
                    }
                });
                return false;
            });
        });
    </script>

</html>
