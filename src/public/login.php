<?php
    session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Signup</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">-->
    <link rel="stylesheet" href="assets/css/login-register-forms.css">
    <link rel="stylesheet" href="assets/css/modal.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

</head>
<body>
<!-- Header / Home-->
<header class="w3-display-container w3-wide bgimg w3-grayscale-min" id="home">
    <div class="w3-display-middle w3-text-white w3-center">

        <img src="assets/images/logo.png" >

        <form method="post" id="login-form">
            <p>Username</p>
            <input name="username" type="text" style="background-color: rgba(0,0,0,0);border: dotted;border-left:none;border-right: none;border-top: none;font-family: 'Old English Text MT'">

            <p>Password</p>
            <input name="password" type="password" style="background-color: rgba(0,0,0,0);border: dotted;border-left:none;border-right: none;border-top: none"><br><br>

            <input type="submit" value="login" style="border-radius: 25px;background-color: maroon;border: none;color: antiquewhite; width: 100px;height: 40px" class="sign">
        </form>

    </div>
</header>

<!-- Navbar (sticky bottom) -->
<div class="bottom">

    <div class="bar">
        <a href="login.html" style="width:25%" class="w3-bar-item w3-button">Login</a>
        <a href="register.html" style="width:25%" class="w3-bar-item w3-button">Register</a>
        <a href="the-story.html" style="width:25%" class="w3-bar-item w3-button">The Story</a>
        <a href="credits.html" style="width:25%" class="w3-bar-item w3-button">Credits</a>
    </div>
</div>

<!-- Error login modal -->
<div id="modal" class="modal">

<div class="modal-content">
    <span class="close">&times;</span>
    <p id="modalMessage"></p>
</div>
<!---->

</body>

<script src="js/modal.js"></script>
<script type="text/javascript">
    $(function(){
        $("#login-form").submit(function(){
            let username = $(this).find("input[name=username]").val();
            let password = $(this).find("input[name=password]").val();

            $.post("methods/loginMethod.php", {username: username, password: password}, function(result){

                if (result > 0) {
                    //success
                    window.location.href = "index.php?player_id=" + result;
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