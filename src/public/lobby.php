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
        <title>Realm Of The Righteous - Lobby</title>
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
        <?php include_once("includes/toast.php") ?>

        <!-- Card of the game list -->
        <div class="card text-center w-75 position-absolute top-50 start-50 translate-middle">
            <div class="card-header">
                Games (<span id="count-games"></span>)
            </div>
            <div id="game-list" class="card-body overflow-y-scroll" style="height: 400px"></div>
            <div class="card-footer text-body-secondary">
                <button href="/lobby" class="btn hud-button mt-1 w-25" data-bs-toggle="modal" data-bs-target="#create-game-modal" data-bs-whatever="@mdo">
                    <p>New game</p>
                </button>
            </div>
        </div>

        <!-- Modal game creation -->
        <div id="create-game-modal" class="modal fade" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalLabel">New game</h1>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div id="create-game-spinner" class="spinner-border visually-hidden m-auto mt-4 mb-4 text-light" role="status"></div>
                    <!-- Form game creation -->
                    <form id="create-game-form" method="post">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="name" class="col-form-label">Name</label>
                                <input type="text" class="form-control shadow-none" name="name" id="name">
                            </div>
                            <div class="mb-3">
                                <label class="col-form-label">Difficulty</label>
                                <div class="form-check">
                                    <input class="form-check-input shadow-none" type="radio" name="difficulty" id="easy" value="1" checked>
                                    <label class="form-check-label" for="easy">
                                        Easy
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input shadow-none" type="radio" name="difficulty" id="normal" value="2">
                                    <label class="form-check-label" for="normal">
                                        Normal (not available yet)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input shadow-none" type="radio" name="difficulty" id="hard" value="3">
                                    <label class="form-check-label" for="hard">
                                        Hard (not available yet)
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-form-cancel" data-bs-dismiss="modal">Cancel</button>
                            <input type="submit" class="btn btn-form-submit" value="Create">
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
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div id="delete-game-spinner" class="spinner-border visually-hidden m-auto mt-4 mb-4" role="status"></div>
                    <div id="create-game-text" class="modal-body">
                        Are you sure you want to delete this game? This action is irreversible.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-form-cancel" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-form-submit" onclick="deleteGame()">Delete</button>
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
            request.open('GET', '/api/v1/game/getAll', false);  // `false` makes the request synchronous
            request.send(null);

            if (request.status === 200) {
                let games = JSON.parse(request.responseText);

                for (let i = 0; i < games.length; i++) {
                    let id = games[i]['id'];
                    let name = games[i]['name'];
                    let difficulty = games[i]['difficulty'];
                    let date = games[i]['date'];

                    let difficultyLabel;
                    switch (difficulty) {
                        case 1:
                            difficultyLabel = 'Easy';
                            break;
                        case 2:
                            difficultyLabel = 'Normal';
                            break;
                        case 3:
                            difficultyLabel = 'Hard';
                            break;
                    }

                    document.getElementById('game-list').innerHTML += "<li class='list-group-item d-flex justify-content-between align-items-start'><div class='ms-2 me-auto'><button class='btn btn-form-submit ps-2 pe-2 pt-1 pb-1' onclick='displayDeleteGameModal(" + id + ")'><i class='bi bi-trash-fill'></i></button><a href='/game?gameId=" + id + "' class='btn btn-form-submit ps-2 pe-2 pt-1 pb-1 me-2'><i class='bi bi-play-fill'></i></a><a class='fw-bold text-reset text-decoration-none' href='/game?gameId=" + id + "'>" + name + "</a></div><span class='badge badge-game me-2'>" + difficultyLabel + "</span><span class='badge badge-game'>" + date + "</span></li>";
                   if (i < games.length - 1) {
                       document.getElementById('game-list').innerHTML += "<hr>";
                   }
                }

                if (games.length === 0) {
                    document.getElementById('count-games').innerHTML = "0";
                    document.getElementById('game-list').innerHTML = "You don't have a game yet. Create your first!";
                } else {
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

                $.post( "api/v1/game/create", {name: name, difficulty: difficulty}, function() {
                    $('#create-game-modal').modal('hide');
                    getGameInformation();

                    $("#create-game-spinner").addClass("visually-hidden");
                    $("#create-game-form").removeClass("visually-hidden");
                    $("#name").val("");

                    $(".toast").addClass('text-bg-valid');
                    $(".toast").removeClass('text-bg-danger');
                    $(".toast").toast('show');
                    $(".toast-body").html("Your game has been successfully created.");
                }).fail(function(response) {
                    $("#create-game-spinner").addClass("visually-hidden");
                    $("#create-game-form").removeClass("visually-hidden");

                    $(".toast").removeClass('text-bg-valid');
                    $(".toast").addClass('text-bg-danger');
                    $(".toast").toast('show');
                    $(".toast-body").html(JSON.parse(response.responseText).response);
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

            $.post("api/v1/game/delete", {gameId: gameId}, function(response) {
                $('#delete-game-modal').modal('hide');
                getGameInformation();

                $("#delete-game-spinner").addClass("visually-hidden");
                $("#create-game-text").removeClass("visually-hidden");

                $(".toast").addClass('text-bg-valid');
                $(".toast").removeClass('text-bg-danger');
                $(".toast").toast('show');
                $(".toast-body").html("Your game has been successfully deleted.");
            }).fail(function() {
                $("#delete-game-spinner").addClass("visually-hidden");
                $("#create-game-text").removeClass("visually-hidden");

                $(".toast").removeClass('text-bg-valid');
                $(".toast").addClass('text-bg-danger');
                $(".toast").toast('show');
                $(".toast-body").html("An error has occurred, the game hasn't been deleted.");
            });
        }
    </script>
    <?php include_once("includes/activityUpdater.php") ?>
</html>
