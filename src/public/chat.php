<?php
    session_start();

    $sessionId = $_SESSION["player_id"] ?? 0;

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
            <div id="message-list" class="card-body overflow-y-scroll" style="height: 400px"></div>

            <form id="chat-form" method="post" class="input-group card-footer text-body-secondary">
                <input type="text" class="form-control me-3" name="message" id="message">
                <div class="input-group-prepend">
                    <button class="btn btn-primary" type="submit">Send</button>
                </div>
            </form>
        </div>

        <?php include_once("includes/footer.php") ?>
    </body>

    <script>
        /**
         * This function reloads the messages every 500ms
         */
        setInterval(function(){
            /**
             * This function gets all the chat messages and display them
             */
            $(function(){
                $.get("api/v1/chat/getAll", function(response) {
                    let chatMessages = response;

                    document.getElementById('message-list').innerHTML = '';

                    let d = new Date();
                    let currentDate = d.getFullYear() + "-" +((d.getMonth()+1).length !== 2 ? "0" + (d.getMonth() + 1) : (d.getMonth()+1)) + "-" + (d.getDate().length !== 2 ?"0" + d.getDate() : d.getDate());

                    for (let i = 0; i < chatMessages.length; i++) {
                        let username = chatMessages[i]['username'];
                        let message = chatMessages[i]['message'];
                        let date = "";

                        if (currentDate === chatMessages[i]['date']) {
                            date = "today";
                        } else {
                            date = chatMessages[i]['date'];
                        }

                        document.getElementById('message-list').innerHTML += '<a><b>' + username + '</b> (' + date + '): ' + message + '</a><br>';
                    }
                });
            });
        }, 500);

        /**
         * This function calls the chat message insert method
         * If the insert method success the player's message is sent, if not an error message is displayed
         */
        $(function(){
            $("#chat-form").submit(function(){
                let message = $(this).find("input[name=message]").val();

                $.post("api/v1/chat/insert", {message: message}, function(){
                    document.getElementById('message').value = "";
                }).fail(function(response) {
                    $(document).ready(function() {
                        $(".toast").toast('show');
                        $(".toast-body").html(JSON.parse(response.responseText).response);
                    });
                });
                return false;
            });
        });
    </script>
</html>
