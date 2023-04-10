<?php
    session_start();

    $sessionId = $_SESSION["player_id"] ?? 0;

    if (!$sessionId > 0) {
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
            z-index:1;
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
            z-index:1;
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
            z-index:1;
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
        }

        #player-information {
            position: absolute;
            background-color: #fefefe;
            z-index: 1;
            margin-left: 10px;
            margin-top: 10px;
            padding: 20px;
            border-radius: 15px;
        }
    </style>
</head>
    <body>
        <div id="player-information">
            <?php
                echo "My ID: " . $_SESSION["player_id"];
                echo "<br>" . $_SESSION["player_username"];
                echo "<br>" . $_SESSION["player_email"];
                ?>
                    <br><a id="total-games"></a>
                <?php
                echo "<br><a href='/logout'>Logout</a>";
            ?>
        </div>

        <!-- Header / Home-->
        <header class="w3-display-container w3-wide bgimg w3-grayscale-min" id="home">
            <div class="w3-display-topmiddle w3-text-white w3-center">

                <h1 class="w3-jumbo" style="color: navy;font-family: 'Old English Text MT'">Realm Of The Righteous</h1>

                <a href="#name">
                    <div style="background-color: maroon;width: 20%;position: absolute;left: 40%;padding: 20px;border-radius: 25px">New game</div>
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
                        <a href="" class="box-close">×</a>
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
                        <a href="" class="box-close">×</a>
                    </div>
                </div>
            </form>

            <div id="result" class="modal-result">
                <div class="content">
                    <a id="result-message"></a>
                    <div id="go-back-if-failed"></div>
                    <a href="" class="box-close">×</a>
                </div>
            </div>

            <br>
            <div id="game-list" class="w3-center search" style="overflow-y: scroll;"><b>Current games:</b></div>
        </header>

        <?php include_once("includes/menu.php") ?>
    </body>

    <script>
        /**
         * This function gets all the user's game and display them
         */
        $(function(){
            let playerId = <?= $sessionId ?>;

            $.post("methods/GetGameInformation.php", {playerId: playerId}, function(response){
                let games = JSON.parse(JSON.stringify(response));

                for (let i = 0; i < games.length; i++) {
                    let id = games[i]['id'];
                    let name = games[i]['name'];

                    document.getElementById('game-list').innerHTML += '<br><a href="game.php?game_id=' + id + '">' + name + '</a>';
                    document.getElementById('total-games').innerHTML = 'Total games: ' + games.length;
                }
            });
        });

        /**
         * This function makes a call to create a new game
         */
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
