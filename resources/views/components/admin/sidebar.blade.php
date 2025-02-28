<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="/" class="h-px-50">
            <img src="/logo.png" alt="App Logo" class="h-100">
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <menu class="menu-inner py-1">
        <li class="menu-item active">
            <a href="/admin/dashboard" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="Layouts">Users</div>
            </a>

            <menu class="menu-sub">
                <li class="menu-item">
                    <a href="/admin/users" class="menu-link">
                        <div data-i18n="Without navbar">All Users</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="/admin/users/add" class="menu-link">
                        <div data-i18n="Without menu">New User</div>
                    </a>
                </li>
            </menu>
        </li>


    </menu>
</aside>
