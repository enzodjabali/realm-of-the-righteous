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
        <title>Realm Of The Righteous - My Account</title>
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
                Edit my information
            </div>
            <div class="card-body">
                <!-- Update player form-->
                <form id="update-player-form" method="post" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label for="newUsername" class="form-label">Username</label>
                        <input type="text" class="form-control shadow-none" name="newUsername" id="newUsername" placeholder="<?= $_SESSION['playerUsername'] ?>" value="<?= $_SESSION['playerUsername'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="newEmail" class="form-label">Email address</label>
                        <input type="email" class="form-control shadow-none" name="newEmail" id="newEmail" placeholder="<?= $_SESSION['playerEmail'] ?>" value="<?= $_SESSION['playerEmail'] ?>" required>
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
         * This function calls the update player method
         */
        $(function(){
            $("#update-player-form").submit(function(){
                let currentUsername = "<?= $_SESSION['playerUsername'] ?>";
                let currentEmail = "<?= $_SESSION['playerEmail'] ?>";
                let newUsername = $(this).find("input[name=newUsername]").val();
                let newEmail = $(this).find("input[name=newEmail]").val();

                $.post("../api/v1/player/update", {currentUsername: currentUsername, currentEmail: currentEmail, newUsername: newUsername, newEmail: newEmail}, function() {
                    $(".toast").addClass('text-bg-valid');
                    $(".toast").removeClass('text-bg-danger');
                    $(".toast").toast('show');
                    $(".toast-body").html("Your information has been successfully updated.");
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
