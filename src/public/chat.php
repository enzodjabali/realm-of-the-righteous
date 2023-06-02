<?php
    session_start();

    $sessionId = $_SESSION["player_id"] ?? 0;

    if (!intval($sessionId) > 0) {
        header("Location:/login");
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Realm of the righteous - Lobby</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="assets/css/modal.css">
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

            p {font-size: 17px;}

            #player-information {
                position: absolute;
                background-color: #fefefe;
                z-index: 1;
                margin-left: 10px;
                margin-top: 10px;
                padding: 20px;
                border-radius: 15px;
            }

            .message {
                text-align: center;
                margin-top: 40%;
            }
        </style>
    </head>
    <body>
        <div id="player-information">
            <?php
            echo "My ID: " . $_SESSION["player_id"];
            echo "<br>" . $_SESSION["player_username"];
            echo "<br>" . $_SESSION["player_email"];
            echo "<br><a href='/logout'>Logout</a>";
            ?>
        </div>

        <!-- Header / Home-->
        <header class="w3-display-container w3-wide bgimg w3-grayscale-min" id="home">
            <div class="w3-display-topmiddle w3-text-white w3-center">
                <h1 class="w3-jumbo" style="color: navy;font-family: 'Old English Text MT'">Realm Of The Righteous</h1>
            </div>
            <br>
            <div id="message-list" class="chatbox" style="overflow-y: scroll;"></div>

            <form class="message" method="post" id="chat-form">
                <p>Message</p>
                <input id="messageField" name="message" type="text">
                <input type="submit" value="Send">
            </form>
        </header>

        <!-- Error message modal -->
        <div id="modal" class="modal">

            <div class="modal-content">
                <span class="close">&times;</span>
                <p id="modalMessage"></p>
            </div>
        </div>

        <?php include_once("includes/menu.php") ?>
    </body>

    <script src="js/modal.js"></script>
    <script>
        /**
         * This function reloads the messages every 500ms
         */
        setInterval(function(){
            /**
             * This function gets all the chat messages and display them
             */
            $(function(){
                $.get("api/GetChatMessages.php", function(response) {
                    let chatMessages = response;

                    document.getElementById('message-list').innerHTML = '';

                    let d = new Date();
                    let currentDate = d.getFullYear() + "-" +((d.getMonth()+1).length !== 2 ? "0" + (d.getMonth() + 1) : (d.getMonth()+1)) + "-" + (d.getDate().length !== 2 ?"0" + d.getDate() : d.getDate());

                    for (let i = 0; i < chatMessages.length; i++) {
                        let username = chatMessages[i]['username'];
                        let message = chatMessages[i]['message'];
                        let date = "";

                        if (currentDate === chatMessages[i]['date']) {
                            date = "today";
                        } else {
                            date = chatMessages[i]['date'];
                        }

                        document.getElementById('message-list').innerHTML += '<a><b>' + username + '</b> (' + date + '): ' + message + '</a><br>';
                    }
                });
            });
        }, 500);

        /**
         * This function calls the chat message insert method
         * If the insert method success the player's message is sent, if not an error message is displayed
         */
        $(function(){
            $("#chat-form").submit(function(){
                let playerId = <?= $sessionId ?>;
                let message = $(this).find("input[name=message]").val();

                $.post("api/InsertChatMessage.php", {playerId: playerId, message: message}, function(response){
                    if (response === "1") {
                        document.getElementById('messageField').value = "";
                    } else {
                        // error
                        let modal = document.getElementById("modal");
                        let modalMessage = document.getElementById("modalMessage");

                        modalMessage.innerHTML = response;
                        modal.style.display = "block"
                    }
                });
                return false;
            });
        });
    </script>
</html>
