<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Realm of the righteous - About</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/x-icon" href="assets/images/website/favicon.ico">

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
                <h5 class="card-title">Realm Of The Righteous</h5>
                <p class="card-text">The best tower defense in all the realm.</p>
                <p>In a fantastic world, the inhabitants of the four kingdoms lived in peace until
                    a threat of hordes of <br>orcs, goblins, and evil creatures gathered to conquer the
                    four kingdoms and spread chaos throughout the world.<br>
                    The leaders of the kingdoms formed an alliance and gathered an army to defend the borders.<br>
                    After attempting to build fortifications, they decided to construct a network of defense towers
                    equipped with weapons to repel the enemies.<br> The first attacks were repelled, but
                    the enemies sent more powerful and dangerous troops, which prompted the kings and
                    queens to form legendary heroes to lead the battle.</p>
            </div>
        </div>

        <?php include_once("includes/footer.php") ?>
    </body>
</html>
