<?php

if (isset($_SESSION["player_id"])) {
    ?>
        <script>
            /**
             * This function updates the current player's activity every 5s
             */
            setInterval(function(){
                $(function(){
                    $.get("api/v1/player/updateActivity", function(response) {
                    });
                });
            }, 5000);
        </script>
    <?php
}
