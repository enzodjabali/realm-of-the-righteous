<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Realm Of The Righteous - Delete my account</title>
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

        <!-- Modal gets displayed to ask the user if he's sure that he wants to delete his account -->
        <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalLabel">Oh no..</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to permanently delete your account?
                    </div>
                    <div class="modal-footer">
                        <button onclick="deletePlayer()" type="button" class="btn btn-danger"><i class="bi bi-trash-fill"></i> Delete permanently</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card w-75 position-absolute top-50 start-50 translate-middle">
            <div class="card-header text-center">
                Delete my account
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <a>Username: <?= $_SESSION["player_username"] ?></a>
                    <br>
                    <a>Email: <?= $_SESSION["player_email"] ?></a>
                    <p class="mt-2">
                        Deleting your account will also delete:<br>
                        &nbsp - Your games<br>
                        &nbsp - Your game progresses<br>
                        &nbsp - Your messages<br>
                    </p>
                </div>
                <button onclick="$('#modal').modal('show');" type="submit" class="btn btn-danger"><i class="bi bi-trash-fill"></i> Delete permanently</button>
            </div>
        </div>

        <?php include_once("includes/footer.php") ?>
    </body>

    <script>
        /**
         * This function calls the delete player method
         */
        function deletePlayer() {
            $(function(){
                $.post("../api/DeletePlayer.php", {playerId: <?= $_SESSION['player_id'] ?>}, function(response) {
                    if (response === "1") {
                        location.href = '/logout.php';
                    }
                });
                return false;
            });
        }
    </script>
</html>
