<?php
    if (isset($_GET["link"]) && is_string($_GET["link"])) {
        $serverUrl = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]";

        $url = "$serverUrl/api/v1/player/doesResetPasswordLinkExist?link={$_GET["link"]}";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);

        // Proxy for Docker
        curl_setopt($ch, CURLOPT_PROXY, $_SERVER['SERVER_ADDR'] . ':' .  $_SERVER['SERVER_PORT']);

        if (($response = curl_exec($ch)) === false) {
            echo 'Curl error: ' . curl_error($ch);
            die();
        }
        curl_close($ch);

        $doesResetPasswordLinkExist = json_decode($response, true)["response"] === true;
    } else {
        $doesResetPasswordLinkExist = false;
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Realm Of The Righteous - Verify account</title>
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

        <?php if ($doesResetPasswordLinkExist) { ?>
            <div class="card w-75 position-absolute top-50 start-50 translate-middle">
                <div class="card-header text-center ">
                    Reset password
                </div>
                <div class="card-body">
                    <!-- Login form-->
                    <div class="text-center">
                        <div id="spinner" class="spinner-border visually-hidden mt-4 mb-4" role="status"></div>
                        <p id="link-expired" class="visually-hidden">The link has expired.</p>
                    </div>
                    <form id="reset-password-form" method="post">
                        <div class="mb-3">
                            <label for="new-password" class="form-label">New password</label>
                            <input type="password" class="form-control" name="newPassword" id="new-password" required>
                        </div>
                        <div class="mb-3">
                            <label for="retype-new-password" class="form-label">Retype new password</label>
                            <input type="password" class="form-control" name="retypedNewPassword" id="retype-new-password" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Reset</button>
                    </form>
                </div>
            </div>
        <?php } else { ?>
            <div class="card text-center w-75 position-absolute top-50 start-50 translate-middle">
                <div class="card-body pt-4">
                    <p>The link has expired.</p>
                </div>
            </div>
        <?php } ?>

        <?php include_once("includes/footer.php") ?>
    </body>

    <script>
        /**
         * This function calls the reset player's password method
         */
        $(function(){
            $("#reset-password-form").submit(function(){
                $("#spinner").removeClass("visually-hidden");
                $("#reset-password-form").addClass("visually-hidden");

                let link = new URLSearchParams(window.location.search).get('link');
                let newPassword = $(this).find("input[name=newPassword]").val();
                let retypedNewPassword = $(this).find("input[name=retypedNewPassword]").val();

                $.post("../api/v1/player/resetPassword", {link: link, newPassword: newPassword, retypedNewPassword: retypedNewPassword}, function() {
                    window.location.href = "/login";
                }).fail(function(response) {
                    $("#spinner").addClass("visually-hidden");
                    $("#reset-password-form").removeClass("visually-hidden");

                    $(".toast").toast('show');
                    $(".toast-body").html(JSON.parse(response.responseText).response);
                });
                return false;
            });
        });
    </script>
</html>
