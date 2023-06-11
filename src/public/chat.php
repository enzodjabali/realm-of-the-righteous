<?php
    session_start();

    $sessionId = $_SESSION["playerId"] ?? 0;

    if (!intval($sessionId) > 0) {
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

        <!-- Toast gets displayed with an error message if the user's message isn't valid -->
        <div class="toast align-items-center text-bg-danger border-0 position-absolute top-0 start-50 translate-middle mt-5 z-2" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body"></div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>

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
                <input type="text" class="form-control me-3" name="message" id="message">
                <div class="input-group-prepend">
                    <button class="btn btn-primary" type="submit">Send</button>
                </div>
            </form>
        </div>

        <?php include_once("includes/footer.php") ?>
    </body>
    <script src="js/Chat.js"></script>

    <?php include_once("includes/activityUpdater.php") ?>
</html>
