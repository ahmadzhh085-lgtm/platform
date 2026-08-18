<aside class="sidebar sidebar-dark border-end" id="sidebar">
    <div class="sidebar-header border-bottom border-white border-opacity-10 px-3 py-4">
        <div class="d-flex align-items-center justify-content-between gap-3">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle bg-primary bg-opacity-10 p-2 text-primary">
                    <i class="bi bi-pie-chart-fill fs-5"></i>
                </div>
                <div class="brand-text">
                    <div class="fw-bold text-white">InvestHub</div>
                    <small class="text-white-50">Admin Panel</small>
                </div>
            </div>

            <button class="sidebar-close d-lg-none" type="button" aria-label="Close sidebar">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
    </div>

    <ul class="sidebar-nav mt-3">
        <li class="nav-title px-3 text-uppercase small text-white-50">Main</li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}" href="{{ route('admin.projects.index') }}">
                <i class="bi bi-building"></i> <span>Projects</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.properties.*') ? 'active' : '' }}" href="{{ route('admin.properties.index') }}">
                <i class="bi bi-house-door"></i> <span>Properties</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.investors.*') ? 'active' : '' }}" href="{{ route('admin.investors.index') }}">
                <i class="bi bi-people"></i> <span>Investors</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.investments.*') ? 'active' : '' }}" href="{{ route('admin.investments.index') }}">
                <i class="bi bi-cash-stack"></i> <span>Investments</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}" href="{{ route('admin.payments.index') }}">
                <i class="bi bi-credit-card"></i> <span>Payments</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.purchase-requests.*') ? 'active' : '' }}" href="{{ route('admin.purchase-requests.index') }}">
                <i class="bi bi-bag-check"></i> <span>Purchase Requests</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.property-sale-requests.*') ? 'active' : '' }}" href="{{ route('admin.property-sale-requests.index') }}">
                <i class="bi bi-house-heart"></i> <span>Sale Requests</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.employees.*') ? 'active' : '' }}" href="{{ route('admin.employees.index') }}">
                <i class="bi bi-person-badge"></i> <span>Employees</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}" href="{{ route('admin.reports.index') }}">
                <i class="bi bi-bar-chart-line"></i> <span>Reports</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}" href="{{ route('admin.settings') }}">
                <i class="bi bi-gear"></i> <span>Settings</span>
            </a>
        </li>
    </ul>
</aside>

<div class="sidebar-backdrop" id="sidebarBackdrop"></div>