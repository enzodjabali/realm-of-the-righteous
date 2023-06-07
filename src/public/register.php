<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Realm Of The Righteous - Register</title>
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

        <!--Toast gets displayed with an error message if mistakes have been made in the form -->
        <div class="toast align-items-center text-bg-danger border-0 position-absolute top-0 start-50 translate-middle mt-5" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body"></div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>

        <!-- Modal gets displayed if the user has been successfully registered -->
        <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalLabel">Woo-hoo</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        You have been successfully registered.
                        <br>
                        A verification email has been sent to you.
                    </div>
                    <div class="modal-footer">
                        <a href="/login"><button type="button" class="btn btn-primary">Login</button></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card w-75 position-absolute top-50 start-50 translate-middle">
            <div class="card-header text-center">
                Register
            </div>
            <div class="card-body">
                <!--Registration form-->
                <form id="register-form" method="post" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" id="username" placeholder="Mark" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="mark@realm-of-the-righteous.fr" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" id="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="retype-password" class="form-label">Retype password</label>
                        <input type="password" class="form-control" name="retype-password" id="retype-password" required>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="terms" id="terms" required>
                            <label class="form-check-label" for="terms">
                                Agree to terms and conditions
                            </label>
                            <div class="invalid-feedback">
                                You must agree before submitting.
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Register</button>
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
         * This function calls the register player method
         */
        $(function(){
            $("#register-form").submit(function(){
                let username = $(this).find("input[name=username]").val();
                let password = $(this).find("input[name=password]").val();
                let retypedPassword = $(this).find("input[name=retype-password]").val();
                let email = $(this).find("input[name=email]").val();
                let terms = $(this).find("input[name=terms]").is(":checked");

                $.post("api/RegisterPlayer.php", {username: username, password: password, retypedPassword: retypedPassword, email: email, terms: terms}, function(response) {
                    if (response === "1") {
                        $('#modal').modal('show');
                    } else {
                        $(document).ready(function() {
                            $(".toast").toast('show');
                            $(".toast-body").html(response);
                        });
                    }
                });
                return false;
            });
        });
    </script>
</html>
