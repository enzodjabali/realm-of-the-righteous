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

        <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.css">
        <script src="node_modules/bootstrap/dist/js/bootstrap.js"></script>
    </head>

    <body>
        <?php include_once("includes/menu.php") ?>

        <!-- Toast gets displayed with an error message if the user's credentials aren't valid -->
        <div class="toast align-items-center text-bg-danger border-0 position-absolute top-0 start-50 translate-middle mt-5" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body"></div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>

        <div class="card w-75 position-absolute top-50 start-50 translate-middle">
            <div class="card-header text-center ">
                Login
            </div>
            <div class="card-body">
                <!-- Login form-->
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
                </form>
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
                let username = $(this).find("input[name=username]").val();
                let password = $(this).find("input[name=password]").val();

                $.post("api/LoginPlayer.php", {username: username, password: password}, function(response){
                    let PlayerId = JSON.parse(response.substring(response.indexOf("{"), response.lastIndexOf("}") + 1))["playerId"];

                    if (PlayerId > 0) {
                        window.location.href = "/lobby";
                    } else {
                        $(document).ready(function() {
                            $(".toast").toast('show');
                            $(".toast-body").html("Wrong username or password, please try again.");
                        });
                    }
                });
                return false;
            });
        });
    </script>

</html>