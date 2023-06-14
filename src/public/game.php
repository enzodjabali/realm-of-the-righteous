<?php
    session_start();

    $sessionId = isset($_SESSION["playerId"]) ? (int)$_SESSION["playerId"] : 0;
    $gameId = isset($_GET["gameId"]) ? (int)$_GET["gameId"] : 0;

    if (!$sessionId > 0) {
        header("Location:/login");
    }

    function getServerUrl(): string
    {
        $protocol = (!empty($_SERVER['HTTPS']) && (strtolower($_SERVER['HTTPS']) == 'on' || $_SERVER['HTTPS'] == '1')) ? 'https://' : 'http://';
        $server = $_SERVER['SERVER_NAME'];
        $port = $_SERVER['SERVER_PORT'] ? ':'.$_SERVER['SERVER_PORT'] : '';
        return $protocol.$server.$port;
    }

    $url = getServerUrl() . "/api/v1/game/doesBelongToPlayer?gameId=$gameId&playerId=$sessionId";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);

    // Proxy for Docker
    curl_setopt($ch, CURLOPT_PROXY, $_SERVER['SERVER_ADDR'] . ':' .  $_SERVER['SERVER_PORT']);

    if (($response = curl_exec($ch)) === false) {
        echo 'Curl error: ' . curl_error($ch);
        die();
    }
    curl_close($ch);

    if (!json_decode($response, true)["response"]) {
        header("Location:/lobby");
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Realm Of The Righteous - In a game</title>
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link rel="icon" type="image/x-icon" href="assets/images/website/favicon.ico">
        <link rel="stylesheet" href="assets/css/board.css">
        <link rel="stylesheet" href="assets/css/hud.css">
        <link href="assets/css/game.css" rel="stylesheet">
        <script src="node_modules/jquery/dist/jquery.js"></script>

        <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.css">
        <script src="node_modules/bootstrap/dist/js/bootstrap.js"></script>
        <link rel="stylesheet" href="node_modules/bootstrap-icons/font/bootstrap-icons.min.css">
    </head>

    <body>
        <audio id="audio">
            <source src="" type="audio/mpeg">
        </audio>
        <audio id="backgroundAudio">
            <source src="" type="audio/mpeg">
        </audio>
       <?php include_once("includes/toast.php") ?>

        <div class="game-container">

            <?php include_once("includes/gameChat.php") ?>
            <section>
                <div id="board-container"></div>
                <div id="container-enemies"></div>
                <div id="container-towers"></div>
                <div id='container-Ammo'></div>
                <div id='button-container'></div>
            </section>

            <?php include_once("includes/hud.php") ?>
            
        <a href="/lobby">
        <div id="game-modal" class="modal fade" style="background: #1d1613">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                    <div class="card text-center w-75 position-absolute top-50 start-50 translate-middle game-over-background" style="#2a211a !important">
                            <div class="card-header" id="game-over-title"></div>
                            <div id="game-list" class="card-body"></div>
                            <p id="game-over-speech"></p>
                            <div class="card-footer text-body-secondary">
                                <button href="/lobby" class=" z-3 btn hud-button mt-1 w-25" data-bs-toggle="modal" data-bs-target="#create-game-modal" data-bs-whatever="@mdo">
                                <p>Back to lobby</p>
                            </button>
                        </div>
                    </div>
            </div>
        </div>
        </a>
    </body>
    <script>
        function displayTabHUD(tabId) {
            let changeTab = new Audio("assets/audio/change-tab.mp3")
            changeTab.play()
            $("#hud-tab-general").addClass("visually-hidden");
            $("#hud-tab-tower-shop").addClass("visually-hidden");
            $("#hud-tab-tower-actions").addClass("visually-hidden");
            $("#" + tabId).removeClass("visually-hidden");
        }

        function displayTabChat(tabId) {
            $("#chat-tab-logger").addClass("visually-hidden");
            $("#chat-tab-general").addClass("visually-hidden");
            $("#" + tabId).removeClass("visually-hidden");
        }

        /**
         * This function reloads the messages every 500ms
         */
        setInterval(function(){
            /**
             * This function gets all the chat messages and display them
             */
            $(function(){
                $.get("api/v1/game/getLogs?gameId=<?= $gameId ?>", function(response) {
                    let gameLogs = response;

                    document.getElementById('event-list').innerHTML = '';

                    for (let i = 0; i < gameLogs.length; i++) {
                        let content = gameLogs[i]['content'];
                        let type = gameLogs[i]['type'];
                        let badge;

                        switch (type) {
                            case 1:
                                badge = '<span class="badge text-bg-valid">INFO</span>';
                                break;
                            case 2:
                                badge = '<span class="badge text-bg-valid">SUCCESS</span>';
                                break;
                            case 3:
                                badge = '<span class="badge text-bg-warning">WARNING</span>';
                                break;
                        }
                        document.getElementById('event-list').innerHTML += '<a>' + badge + ' ' + content + '</a><br>';
                    }
                });
            });
        }, 500);
    </script>
    <script src="js/Chat.js"></script>
    <script src="js/Main.js" type="module"></script>

    <?php include_once("includes/activityUpdater.php") ?>
</html>
