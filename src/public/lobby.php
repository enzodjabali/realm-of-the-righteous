<?php
    session_start();

    $sessionId = $_SESSION["player_id"] ?? 0;

    if (!intval($sessionId) > 0) {
        header("Location:/login");
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Realm Of The Righteous - Lobby</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/x-icon" href="assets/images/website/favicon.ico">
        <script src="node_modules/jquery/dist/jquery.js"></script>

        <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.css">
        <script src="node_modules/bootstrap/dist/js/bootstrap.js"></script>
        <link rel="stylesheet" href="node_modules/bootstrap-icons/font/bootstrap-icons.min.css">
    </head>
    <body>
        <?php include_once("includes/menu.php") ?>

        <!-- Toast gets displayed with the status message of the form -->
        <div class="toast align-items-center border-0 position-absolute top-0 start-50 translate-middle mt-5" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body"></div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>

        <!-- Card of the game list -->
        <div class="card text-center w-75 position-absolute top-50 start-50 translate-middle">
            <div class="card-header">
                Games (<a id="count-games"></a>)
            </div>
            <div id="game-list" class="card-body overflow-y-scroll" style="height: 400px"></div>
            <div class="card-footer text-body-secondary">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#create-game-modal" data-bs-whatever="@mdo">New game</button>
            </div>
        </div>

        <!-- Modal game creation -->
        <div id="create-game-modal" class="modal fade" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalLabel">New game</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div id="create-game-spinner" class="spinner-border visually-hidden m-auto mt-4 mb-4" role="status"></div>
                    <!-- Form game creation -->
                    <form id="create-game-form" method="post">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="name" class="col-form-label">Name</label>
                                <input type="text" class="form-control" name="name" id="name">
                            </div>
                            <div class="mb-3">
                                <label class="col-form-label">Difficulty</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="difficulty" id="easy" value="1" checked>
                                    <label class="form-check-label" for="easy">
                                        Easy
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="difficulty" id="normal" value="2">
                                    <label class="form-check-label" for="normal">
                                        Normal (not available yet)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="difficulty" id="hard" value="3">
                                    <label class="form-check-label" for="hard">
                                        Hard (not available yet)
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <input type="submit" class="btn btn-primary" value="Create">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal gets displayed when the player wants to delete one of his games -->
        <div id="delete-game-modal" class="modal fade" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
            <div id="delete-game-id" class="visually-hidden"></div>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalLabel">Oh oh..</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div id="delete-game-spinner" class="spinner-border visually-hidden m-auto mt-4 mb-4" role="status"></div>
                    <div id="create-game-text" class="modal-body">
                        Are you sure you want to delete this game? This action is irreversible
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" onclick="deleteGame()">Delete</button>
                    </div>
                </div>
            </div>
        </div>

        <?php include_once("includes/footer.php") ?>
    </body>

    <script>
        /**
         * This function gets all the user's games and display them
         */
        function getGameInformation() {
            document.getElementById('game-list').innerHTML = "";

            const request = new XMLHttpRequest();
            request.open('GET', '/api/GetGameInformation.php', false);  // `false` makes the request synchronous
            request.send(null);

            if (request.status === 200) {
                let games = JSON.parse(request.responseText);

                for (let i = 0; i < games.length; i++) {
                    let id = games[i]['id'];
                    let name = games[i]['name'];
                    let date = games[i]['date'];

                    document.getElementById('game-list').innerHTML += "<li class='list-group-item d-flex justify-content-between align-items-start'><div class='ms-2 me-auto'><button class='btn btn-primary ps-2 pe-2 pt-1 pb-1 me-2' onclick='displayDeleteGameModal(" + id + ")'><i class='bi bi-trash-fill'></i></button><a class='fw-bold' href='/game?game_id=" + id + "'>" + name + "</a></div><span class='badge bg-primary rounded-pill'>" + date + "</span></li>";
                   if (i < games.length - 1) {
                       document.getElementById('game-list').innerHTML += "<hr>";
                   }

                    document.getElementById('count-games').innerHTML = games.length;
                }
                return true;
            }
            return false;
        }
        getGameInformation();

        /**
         * This function makes a call to create a new game
         */
        $(function(){
            $("#create-game-form").submit(function(){

                $("#create-game-spinner").removeClass("visually-hidden");
                $("#create-game-form").addClass("visually-hidden");

                let name = $(this).find("input[name=name]").val();
                let difficulty = $('input[name="difficulty"]:checked').val();

                $.post("api/CreateGame.php", {name: name, difficulty: difficulty}, function(response){
                    if (response === "1") {
                        $('#create-game-modal').modal('hide');
                        getGameInformation();

                        $("#create-game-spinner").addClass("visually-hidden");
                        $("#create-game-form").removeClass("visually-hidden");
                        $("#name").val("");

                        $(".toast").addClass('text-bg-success');
                        $(".toast").removeClass('text-bg-danger');
                        $(".toast").toast('show');
                        $(".toast-body").html("Your game has been successfully created.");
                    } else {
                        $("#create-game-spinner").addClass("visually-hidden");
                        $("#create-game-form").removeClass("visually-hidden");

                        $(".toast").removeClass('text-bg-success');
                        $(".toast").addClass('text-bg-danger');
                        $(".toast").toast('show');
                        $(".toast-body").html(response);
                    }
                });
                return false;
            });
        });

        function displayDeleteGameModal(id) {
            $('#delete-game-id').html(id);
            $('#delete-game-modal').modal('show');
        }

        function deleteGame() {
            $("#delete-game-spinner").removeClass("visually-hidden");
            $("#create-game-text").addClass("visually-hidden");

            let gameId = $('#delete-game-id').text();

            $.post("api/DeleteGame.php", {gameId: gameId}, function(response){
                if (response === "1") {
                    $('#delete-game-modal').modal('hide');
                    getGameInformation();

                    $("#delete-game-spinner").addClass("visually-hidden");
                    $("#create-game-text").removeClass("visually-hidden");

                    $(".toast").addClass('text-bg-success');
                    $(".toast").removeClass('text-bg-danger');
                    $(".toast").toast('show');
                    $(".toast-body").html("Your game has been successfully deleted.");
                } else {
                    $("#delete-game-spinner").addClass("visually-hidden");
                    $("#create-game-text").removeClass("visually-hidden");

                    $(".toast").removeClass('text-bg-success');
                    $(".toast").addClass('text-bg-danger');
                    $(".toast").toast('show');
                    $(".toast-body").html("An error has occurred, the game hasn't been deleted.");
                }
            });
        }
    </script>
</html>
