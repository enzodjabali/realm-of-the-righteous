<?php
    session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Realm of the righteous - The Story</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="icon" type="image/x-icon" href="assets/images/website/favicon.ico">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
        <style>
            body,h1,h2{font-family: "Raleway", sans-serif}
            body, html {height: 100%}
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
                <h1 class="w3-jumbo" style="color: navy;font-family: 'Old English Text MT'">Realm Of The Righteous</h1>
                <h2 style="color: navy">The best tower defense in all the realm</h2>
                <div style="color: navy;font-family: 'Old English Text MT';font-size: 24px">
                    <p>In a fantastic world, the inhabitants of the four kingdoms lived in peace until a threat of hordes of orcs, goblins, and evil creatures gathered to conquer the four kingdoms and spread chaos throughout the world. The leaders of the kingdoms formed an alliance and gathered an army to defend the borders. After attempting to build fortifications, they decided to construct a network of defense towers equipped with weapons to repel the enemies. The first attacks were repelled, but the enemies sent more powerful and dangerous troops, which prompted the kings and queens to form legendary heroes to lead the battle.</p>
                </div>
            </div>
        </header>

        <?php include_once("includes/menu.php") ?>

    </body>
</html>
