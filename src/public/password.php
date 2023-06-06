<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Realm Of The Righteous - Change password</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/x-icon" href="../assets/images/website/favicon.ico">
        <script src="../node_modules/jquery/dist/jquery.js"></script>

        <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.css">
        <script src="../node_modules/bootstrap/dist/js/bootstrap.js"></script>
        <link rel="stylesheet" href="../node_modules/bootstrap-icons/font/bootstrap-icons.min.css">
    </head>

    <body>
        <?php include_once("includes/settings-sidebar.php") ?>

        <div class="position-absolute top-0 start-0 translate-middle m-4">
            <button onclick="showSidebar()" class="btn btn-secondary">
                <i class="bi bi-list"></i>
            </button>
        </div>

        <!-- Toast gets displayed with the status message of the form -->
        <div class="toast align-items-center border-0 position-absolute top-0 start-50 translate-middle mt-5" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body"></div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>

        <div class="card w-75 position-absolute top-50 start-50 translate-middle">
            <div class="card-header text-center">
                Change password
            </div>
            <div class="card-body">
                <!-- Update player's password form-->
                <form id="update-player-form" method="post" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label for="current-password" class="form-label">Current password</label>
                        <input type="password" class="form-control" name="currentPassword" id="current-password" required>
                    </div>
                    <div class="mb-3">
                        <label for="new-password" class="form-label">New password</label>
                        <input type="password" class="form-control" name="newPassword" id="new-password" required>
                    </div>
                    <div class="mb-3">
                        <label for="retype-new-password" class="form-label">Retype new password</label>
                        <input type="password" class="form-control" name="retypedNewPassword" id="retype-new-password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Edit</button>
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

                $.post("../api/UpdatePassword.php", {currentPassword: currentPassword, newPassword: newPassword, retypedNewPassword: retypedNewPassword}, function(response) {
                    if (response === "1") {
                        $(".toast").addClass('text-bg-success');
                        $(".toast").removeClass('text-bg-danger');
                        $(".toast").toast('show');
                        $(".toast-body").html("Your password has been successfully updated.");
                    } else {
                        $(".toast").removeClass('text-bg-success');
                        $(".toast").addClass('text-bg-danger');
                        $(".toast").toast('show');
                        $(".toast-body").html(response);
                    }
                });
                return false;
            });
        });
    </script>
</html>
