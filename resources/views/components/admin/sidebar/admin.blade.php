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

    <menu class="menu-inner py-3">
        <li class="menu-item {{ active('admin.dashboard','active') }}">
            <a href="/admin/dashboard" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-dashboard"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        <li class="menu-item {{ active('seasons*','active open') }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-calendar"></i>
                <div data-i18n="Layouts">Seasons</div>
            </a>

            <menu class="menu-sub">
                <li class="menu-item {{ active('seasons.index','active') }}">
                    <a href="{{ route('seasons.index') }}" class="menu-link">
                        <div data-i18n="Without navbar">View All Seasons</div>
                    </a>
                </li>
                <li class="menu-item {{ active('seasons.create','active') }}">
                    <a href="/admin/seasons/create" class="menu-link">
                        <div data-i18n="Without menu">Add Season</div>
                    </a>
                </li>
            </menu>
        </li>

        <li class="menu-item {{ active('pilots*','active open') }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bxs-business"></i>
                <div data-i18n="Layouts">Pilots</div>
            </a>

            <menu class="menu-sub">
                <li class="menu-item {{ active('pilots.index','active') }}">
                    <a href="/admin/pilots"  class="menu-link">
                        <div data-i18n="Without navbar">View All Companies</div>
                    </a>
                </li>
                <li class="menu-item {{ active('pilots.create','active') }}">
                    <a href="/admin/pilots/create" class="menu-link">
                        <div data-i18n="Without menu">Add Company</div>
                    </a>
                </li>

                <hr class="mx-4">

                <li class="menu-item {{ active('pilots.users.index','active') }}">
                    <a href="/admin/pilots/users" class="menu-link">
                        <div data-i18n="Without navbar">View All Users</div>
                    </a>
                </li>
                <li class="menu-item {{ active('pilots.users.create','active') }}">
                    <a href="/admin/pilots/users/create" class="menu-link">
                        <div data-i18n="Without menu">Add User</div>
                    </a>
                </li>
                
                <hr class="mx-4">

                <li class="menu-item {{ active('pilots.categories.index','active') }}">
                    <a href="/admin/pilots/categories" class="menu-link">
                        <div data-i18n="Without navbar">View All Categories</div>
                    </a>
                </li>
                <li class="menu-item {{ active('pilots.categories.create','active') }}">
                    <a href="/admin/pilots/categories/create" class="menu-link">
                        <div data-i18n="Without menu">Add Category</div>
                    </a>
                </li>
            </menu>
        </li>

        <li class="menu-item {{ active('startups*','active open') }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bxs-business"></i>
                <div data-i18n="Layouts">Startups</div>
            </a>

            <menu class="menu-sub">
                <li class="menu-item {{ active('startups.index','active') }}">
                    <a href="/admin/startups" class="menu-link">
                        <div data-i18n="Without navbar">View All Startups</div>
                    </a>
                </li>
            </menu>
        </li>

        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bxs-report"></i>
                <div data-i18n="Layouts">Case Studies</div>
            </a>

            <menu class="menu-sub">
                <li class="menu-item">
                    <a href="/admin/case-studies" class="menu-link">
                        <div data-i18n="Without navbar">View All Case Studies</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="/admin/case-studies/create" class="menu-link">
                        <div data-i18n="Without menu">Add Case Study</div>
                    </a>
                </li>
            </menu>
        </li>

        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bxs-report"></i>
                <div data-i18n="Layouts">Workshops</div>
            </a>

            <menu class="menu-sub">
                <li class="menu-item">
                    <a href="/admin/knowledge-sharing" class="menu-link">
                        <div data-i18n="Without navbar">View All Workshops</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="/admin/knowledge-sharing/create" class="menu-link">
                        <div data-i18n="Without menu">Add Workshop</div>
                    </a>
                </li>
            </menu>
        </li>

        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-calendar-event"></i>
                <div data-i18n="Layouts">Events</div>
            </a>

            <menu class="menu-sub">
                <li class="menu-item">
                    <a href="/admin/events" class="menu-link">
                        <div data-i18n="Without navbar">View All Events</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="/admin/events/create" class="menu-link">
                        <div data-i18n="Without menu">Add Event</div>
                    </a>
                </li>
            </menu>
        </li>
    </menu>
</aside>
