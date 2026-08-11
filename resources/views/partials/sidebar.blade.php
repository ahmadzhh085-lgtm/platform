<div class="sidebar sidebar-dark sidebar-fixed border-end" id="sidebar">
    <div class="sidebar-header border-bottom border-white border-opacity-10 px-3 py-4">
        <div class="d-flex align-items-center gap-3">
            <div class="rounded-circle bg-primary bg-opacity-10 p-2 text-primary">
                <i class="bi bi-pie-chart-fill fs-5"></i>
            </div>
            <div class="sidebar-brand-text">
                <div class="fw-bold text-white">InvestHub</div>
                <small class="text-white-50">Admin Panel</small>
            </div>
        </div>
    </div>

    <ul class="sidebar-nav mt-3">
        <li class="nav-title px-3 text-uppercase small text-white-50">Main</li>
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-speedometer2 me-2"></i>
                <span class="sidebar-link-text">Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}" href="{{ route('admin.projects.index') }}">
                <i class="bi bi-building me-2"></i>
                <span class="sidebar-link-text">Projects</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center {{ request()->routeIs('admin.properties.*') ? 'active' : '' }}" href="{{ route('admin.properties.index') }}">
                <i class="bi bi-house-door me-2"></i>
                <span class="sidebar-link-text">Properties</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center {{ request()->routeIs('admin.investors.*') ? 'active' : '' }}" href="{{ route('admin.investors.index') }}">
                <i class="bi bi-people me-2"></i>
                <span class="sidebar-link-text">Investors</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center {{ request()->routeIs('admin.investments.*') ? 'active' : '' }}" href="{{ route('admin.investments.index') }}">
                <i class="bi bi-cash-stack me-2"></i>
                <span class="sidebar-link-text">Investments</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}" href="{{ route('admin.payments.index') }}">
                <i class="bi bi-credit-card me-2"></i>
                <span class="sidebar-link-text">Payments</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center {{ request()->routeIs('admin.employees.*') ? 'active' : '' }}" href="{{ route('admin.employees.index') }}">
                <i class="bi bi-person-badge me-2"></i>
                <span class="sidebar-link-text">Employees</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}" href="{{ route('admin.reports.index') }}">
                <i class="bi bi-bar-chart-line me-2"></i>
                <span class="sidebar-link-text">Reports</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center {{ request()->routeIs('admin.settings') ? 'active' : '' }}" href="{{ route('admin.settings') }}">
                <i class="bi bi-gear me-2"></i>
                <span class="sidebar-link-text">Settings</span>
            </a>
        </li>
    </ul>
</div>