<?php
    declare(strict_types = 1);
    $sessionId = $_SESSION["playerId"] ?? 0;

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
                                    <a class="nav-user"><?= $_SESSION["playerUsername"] . " (" . $_SESSION["playerId"] . ")" ?> -</a>
                                    <a href="/logout">Logout <i class="bi bi-box-arrow-in-right"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </header>
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
