<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Realm Of The Righteous</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/x-icon" href="assets/images/website/favicon.ico">
        <link href="assets/css/styles.css" rel="stylesheet">

        <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.css">
        <script src="node_modules/bootstrap/dist/js/bootstrap.js"></script>
        <link rel="stylesheet" href="node_modules/bootstrap-icons/font/bootstrap-icons.min.css">
    </head>

    <body>
        <?php include_once("includes/menu.php") ?>

        <div class="card text-center w-75 position-absolute top-50 start-50 translate-middle">
            <div class="card-header">
                Welcome
            </div>
            <div class="card-body">
                <h5 class="card-title">Realm Of The Righteous</h5>
                <p class="card-text">The best tower defense in all the realm.</p>
                <div class="mb-3">
                    <img src="assets/images/website/logo.png" width="150">
                </div>
                <a href="/lobby" class="btn btn-primary">Start now</a>
            </div>
            <div class="card-footer text-body-secondary">
                <div class="card-footer-text">Are you new here? <a href="/about">Click here</a> to discover the game and its rules.</div>
            </div>
        </div>

        <?php include_once("includes/footer.php") ?>
    </body>
    <?php include_once("includes/activityUpdater.php") ?>
</html>
