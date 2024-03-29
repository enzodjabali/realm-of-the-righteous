<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Realm Of The Righteous - About</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="In a fantastic world, the inhabitants of the four kingdoms lived in peace until a threat of hordes of orcs, goblins, and evil creatures gathered to conquer the kingdoms and spread chaos. Learn more about the game Realm Of The Righteous.">
        <link rel="icon" type="image/x-icon" href="assets/images/website/favicon.ico">
        <link href="assets/css/styles.css" rel="stylesheet">
        <script src="node_modules/jquery/dist/jquery.js"></script>

        <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.css">
        <script src="node_modules/bootstrap/dist/js/bootstrap.js"></script>
        <link rel="stylesheet" href="node_modules/bootstrap-icons/font/bootstrap-icons.min.css">
    </head>

    <body>
        <?php include_once("includes/menu.php") ?>

        <div class="card text-center w-75 position-absolute top-50 start-50 translate-middle">
            <div class="card-header">
                About
            </div>
            <div class="card-body">
                <img src="assets/images/website/logo-text-2l.png" alt="realm-of-the-righteous-logo-text">
                <p class="mt-2">In a fantastic world, the inhabitants of the four kingdoms lived in peace until
                    a threat of hordes of <br>orcs, goblins, and evil creatures gathered to conquer the
                    four kingdoms and spread chaos throughout the world.<br>
                    The leaders of the kingdoms formed an alliance and gathered an army to defend the borders.<br>
                    After attempting to build fortifications, they decided to construct a network of defense towers
                    equipped with weapons<br> to repel the enemies and the evil murk that follows them.<br>
                    The first attacks were repelled, but the enemies sent more powerful and dangerous troops,<br>
                    which prompted the kings and queens to form legendary heroes to lead the battle.</p>
            </div>
        </div>

        <?php include_once("includes/footer.php") ?>
    </body>
    <?php include_once("includes/activityUpdater.php") ?>
</html>
