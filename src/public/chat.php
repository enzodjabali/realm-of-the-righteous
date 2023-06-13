<?php
    session_start();

    $sessionId = isset($_SESSION["playerId"]) ? (int)$_SESSION["playerId"] : 0;

    if (!$sessionId > 0) {
        header("Location:/login");
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Realm Of The Righteous - Chat</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/x-icon" href="assets/images/website/favicon.ico">
        <script src="node_modules/jquery/dist/jquery.js"></script>
        <link href="assets/css/styles.css" rel="stylesheet">

        <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.css">
        <script src="node_modules/bootstrap/dist/js/bootstrap.js"></script>
        <link rel="stylesheet" href="node_modules/bootstrap-icons/font/bootstrap-icons.min.css">
    </head>
    <body>
        <?php include_once("includes/menu.php") ?>
        <?php include_once("includes/toast.php") ?>

        <!-- Card of the message list -->
        <div class="card w-75 position-absolute top-50 start-50 translate-middle">
            <div class="card-header text-center">
                Chat
            </div>
            <div id="message-list" class="card-body overflow-y-scroll" style="height: 400px">
                <div class="position-absolute top-50 start-50 translate-middle">
                    <div id="spinner" class="spinner-border mt-4 mb-4" role="status"></div>
                </div>
            </div>
            <form id="chat-form" method="post" class="input-group card-footer text-body-secondary">
                <input type="text" class="form-control me-2 shadow-none" name="message" id="message">
                <div class="input-group-prepend">
                    <button class="btn btn-form-submit h-100" type="submit">Send</button>
                </div>
            </form>
        </div>

        <?php include_once("includes/footer.php") ?>
    </body>
    <script src="js/Chat.js"></script>

    <?php include_once("includes/activityUpdater.php") ?>
</html>
