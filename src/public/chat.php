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
    <div id="game-list" class="search2" style="overflow-y: scroll;"></div>
</header>

<?php include_once("includes/menu.php") ?>
</body>

<script>
    /**
     * This function reloads the messages every 500ms
     */
    setInterval(function(){
        getChatMessages()
    }, 500);

    /**
     * This function gets all the user's games and display them
     */
    function getChatMessages() {
        let playerId = <?= $sessionId ?>;

        const request = new XMLHttpRequest();
        request.open('GET', '/api/GetChatMessages.php', false);  // `false` makes the request synchronous
        request.send(null);

        if (request.status === 200) {
            let games = JSON.parse(request.responseText);

            console.log(games);

            document.getElementById('game-list').innerHTML = '';

            for (let i = 0; i < games.length; i++) {
                let username = games[i]['username'];
                let message = games[i]['message'];

                document.getElementById('game-list').innerHTML += '<br><a><b>' + username + '</b>: ' + message + '</a>';
                //document.getElementById('total-games').innerHTML = 'Total games: ' + games.length;
            }
            return true;
        }
        return false;
    }
    getChatMessages();


</script>

</html>
