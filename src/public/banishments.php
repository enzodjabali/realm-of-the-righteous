<?php
    session_start();

    $sessionId = isset($_SESSION["playerId"]) ? (int)$_SESSION["playerId"] : 0;
    $sessionUsername = isset($_SESSION["playerUsername"]) ? (string)$_SESSION["playerUsername"] : 0;
    $sessionIsAdmin = isset($_SESSION["playerIsAdmin"]) ? (bool)$_SESSION["playerIsAdmin"] : "";

    if (!$sessionId > 0 && $sessionIsAdmin) {
        header("Location:/login");
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Realm Of The Righteous - Banishments</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/x-icon" href="../assets/images/website/favicon.ico">
        <script src="../node_modules/jquery/dist/jquery.js"></script>
        <link href="../assets/css/styles.css" rel="stylesheet">

        <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.css">
        <script src="../node_modules/bootstrap/dist/js/bootstrap.js"></script>
        <link rel="stylesheet" href="../node_modules/bootstrap-icons/font/bootstrap-icons.min.css">
    </head>
    <body>
    <?php include_once("includes/settingsSidebar.php") ?>

    <!-- Card of the game list -->
    <div class="card text-center w-75 position-absolute top-50 start-50 translate-middle">
        <div class="card-header">
            Banishments
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
        <form id="chat-form" method="post" class="input-group card-footer text-body-secondary">
            <select id="select-player" class="form-select shadow-none me-2" aria-label="Select a player to ban">
                <option selected>Select a player to ban</option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
            </select>
            <div class="input-group-prepend">
                <button class="btn btn-danger h-100" type="submit">Send</button>
            </div>
        </form>
    </div>

    <?php include_once("includes/footer.php") ?>
    </body>

    <script>
        /**
         * This function gets all the banned and not banned players and display them
         */
        function getAllPlayers() {
            $.get("../api/v1/player/getAll", function(response) {
                $('.spinner-border').addClass("visually-hidden");
                $('#leaderboard-table').html("");
                $('#select-player').html("<option selected>Select a player to ban</option>");
                $('#leaderboard-table-thead').html('<tr><th scope="col">Unban</th><th scope="col">Username</th><th scope="col">ID</th><th scope="col">Status</th></tr>');

                for (let i = 0; i < response.length; i++) {
                    let id = response[i]['id'];
                    let username = response[i]['username'];
                    let isBanned = response[i]['is_banned'];

                    if (isBanned) {
                        $('#leaderboard-table').append('<tr><td><span onclick="unban(' + id + ')" class="badge badge-unban text-bg-danger"><i class="bi bi-person-fill-slash"></i> Unban</span></td><td>' + username + '</td><td>' + id + '</td><td><span class="badge text-bg-danger">Banned</span></td></tr>');
                    } else {
                        $('#select-player').append('<option value="' + id + '">' + username + '</option>');
                    }
                }
            });
        }
        getAllPlayers();

        /**
         * This function calls the ban player method
         * If the ban player method success the ban is applied, if not an error message is displayed
         */
        $(function(){
            $("#chat-form").submit(function() {
                let playerIdToBan = $("#select-player").val();

                $.post("../api/v1/player/ban", {playerIdToBan: playerIdToBan}, function() {
                    getAllPlayers();
                }).fail(function(response) {
                    $(document).ready(function() {
                        $(".toast").removeClass('text-bg-valid');
                        $(".toast").addClass('text-bg-danger');
                        $(".toast").toast('show');
                        $(".toast-body").html(JSON.parse(response.responseText).response);
                    });
                });
                return false;
            });
        });

        /**
         * This function calls the unban player method
         * If the unban player method success the unban is applied, if not an error message is displayed
         */
        function unban(playerIdToUnban) {
            $.post("../api/v1/player/unban", {playerIdToUnban: playerIdToUnban}, function () {
                getAllPlayers();

            }).fail(function (response) {
                $(document).ready(function () {
                    $(".toast").removeClass('text-bg-valid');
                    $(".toast").addClass('text-bg-danger');
                    $(".toast").toast('show');
                    $(".toast-body").html(JSON.parse(response.responseText).response);
                });
            });
            return false;
        }
    </script>
</html>
