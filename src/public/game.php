<?php
    session_start();

    $sessionId = $_SESSION["player_id"] ?? 0;
    $gameId = $_GET["game_id"] ?? 0;

    if (!intval($sessionId) > 0) {
        header("Location:/login");
    }

    function getServerUrl(): string
    {
        $protocol = (!empty($_SERVER['HTTPS']) && (strtolower($_SERVER['HTTPS']) == 'on' || $_SERVER['HTTPS'] == '1')) ? 'https://' : 'http://';
        $server = $_SERVER['SERVER_NAME'];
        $port = $_SERVER['SERVER_PORT'] ? ':'.$_SERVER['SERVER_PORT'] : '';
        return $protocol.$server.$port;
    }

    $url = getServerUrl() . "/api/v1/game/doesBelongToPlayer?game_id=$gameId&player_id=$sessionId";
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
        <script src="node_modules/jquery/dist/jquery.js"></script>

        <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.css">
        <script src="node_modules/bootstrap/dist/js/bootstrap.js"></script>
        <link rel="stylesheet" href="node_modules/bootstrap-icons/font/bootstrap-icons.min.css">
    </head>

    <body>
        <div class="game-container">
            <section>
                <div id="board-container"></div>
                <div id="container-enemies"></div>
                <div id="container-towers"></div>
                <div style='display:flex'>
                    <div>
                        <p style="color: blue; text-decoration: underline" id="money"></p>
                        <p style="color: red; text-decoration: underline" id="life"></p>
                    </div>
                </div>
                <div id='button-container'></div>
            </section>

            <?php include_once("includes/hud.php") ?>
        </div>
    </body>

    <script>
        function displayTab(tabId) {
            $("#hud-tab-general").addClass("visually-hidden");
            $("#hud-tab-tower-shop").addClass("visually-hidden");
            $("#hud-tab-tower-actions").addClass("visually-hidden");
            $("#" + tabId).removeClass("visually-hidden");
        }
    </script>

    <script src="js/Main.js" type="module"></script>
    <?php include_once("includes/activityUpdater.php") ?>
</html>
