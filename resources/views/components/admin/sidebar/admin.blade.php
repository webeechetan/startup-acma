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
        <li class="menu-item {{ active('admin.dashboard', 'active') }}">
            <a href="{{ route('admin.dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-dashboard"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        <li class="menu-item {{ active('seasons*', 'active open') }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-calendar"></i>
                <div data-i18n="Layouts">Seasons</div>
            </a>

            <menu class="menu-sub">
                <li class="menu-item {{ active('seasons.index', 'active') }}">
                    <a href="{{ route('seasons.index') }}" class="menu-link">
                        <div data-i18n="Without navbar">View All Seasons</div>
                    </a>
                </li>
                <li class="menu-item {{ active('seasons.create', 'active') }}">
                    <a href="{{ route('seasons.create') }}" class="menu-link">
                        <div data-i18n="Without menu">Add Season</div>
                    </a>
                </li>
            </menu>
        </li>

        <li class="menu-item {{ active('pilots*', 'active open') }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bxs-business"></i>
                <div data-i18n="Layouts">Pilots</div>
            </a>

            <menu class="menu-sub">
                <li class="menu-item {{ active('pilots.index', 'active') }}">
                    <a href="{{ route('pilots.index') }}" class="menu-link">
                        <div data-i18n="Without navbar">View All Companies</div>
                    </a>
                </li>
                <li class="menu-item {{ active('pilots.create', 'active') }}">
                    <a href="{{ route('pilots.create') }}" class="menu-link">
                        <div data-i18n="Without menu">Add Company</div>
                    </a>
                </li>

                <hr class="mx-4">

                <li class="menu-item {{ active('pilots.users.index', 'active') }}">
                    <a href="{{ route('pilots.users.index') }}" class="menu-link">
                        <div data-i18n="Without navbar">View All Users</div>
                    </a>
                </li>
                <li class="menu-item {{ active('pilots.users.create', 'active') }}">
                    <a href="{{ route('pilots.users.create') }}" class="menu-link">
                        <div data-i18n="Without menu">Add User</div>
                    </a>
                </li>

                <hr class="mx-4">

                <li class="menu-item {{ active('pilots.categories.index', 'active') }}">
                    <a href="{{ route('pilots.categories.index') }}" class="menu-link">
                        <div data-i18n="Without navbar">View All Categories</div>
                    </a>
                </li>
                <li class="menu-item {{ active('pilots.categories.create', 'active') }}">
                    <a href="{{ route('pilots.categories.create') }}" class="menu-link">
                        <div data-i18n="Without menu">Add Category</div>
                    </a>
                </li>
            </menu>
        </li>

        <li class="menu-item {{ active('startups*', 'active open') }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bxs-business"></i>
                <div data-i18n="Layouts">Startups</div>
            </a>

            <menu class="menu-sub">
                <li class="menu-item {{ active('startups.index', 'active') }}">
                    <a href="{{ route('startups.index') }}" class="menu-link">
                        <div data-i18n="Without navbar">View All Companies</div>
                    </a>
                </li>
                <li class="menu-item {{ active('startups.create', 'active') }}">
                    <a href="{{ route('startups.create') }}" class="menu-link">
                        <div data-i18n="Without navbar">Add Company</div>
                    </a>
                </li>
            </menu>
        </li>

        <li class="menu-item {{ active('case-studies*', 'active open') }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bxs-report"></i>
                <div data-i18n="Layouts">Case Studies</div>
            </a>

            <menu class="menu-sub">
                <li class="menu-item {{ active('case-studies.index', 'active') }}">
                    <a href="{{ route('case-studies.index') }}" class="menu-link">
                        <div data-i18n="Without navbar">View All Case Studies</div>
                    </a>
                </li>
                <li class="menu-item {{ active('case-studies.create', 'active') }}">
                    <a href="{{ route('case-studies.create') }}" class="menu-link">
                        <div data-i18n="Without menu">Add Case Study</div>
                    </a>
                </li>
            </menu>
        </li>

        <li class="menu-item {{ active('knowledge-sharings*', 'active open') }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bxs-report"></i>
                <div data-i18n="Layouts">Knowledge Sharings</div>
            </a>

            <menu class="menu-sub">
                <li class="menu-item {{ active('knowledge-sharings.index', 'active') }}">
                    <a href="{{ route('knowledge-sharings.index') }}" class="menu-link">
                        <div data-i18n="Without navbar">View All Knowledge Sharings</div>
                    </a>
                </li>
                <li class="menu-item {{ active('knowledge-sharings.create', 'active') }}">
                    <a href="{{ route('knowledge-sharings.create') }}" class="menu-link">
                        <div data-i18n="Without menu">Add Knowledge Sharing</div>
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
                    <a href="#" class="menu-link">
                        <div data-i18n="Without navbar">View All Events</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <div data-i18n="Without menu">Add Event</div>
                    </a>
                </li>
            </menu>
        </li>

        <li class="menu-item {{ active('contacts*', 'active open') }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-message"></i>
                <div data-i18n="Layouts">Contacts</div>
            </a>

            <menu class="menu-sub">
                <li class="menu-item {{ active('contacts.index', 'active') }}">
                    <a href="{{ route('contacts.index') }}" class="menu-link">
                        <div data-i18n="Without navbar">View All Contacts</div>
                    </a>
                </li>
                <li class="menu-item {{ active('contacts.create', 'active') }}">
                    <a href="{{ route('contacts.create') }}" class="menu-link">
                        <div data-i18n="Without menu">Add Contact</div>
                    </a>
                </li>
            </menu>
        </li>
    </menu>
</aside>
