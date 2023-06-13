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
        <title>Realm Of The Righteous - Change password</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/x-icon" href="../assets/images/website/favicon.ico">
        <script src="../node_modules/jquery/dist/jquery.js"></script>
        <link href="../assets/css/styles.css" rel="stylesheet">

        <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.css">
        <script src="../node_modules/bootstrap/dist/js/bootstrap.js"></script>
        <link rel="stylesheet" href="../node_modules/bootstrap-icons/font/bootstrap-icons.min.css">
    </head>

    <body>
        <?php include_once("includes/settingsSidebar.php") ?>
        <?php include_once("includes/toast.php") ?>

        <div class="card w-75 position-absolute top-50 start-50 translate-middle">
            <div class="card-header text-center">
                Change password
            </div>
            <div class="card-body">
                <!-- Update player's password form-->
                <form id="update-player-form" method="post" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label for="current-password" class="form-label">Current password</label>
                        <input type="password" class="form-control shadow-none" name="currentPassword" id="current-password" required>
                    </div>
                    <div class="mb-3">
                        <label for="new-password" class="form-label">New password</label>
                        <input type="password" class="form-control shadow-none" name="newPassword" id="new-password" required>
                    </div>
                    <div class="mb-3">
                        <label for="retype-new-password" class="form-label">Retype new password</label>
                        <input type="password" class="form-control shadow-none" name="retypedNewPassword" id="retype-new-password" required>
                    </div>
                    <button type="submit" class="btn hud-button p-0 w-25">
                        <p>Edit</p>
                    </button>
                </form>
            </div>
        </div>

        <?php include_once("includes/footer.php") ?>
    </body>

    <script>
        /**
         * This function restricts the form from being submitted if all the fields aren't filled
         */
        (() => {
            'use strict'
            const forms = document.querySelectorAll('.needs-validation')

            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
        })();

        /**
         * This function calls the update player's password method
         */
        $(function(){
            $("#update-player-form").submit(function(){
                let currentPassword = $(this).find("input[name=currentPassword]").val();
                let newPassword = $(this).find("input[name=newPassword]").val();
                let retypedNewPassword = $(this).find("input[name=retypedNewPassword]").val();

                $.post("../api/v1/player/updatePassword", {currentPassword: currentPassword, newPassword: newPassword, retypedNewPassword: retypedNewPassword}, function() {
                    $(".toast").addClass('text-bg-valid');
                    $(".toast").removeClass('text-bg-danger');
                    $(".toast").toast('show');
                    $(".toast-body").html("Your password has been successfully updated.");
                }).fail(function(response) {
                    $(".toast").removeClass('text-bg-valid');
                    $(".toast").addClass('text-bg-danger');
                    $(".toast").toast('show');
                    $(".toast-body").html(JSON.parse(response.responseText).response);
                });
                return false;
            });
        });
    </script>
</html>
