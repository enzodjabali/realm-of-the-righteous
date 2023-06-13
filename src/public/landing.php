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
        <script src="node_modules/jquery/dist/jquery.js"></script>

        <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.css">
        <script src="node_modules/bootstrap/dist/js/bootstrap.js"></script>
        <link rel="stylesheet" href="node_modules/bootstrap-icons/font/bootstrap-icons.min.css">
    </head>

    <body>
        <?php include_once("includes/menu.php") ?>

        <div class="card text-center w-75 position-absolute top-50 start-50 translate-middle">
            <div class="card-header">
                W3lc0me!
            </div>
            <div class="card-body pt-4 pb-4">
                <img src="assets/images/website/logo-text-2l.png" alt="realm-of-the-righteous-logo-text">
                <br>
                <a href="/lobby" class="btn hud-button mt-3 w-50">
                    <p>Start now</p>
                </a>
            </div>
            <div class="card-footer text-body-secondary">
                <div class="card-footer-text">Are you new here? <a href="/about">Click here</a> to discover the game and its rules.</div>
            </div>
        </div>

        <?php include_once("includes/footer.php") ?>
    </body>
    <?php include_once("includes/activityUpdater.php") ?>
</html>
