<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm border-bottom px-4">
    <div class="container-fluid">
        <form class="d-flex me-3">
            <input class="form-control form-control-sm me-2" type="search" placeholder="Search..." aria-label="Search">
        </form>
        <ul class="navbar-nav ms-auto align-items-center">
            <li class="nav-item dropdown me-3">
                <a class="nav-link position-relative" href="#" id="notificationsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-bell fs-5"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">3</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationsDropdown">
                    <li><a class="dropdown-item" href="#">No new notifications</a></li>
                </ul>
            </li>
            <li class="nav-item me-3">
                <button class="btn btn-outline-secondary btn-sm" id="darkModeToggle"><i class="bi bi-moon"></i></button>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'User') }}" class="rounded-circle me-2" width="32" height="32" alt="User">
                    <span>{{ auth()->user()->name ?? 'User' }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
                </ul>
            </li>
        </ul>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
    </div>
</nav>