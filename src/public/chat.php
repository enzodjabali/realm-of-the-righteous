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

        p {
            font-size: 17px;
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

        .message {
            background-color: red;
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
    </div>

    <br>
    <div id="message-list" class="search2" style="overflow-y: scroll;"></div>

    <form class="message">
        <input type="text" value="Type a message...">
        <input type="submit">
    </form>
</header>



<?php include_once("includes/menu.php") ?>
</body>

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

                for (let i = 0; i < chatMessages.length; i++) {
                    let username = chatMessages[i]['username'];
                    let message = chatMessages[i]['message'];

                    document.getElementById('message-list').innerHTML += '<br><a><b>' + username + '</b>: ' + message + '</a>';
                }
            });
        });
    }, 500);

    /**
     * This function calls the chat message insert method
     * If the insert method success the player's message is sent, if not an error message is displayed
     */
    $(function(){
        $("#login-form").submit(function(){
            let username = $(this).find("input[name=username]").val();
            let password = $(this).find("input[name=password]").val();

            $.post("api/LoginPlayer.php", {username: username, password: password}, function(response){
                let PlayerId = JSON.parse(response.substring(response.indexOf("{"), response.lastIndexOf("}") + 1))["playerId"];

                if (PlayerId > 0) {
                    //success
                    window.location.href = "/lobby";
                } else {
                    // error
                    let modal = document.getElementById("modal");
                    let modalMessage = document.getElementById("modalMessage");

                    modalMessage.innerHTML = "Wrong username or password, please try again.";
                    modal.style.display = "block"
                }
            });
            return false;
        });
    });

</script>

</html>
