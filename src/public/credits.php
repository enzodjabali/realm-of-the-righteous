<?php
    session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Realm of the righteous - Credits</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/x-icon" href="assets/images/website/favicon.ico">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
        <style>
            body,h1,h2{font-family: "Raleway", sans-serif}
            body, html {height: 100%}
            p {line-height: 2}
            .bgimg{
                min-height: 100%;
                background-position: center;
                background-size: cover;
            }
            .bgimg {background-image: url("assets/images/website/frame.jpg ")}
        </style>
    </head>

    <body>
        <!-- Header / Home-->
        <header class="w3-display-container w3-wide bgimg w3-grayscale-min" id="home">
            <div class="w3-display-middle w3-text-white w3-center">
                <div style="color: navy;font-family: 'Old English Text MT';font-size: 24px">
                    <img src="assets/images/website/logo.png"height="35%"width="35%" >
                    <p>L'équipe Realm Of The Righteous travaille actuellement sur une page de crédits afin que vous puissiez tout savoir sur nous</p>
                </div>
            </div>
        </header>

        <?php include_once("includes/menu.php") ?>

    </body>
</html>