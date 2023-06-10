<?php
    session_start();

    $sessionId = $_SESSION["player_id"] ?? 0;

    if ($sessionId > 0) {
        header("Location:/lobby");
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Realm Of The Righteous - Login</title>
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

        <!-- Toast gets displayed with an error message if the user's credentials aren't valid or with the status of the reset password form -->
        <div class="toast align-items-center border-0 position-absolute top-0 start-50 translate-middle mt-5 z-2" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body"></div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>

        <div class="card w-75 position-absolute top-50 start-50 translate-middle">
            <div class="card-header text-center">
                Login
            </div>
            <div class="card-body">
                <!-- Login form-->
                <div class="text-center">
                    <div id="spinner" class="spinner-border visually-hidden mt-4 mb-4" role="status"></div>
                </div>
                <form id="login-form" method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" id="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" id="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                    <div class="pt-2">
                        <a href="/register">Don't have an account yet? Register</a>
                        <br>
                        <a onclick="$('#reset-password-modal').modal('show');" role="button" class="pointer-event pe-auto">Password forgotten</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal gets displayed when the player wants to reset his password -->
        <div id="reset-password-modal" class="modal fade" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
            <div id="delete-game-id" class="visually-hidden"></div>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalLabel">Reset password</h1>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="reset-password-form" method="post">
                        <div id="create-game-text" class="modal-body">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control" name="email" id="email" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Send a reset link</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php include_once("includes/footer.php") ?>
    </body>

    <script>
        /**
         * This function calls the player login method
         * If the login method success the player is redirected to /lobby, if not an error message is displayed
         */
        $(function(){
            $("#login-form").submit(function(){
                $("#spinner").removeClass("visually-hidden");
                $("#login-form").addClass("visually-hidden");

                let username = $(this).find("input[name=username]").val();
                let password = $(this).find("input[name=password]").val();

                $.post("api/v1/player/login", {username: username, password: password}, function() {
                    window.location.href = "/lobby";
                }).fail(function(response) {
                    $("#spinner").addClass("visually-hidden");
                    $("#login-form").removeClass("visually-hidden");

                    $(".toast").removeClass('text-bg-success');
                    $(".toast").addClass('text-bg-danger');
                    $(".toast").toast('show');
                    $(".toast-body").html(JSON.parse(response.responseText).response);
                });
                return false;
            });
        });

        /**
         * This function calls the reset password method
         */
        $(function(){
            $("#reset-password-form").submit(function(){
                $('#reset-password-modal').modal('hide');

                let playerEmail = $(this).find("input[name=email]").val();

                $.post("api/v1/player/generateResetPasswordLink", {playerEmail: playerEmail}, function(){
                    $('#delete-game-modal').modal('hide');
                    $("#delete-game-spinner").addClass("visually-hidden");
                    $("#create-game-text").removeClass("visually-hidden");

                    $(".toast").addClass('text-bg-success');
                    $(".toast").removeClass('text-bg-danger');
                    $(".toast").toast('show');
                    $(".toast-body").html("A reset link has been sent to " + playerEmail + ".");
                }).fail(function(response) {
                    $("#delete-game-spinner").addClass("visually-hidden");
                    $("#create-game-text").removeClass("visually-hidden");

                    $(".toast").removeClass('text-bg-success');
                    $(".toast").addClass('text-bg-danger');
                    $(".toast").toast('show');
                    $(".toast-body").html(JSON.parse(response.responseText).response);
                });
                return false;
            });
        });
    </script>

</html>