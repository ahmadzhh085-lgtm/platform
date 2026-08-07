<header class="header header-sticky border-bottom bg-white shadow-sm">
    <div class="container-fluid d-flex justify-content-between align-items-center px-4 py-3">
        <div>
            <h4 class="mb-0 fw-semibold text-dark">@yield('title', 'Dashboard')</h4>
            <small class="text-muted">Investment platform overview</small>
        </div>

        <div class="d-flex align-items-center gap-2">
            <form class="d-none d-lg-flex">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span>
                    <input class="form-control border-0 bg-light" type="search" placeholder="Search..." aria-label="Search">
                </div>
            </form>

            <button class="btn btn-outline-secondary btn-sm" type="button">
                <i class="bi bi-bell"></i>
            </button>

            <div class="dropdown">
                <a class="d-flex align-items-center gap-2 text-decoration-none dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'User') }}" class="rounded-circle" width="36" height="36" alt="User">
                    <span class="fw-semibold text-dark">{{ auth()->user()->name ?? 'User' }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
</header>