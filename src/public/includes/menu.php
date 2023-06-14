<?php
    declare(strict_types = 1);

    $sessionId = isset($_SESSION["playerId"]) ? (int)$_SESSION["playerId"] : 0;
    $sessionUsername = isset($_SESSION["playerUsername"]) ? (string)$_SESSION["playerUsername"] : "";
    $sessionEmail = isset($_SESSION["playerEmail"]) ? (string)$_SESSION["playerEmail"] : "";

    if ($sessionId > 0) {
        ?>
            <header>
                <nav class="navbar navbar-expand-lg navbar-dark z-1">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="/">
                            <img src="assets/images/website/logo.png" width="30">
                        </a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse navbarScroll" id="navbarText">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                <li class="nav-item">
                                    <a class="nav-link" href="/lobby">Lobby</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/chat">Chat</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/leaderboard">Leaderboard</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/about">About</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/credits">Credits</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/settings/account">Settings</a>
                                </li>
                            </ul>
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <button class="btn btn-form-submit" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"><i class="bi bi-chat-left-text"></i></button>
                                    <button class="btn btn-form-submit" onclick="$('#player-modal').modal('show');"><i class="bi bi-person"></i></button>
                                    <a href="/logout" class="btn btn-form-submit">Logout <i class="bi bi-box-arrow-in-right"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </header>

            <!-- Modal gets displayed when the player wants to view his profile -->
            <div id="player-modal" class="modal fade" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                <div id="delete-game-id" class="visually-hidden"></div>
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="modalLabel">Player</h1>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            ID: <?= $sessionId ?><br>
                            Username: <?= $sessionUsername ?><br>
                            Email: <?= $sessionEmail ?>
                        </div>
                    </div>
                </div>
            </div>

            <?php include_once("privateChat.php") ?>

        <?php
    } else {
        ?>
            <header>
                <nav class="navbar navbar-expand-lg navbar-dark z-1">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="/">
                            <img src="assets/images/website/logo.png" width="30">
                        </a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link" href="/login">Login</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/register">Register</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/about">About</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/credits">Credits</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </header>
        <?php
    }
