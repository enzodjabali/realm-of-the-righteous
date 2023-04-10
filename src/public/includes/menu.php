<?php
    declare(strict_types = 1);

    $sessionId = $_SESSION["player_id"] ?? 0;

    if ($sessionId > 0) {
        ?>
            <!-- Navbar (sticky bottom) -->
            <div class="w3-bottom w3-hide-small">
                <div class="w3-bar w3-black w3-center w3-padding w3-opacity-min">
                    <a href="/story" style="width:25%" class="w3-bar-item w3-button">The Story</a>
                    <a href="/lobby" style="width:50%" class="w3-bar-item w3-button">Lobby</a>
                    <a href="/credits" style="width:25%" class="w3-bar-item w3-button">Credits</a>
                </div>
            </div>
        <?php

    } else {
        ?>
            <!-- Navbar (sticky bottom) -->
            <div class="w3-bottom w3-hide-small">
                <div class="w3-bar w3-black w3-center w3-padding w3-opacity-min">
                    <a href="/login" style="width:25%" class="w3-bar-item w3-button">Login</a>
                    <a href="/register" style="width:25%" class="w3-bar-item w3-button">Register</a>
                    <a href="/story" style="width:25%" class="w3-bar-item w3-button">The Story</a>
                    <a href="/credits" style="width:25%" class="w3-bar-item w3-button">Credits</a>
                </div>
            </div>
        <?php
    }
