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
        <title>Realm Of The Righteous - My Account</title>
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
                Edit my information
            </div>
            <div class="card-body">
                <!-- Update player form-->
                <form id="update-player-form" method="post" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label for="newUsername" class="form-label">Username</label>
                        <input type="text" class="form-control" name="newUsername" id="newUsername" placeholder="<?= $_SESSION['player_username'] ?>" value="<?= $_SESSION['player_username'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="newEmail" class="form-label">Email address</label>
                        <input type="email" class="form-control" name="newEmail" id="newEmail" placeholder="<?= $_SESSION['player_email'] ?>" value="<?= $_SESSION['player_email'] ?>" required>
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
         * This function calls the update player method
         */
        $(function(){
            $("#update-player-form").submit(function(){
                let currentUsername = "<?= $_SESSION['player_username'] ?>";
                let currentEmail = "<?= $_SESSION['player_email'] ?>";
                let newUsername = $(this).find("input[name=newUsername]").val();
                let newEmail = $(this).find("input[name=newEmail]").val();

                $.post("../api/v1/player/update", {currentUsername: currentUsername, currentEmail: currentEmail, newUsername: newUsername, newEmail: newEmail}, function() {
                    $(".toast").addClass('text-bg-success');
                    $(".toast").removeClass('text-bg-danger');
                    $(".toast").toast('show');
                    $(".toast-body").html("Your information has been successfully updated.");
                }).fail(function(response) {
                    $(".toast").removeClass('text-bg-success');
                    $(".toast").addClass('text-bg-danger');
                    $(".toast").toast('show');
                    $(".toast-body").html(JSON.parse(response.responseText).response);
                });
                return false;
            });
        });
    </script>
</html>
