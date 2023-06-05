<?php
    session_start();
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

        <div class="offcanvas offcanvas-start" data-bs-scroll="false" tabindex="-1" id="sidebar" aria-labelledby="sidebar-label">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="sidebar-label">Settings</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                Account
                <ul class="nav flex-column mb-3">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Edit my information</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Change password</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Delete my account</a>
                    </li>
                </ul>
                Others
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Logout</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Back to lobby</a>
                    </li>
                </ul>
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
                let playerId = <?= $_SESSION['player_id'] ?>;
                let newUsername = $(this).find("input[name=newUsername]").val();
                let newEmail = $(this).find("input[name=newEmail]").val();

                $.post("../api/UpdatePlayer.php", {playerId: playerId, newUsername: newUsername, newEmail: newEmail}, function(response) {
                    if (response === "1") {
                        $(".toast").addClass('text-bg-success');
                        $(".toast").removeClass('text-bg-danger');
                        $(".toast").toast('show');
                        $(".toast-body").html("Your information has been successfully updated.");
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

        function showSidebar() {
            new bootstrap.Offcanvas($("#sidebar"), {backdrop: false}).show();
        }
        showSidebar();
    </script>
</html>
