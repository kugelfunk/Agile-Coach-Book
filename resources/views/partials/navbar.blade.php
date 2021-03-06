<div class="navbar w-nav" data-animation="over-right" data-collapse="medium" data-duration="400">
    <div class="w-container">
        <a class="w-nav-brand" href="/"><img src="/images/turbine-logo.png" alt="Turbine Kreuzberg Agile Coach App"></a>
        <nav class="nav-menu w-nav-menu" role="navigation">
            <a class="nav-link w-nav-link" href="/">Home</a>
            <div class="w-dropdown" data-delay="0" data-hover="1">
                <div class="nav-link w-dropdown-toggle">
                    <div>Coaches</div>
                    <div class="w-icon-dropdown-toggle"></div>
                </div>
                <nav class="w-dropdown-list">
                    <a class="w-dropdown-link" href="/coaches">All Coaches</a>
                    <a class="w-dropdown-link" href="/coaches/create">New Coach</a>
                </nav>
            </div>
            <div class="w-dropdown" data-delay="0" data-hover="1">
                <div class="nav-link w-dropdown-toggle">
                    <div>Teams</div>
                    <div class="w-icon-dropdown-toggle"></div>
                </div>
                <nav class="w-dropdown-list">
                    <a class="w-dropdown-link" href="/teams">All Teams</a>
                    <a class="w-dropdown-link" href="/teams/create">New Team</a>
                </nav>
            </div>
            <div class="w-dropdown" data-delay="0" data-hover="1">
                <div class="nav-link w-dropdown-toggle">
                    <div>Members</div>
                    <div class="w-icon-dropdown-toggle"></div>
                </div>
                <nav class="w-dropdown-list">
                    <a class="w-dropdown-link" href="/members">All Members</a>
                    <a class="w-dropdown-link" href="/members/create">New Member</a>
                </nav>
            </div>
            <div class="w-dropdown" data-delay="0" data-hover="1">
                <div class="nav-link w-dropdown-toggle">
                    <div>Meetings</div>
                    <div class="w-icon-dropdown-toggle"></div>
                </div>
                <nav class="w-dropdown-list">
                    <a class="w-dropdown-link" href="/meetings">All Meetings</a>
                    <a class="w-dropdown-link" href="/meetings/create">New Meeting</a>
                </nav>
            </div>
            <div class="w-dropdown" data-delay="0" data-hover="1">
                <div class="nav-link w-dropdown-toggle">
                    <div>Tasks</div>
                    <div class="w-icon-dropdown-toggle"></div>
                </div>
                <nav class="w-dropdown-list">
                    <a class="w-dropdown-link" href="/tasks">All Tasks</a>
                    <a class="w-dropdown-link" href="/tasks/create">New Task</a>
                </nav>
            </div>
            @if (Auth::check())
                <a class="nav-link w-nav-link" href="/logout">Logout {{Auth::user()->name}}</a>
            @else
                <a class="nav-link w-nav-link" href="/login">Login / Register</a>
            @endif
        </nav>
        <div class="menu-button w-nav-button">
            <div class="w-icon-nav-menu"></div>
        </div>
    </div>
</div>