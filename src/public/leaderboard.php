<?php
    session_start();

    $sessionId = isset($_SESSION["playerId"]) ? (int)$_SESSION["playerId"] : 0;

    if (!$sessionId > 0) {
        header("Location:/login");
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Realm Of The Righteous - Leaderboard</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/x-icon" href="assets/images/website/favicon.ico">
        <script src="node_modules/jquery/dist/jquery.js"></script>
        <link href="assets/css/styles.css" rel="stylesheet">

        <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.css">
        <script src="node_modules/bootstrap/dist/js/bootstrap.js"></script>
        <link rel="stylesheet" href="node_modules/bootstrap-icons/font/bootstrap-icons.min.css">
    </head>
    <body>
        <?php include_once("includes/menu.php") ?>

        <!-- Card of the game list -->
        <div class="card text-center w-75 position-absolute top-50 start-50 translate-middle">
            <div class="card-header">
                Leaderboard
            </div>
            <div class="card-body overflow-y-scroll" style="height: 400px">
                <table class="table">
                    <thead id="leaderboard-table-thead"></thead>
                    <tbody id="leaderboard-table"></tbody>
                    <div class="position-absolute top-50 start-50 translate-middle">
                        <div id="spinner" class="spinner-border mt-4 mb-4" role="status"></div>
                    </div>
                </table>
            </div>
        </div>

        <?php include_once("includes/footer.php") ?>
    </body>

    <script>
        /**
         * This function reloads the messages every 500ms
         */
        setInterval(function(){
            /**
             * This function gets all the chat players and display them
             */
            $(function(){
                $.get("api/v1/player/getAll", function(response) {
                    $('.spinner-border').addClass("visually-hidden");
                    $('#leaderboard-table').html("");
                    $('#leaderboard-table-thead').html('<tr><th scope="col">Ranking</th><th scope="col">Username</th><th scope="col">XP</th><th scope="col">Status</th></tr>');

                    for (let i = 0; i < response.length; i++) {
                        let username = response[i]['username'];
                        let xp = response[i]['xp'];
                        let lastActivity = response[i]['last_activity'];
                        let position = i+1;

                        let isMe = "";
                        if (username == "<?= $sessionUsername ?>") {
                            isMe = "(me)";
                        }

                        let activity = (Math.floor(new Date().getTime() / 1000) - lastActivity) > 7 ? '<span class="badge text-bg-secondary">Offline</span>' : '<span class="badge text-bg-valid">Online</span>';
                        $('#leaderboard-table').append('<tr><th scope="row">' + position + '</th><td>' + username + ' ' + isMe + '</td><td>' + xp + '</td><td>' + activity + '</td></tr>');
                    }
                });
            });
        }, 500);
    </script>
    <?php include_once("includes/activityUpdater.php") ?>
</html>
