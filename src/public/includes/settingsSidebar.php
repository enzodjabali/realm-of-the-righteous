<?php
    $sessionIsAdmin = isset($_SESSION["playerIsAdmin"]) ? (bool)$_SESSION["playerIsAdmin"] : "";
?>

<nav class="navbar navbar-dark">
    <div class="container-fluid">
        <button class="navbar-toggler" onclick="showSidebar()" type="button" data-bs-toggle="collapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>

<div class="offcanvas offcanvas-start" data-bs-scroll="false" tabindex="-1" id="sidebar" aria-labelledby="sidebar-label">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="sidebar-label">Settings</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <a>Account</a>
        <ul class="nav flex-column mb-3">
            <li class="nav-item">
                <a class="nav-link" href="/settings/account">Edit my information</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/settings/password">Change password</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/settings/delete">Delete my account</a>
            </li>
        </ul>
        <?php if ($sessionIsAdmin) { ?>
            <a>Admin</a>
            <ul class="nav flex-column mb-3">
                <li class="nav-item">
                    <a class="nav-link" href="/settings/banishments">Banishments</a>
                </li>
            </ul>
        <?php } ?>
        <a>Others</a>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="/lobby">Back to lobby</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/logout">Logout <i class="bi bi-box-arrow-in-right"></i></a>
            </li>
        </ul>
    </div>
</div>

<script>
    function showSidebar() {
        new bootstrap.Offcanvas($("#sidebar"), {backdrop: false}).show();
    }
</script>
