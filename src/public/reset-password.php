<?php
    if (isset($_GET["link"]) && is_string($_GET["link"])) {
        $serverUrl = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]";

        $url = "$serverUrl/api/DoesResetPasswordLinkExist.php?link={$_GET["link"]}";
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

        $DoesResetPasswordLinkExist = $response == "1";
    } else {
        $DoesResetPasswordLinkExist = false;
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

        <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.css">
        <script src="node_modules/bootstrap/dist/js/bootstrap.js"></script>
        <link rel="stylesheet" href="node_modules/bootstrap-icons/font/bootstrap-icons.min.css">
    </head>

    <body>
        <?php include_once("includes/menu.php") ?>

        <!-- Toast gets displayed with an error message if the reset password form isn't valid -->
        <div class="toast align-items-center text-bg-danger border-0 position-absolute top-0 start-50 translate-middle mt-5" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body"></div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>

        <?php if ($DoesResetPasswordLinkExist) { ?>
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
                <div class="card-body mt-3">
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

                $.post("../api/ResetPassword.php", {link: link, newPassword: newPassword, retypedNewPassword: retypedNewPassword}, function(response) {
                    if (response === "1") {
                        window.location.href = "/login";
                    } else {
                        $("#spinner").addClass("visually-hidden");
                        $("#reset-password-form").removeClass("visually-hidden");

                        $(".toast").toast('show');
                        $(".toast-body").html(response);
                    }
                });
                return false;
            });
        });
    </script>
</html>
