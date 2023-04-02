<?php
    session_start();
    echo "My ID:" . $_SESSION["player_id"];

    if ($_SESSION["player_id"]) {
        echo "<br>You're connected!";
    }
