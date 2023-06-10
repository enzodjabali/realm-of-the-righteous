<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Realm of the righteous - Credits</title>
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
                Credits
            </div>
            <div class="card-body">
                <p>Baptiste Leclert - Frontend Developer</p>
                <p>Gabriel Titeux - Frontend Developer</p>
                <p>Thomas Taylor - Game & Level Designer</p>
                <p>Younes Baddou - Web designer</p>
                <p>Enzo Djabali - DevOps & Backend Developer</p>
            </div>
        </div>

        <?php include_once("includes/footer.php") ?>
    </body>
    <?php include_once("includes/activityUpdater.php") ?>
</html>
