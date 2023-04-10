<?php
    session_start();

    $sessionId = $_SESSION["player_id"] ?? 0;

    if ($sessionId > 0) {
        header("Location:/lobby");
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Realm of the righteous - Login</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="assets/css/modal.css">
        <link rel="stylesheet" href="assets/css/login-register-forms.css">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="icon" type="image/x-icon" href="assets/images/website/favicon.ico">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
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
            .bgimg {background-image: url("assets/images/website/frame.jpg")}

        </style>
    </head>

    <body>
        <!-- Header / Home-->
        <header class="w3-display-container w3-wide bgimg w3-grayscale-min" id="home">
            <div class="w3-display-middle w3-text-white w3-center">

                <form method="post" id="login-form">
                    <img src="assets/images/website/logo.png" >

                    <p style="color: navy;">Username</p>
                    <input name="username" type="text" style="background-color: rgba(0,0,0,0);border: dotted;border-left:none;border-right: none;border-top: none;">

                    <p style="color: navy;">Password</p>
                    <input name="password" type="password" style="background-color: rgba(0,0,0,0);border: dotted;border-left:none;border-right: none;border-top: none"><br><br>

                    <input type="submit" value="Login" style="border-radius: 25px;background-color: maroon;border: none;color: antiquewhite; width: 100px;height: 40px" class="sign">
                    <br><br><br><br>
                </form>

            </div>
        </header>

        <?php include_once("includes/menu.php") ?>

        <!-- Error login modal -->
        <div id="modal" class="modal">

            <div class="modal-content">
                <span class="close">&times;</span>
                <p id="modalMessage"></p>
            </div>
        </div>


    </body>

    <script src="js/modal.js"></script>
    <script>
        /**
         * This function calls the player login method
         * If the login method success the player is redirected to /lobby, if not an error message is displayed
         */
        $(function(){
            $("#login-form").submit(function(){
                let username = $(this).find("input[name=username]").val();
                let password = $(this).find("input[name=password]").val();

                $.post("methods/LoginPlayerMethod.php", {username: username, password: password}, function(response){

                    if (response > 0) {
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