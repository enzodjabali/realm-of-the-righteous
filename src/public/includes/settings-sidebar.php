<div class="offcanvas offcanvas-start" data-bs-scroll="false" tabindex="-1" id="sidebar" aria-labelledby="sidebar-label">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="sidebar-label">Settings</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        Account
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
        Others
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="/logout">Logout</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/lobby">Back to lobby</a>
            </li>
        </ul>
    </div>
</div>

<script>
    function showSidebar() {
        new bootstrap.Offcanvas($("#sidebar"), {backdrop: false}).show();
    }
</script>
