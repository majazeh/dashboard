<div id="topbar" class="d-flex justify-content-between align-items-center px-3 topbar" data-xhr="topbar">
    <div id="branding-logo" class="d-sm-none d-flex align-items-center justify-content-center branding branding-logo">
        <a class="branding-logo-img" href="#">
            <img src="/images/cube.png" alt="cube" width="50" height="50">
        </a>
    </div>
    <div class="topbar-actions" data-xhr="topbar-actions">
        @yield('topbar-actions')
    </div>
    <div class="topbar-profile">
        <div class="rounded-circle topbar-profile-icon">
            <img src="/images/user.png" width="32" height="32">
        </div>
    </div>
</div>